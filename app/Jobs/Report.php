<?php

namespace App\Jobs;

use App\Exports\VotersExport;
use Carbon\Carbon;
use App\Models\Tps;
use App\Models\Voter;
use App\Models\Village;
use App\Models\District;
use Illuminate\Bus\Queueable;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class Report implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $backoff = 3;
    public $tries = 1;
    public $timeout = 0;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public $type,
        public $district = 'semua',
        public $village = 'semua',
        public $tps = 'semua',
        public $team = 'semua',
        public $filename,
        public $path,
        public $view,
        public $paper,
        public $payload,
        public $history
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->type == 'counter') {
            $data = $this->get_counter_data();

            PDF::loadView($this->view, [...$this->payload, 'data' => $data])
                ->setPaper($this->paper['paper'], $this->paper['orientation'])
                ->save($this->path, 'public');
        }
        if ($this->type == 'voters') {
            $this->get_voters_data();
        }

        $this->history->update(
            [
                'status' => 'completed'
            ]
        );
    }

    public function failed(?\Throwable $exception): void
    {
        $this->history->update(
            [
                'status' => 'failed'
            ]
        );
    }

    protected function get_counter_data()
    {
        $voters_all_count =  District::withCount('voters')
            ->when($this->district != 'semua', fn($q) => $q->whereIn('id', $this->district))
            ->get()
            ->sum('voters_count');
        $voters_all_total = District::withCount('dpts')
            ->when($this->district != 'semua', fn($q) => $q->whereIn('id', $this->district))
            ->get()
            ->sum('dpts_count');

        $total_count_voters = District::select('id', 'name')
            ->with('tpses')
            ->withCount('voters', 'dpts')
            ->when($this->district != 'semua', fn($q) => $q->whereIn('id', $this->district))
            ->get()
            ->map(function ($district) {
                return [
                    'id' => $district->id,
                    'name' => $district->name,
                    'voters_count' => $district->voters_count,
                    'voters_total' => $district->dpts_count,
                    'villages' => Village::select('id', 'name')
                        ->where('district_id', $district->id)
                        ->withCount('voters', 'dpts')
                        ->get()
                        ->map(function ($village) {
                            return [
                                'id' => $village->id,
                                'name' => $village->name,
                                'voters_count' => $village->voters_count,
                                'voters_total' => $village->dpts_count,
                                'tpses' => Tps::select('id', 'name', 'voters_total')
                                    ->where('village_id', $village->id)
                                    ->withCount('voters', 'dpts')
                                    ->get()
                                    ->map(function ($tps) {
                                        return [
                                            'id' => $tps->id,
                                            'name' => $tps->name,
                                            'voters_count' => $tps->voters_count,
                                            'voters_total' => $tps->dpts_count,
                                        ];
                                    })
                                    ->toArray()
                            ];
                        })->toArray()
                ];
            });

        $voters_by_gender = Voter::selectRaw(
            'IFNULL(SUM(CASE WHEN gender = \'Laki-laki\' THEN 1 ELSE 0 END),0) AS \'Laki-laki\',' .
                'IFNULL(SUM(CASE WHEN gender = \'Perempuan\' THEN 1 ELSE 0 END),0) AS \'Perempuan\''
        )
            ->when($this->district != 'semua', fn($q) => $q->whereIn('district_id', $this->district))
            ->get()
            ->toArray()[0];

        $voters_by_profession = DB::table('professions', 'p')
            ->selectRaw('p.name, count(v.id) as voters_count')
            ->join('voters as v', 'v.profession_id', '=', 'p.id')
            ->groupBy('p.id')
            ->when($this->district != 'semua', fn($q) => $q->whereIn('v.district_id', $this->district))
            ->get()
            ->toArray();

        $voters_by_religion = DB::table('religions', 'r')
            ->selectRaw('r.name, count(v.id) as voters_count')
            ->join('voters as v', 'v.religion_id', '=', 'r.id')
            ->groupBy('r.id')
            ->when($this->district != 'semua', fn($q) => $q->whereIn('v.district_id', $this->district))
            ->get()
            ->toArray();

        $voters_by_nasionality = DB::table('nasionalities', 'n')
            ->selectRaw('n.name, count(v.id) as voters_count')
            ->join('voters as v', 'v.nasionality_id', '=', 'n.id')
            ->groupBy('n.id')
            ->when($this->district != 'semua', fn($q) => $q->whereIn('v.district_id', $this->district))
            ->get()
            ->toArray();

        $voters_by_marital_status = DB::table('marital_statuses', 'ms')
            ->selectRaw('ms.name, count(v.id) as voters_count')
            ->join('voters as v', 'v.marital_status_id', '=', 'ms.id')
            ->groupBy('ms.id')
            ->when($this->district != 'semua', fn($q) => $q->whereIn('v.district_id', $this->district))
            ->get()
            ->toArray();

        $start = Carbon::now()->subYears(25);
        $end = Carbon::now()->subYears(17);
        $age_17_25 = Voter::selectRaw('count(*) as voters_count')
            ->when($this->district != 'semua', fn($q) => $q->whereIn('district_id', $this->district))
            ->whereDate('date_of_birth', '>=', $start)
            ->whereDate('date_of_birth', '<=', $end);
        $age_17_25 = $age_17_25->first()->voters_count;

        $start = Carbon::now()->subYears(35);
        $end = Carbon::now()->subYears(25);
        $age_25_35 = Voter::selectRaw('count(*) as voters_count')
            ->when($this->district != 'semua', fn($q) => $q->whereIn('district_id', $this->district))
            ->whereDate('date_of_birth', '>=', $start)
            ->whereDate('date_of_birth', '<=', $end);
        $age_25_35 = $age_25_35->first()->voters_count;

        $start = Carbon::now()->subYears(45);
        $end = Carbon::now()->subYears(35);
        $age_35_45 = Voter::selectRaw('count(*) as voters_count')
            ->when($this->district != 'semua', fn($q) => $q->whereIn('district_id', $this->district))
            ->whereDate('date_of_birth', '>=', $start)
            ->whereDate('date_of_birth', '<=', $end);
        $age_35_45 = $age_35_45->first()->voters_count;

        $start = Carbon::now()->subYears(55);
        $end = Carbon::now()->subYears(45);
        $age_45_55 = Voter::selectRaw('count(*) as voters_count')
            ->when($this->district != 'semua', fn($q) => $q->whereIn('district_id', $this->district))
            ->whereDate('date_of_birth', '>=', $start)
            ->whereDate('date_of_birth', '<=', $end);
        $age_45_55 = $age_45_55->first()->voters_count;

        $end = Carbon::now()->subYears(55);
        $age_55_up = Voter::selectRaw('count(*) as voters_count')
            ->when($this->district != 'semua', fn($q) => $q->whereIn('district_id', $this->district))
            ->whereDate('date_of_birth', '<=', $end);
        $age_55_up = $age_55_up->first()->voters_count;

        // dd(
        //     $total_count_voters,
        //     $voters_all_total,
        //     $voters_all_count,
        //     $voters_by_gender,
        //     $voters_by_profession,
        //     $voters_by_religion,
        //     $voters_by_nasionality,
        //     $voters_by_marital_status,
        //     $age_17_25,
        //     $age_25_35,
        //     $age_35_45,
        //     $age_45_55,
        //     $age_55_up,
        // );

        return [
            'total_count_voters' => $total_count_voters,
            'voters_all_total' => $voters_all_total,
            'voters_all_count' => $voters_all_count,
            'voters_by_gender' => $voters_by_gender,
            'voters_by_profession' => $voters_by_profession,
            'voters_by_religion' => $voters_by_religion,
            'voters_by_nasionality' => $voters_by_nasionality,
            'voters_by_marital_status' => $voters_by_marital_status,
            'age_17_25' => $age_17_25,
            'age_25_35' => $age_25_35,
            'age_35_45' => $age_35_45,
            'age_45_55' => $age_45_55,
            'age_55_up' => $age_55_up,
        ];
    }

    protected function get_voters_data()
    {
        Excel::store(new VotersExport(
            team: $this->team
        ), $this->filename, 'public');
    }
}
