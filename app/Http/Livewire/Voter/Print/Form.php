<?php

namespace App\Http\Livewire\Voter\Print;

use Carbon\Carbon;
use App\Models\Tps;
use App\Jobs\Report;
use App\Models\User;
use App\Models\Village;
use Livewire\Component;
use App\Models\District;
use App\Models\PrintHistory;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Form extends Component
{
    use LivewireAlert;

    public $jenis_laporan;
    public $district, $village, $tps, $team;
    public $districts, $villages, $tpses, $teams;
    public $available_reports;
    public $all_districts = false;
    public $all_teams = false;

    public function mount()
    {
        $this->available_reports = [
            [
                'value' => 'counter',
                'title' => 'Data Perhitungan'
            ],
            [
                'value' => 'voters',
                'title' => 'Data Pemilih'
            ]
        ];

        $this->set_districts();
        $this->change_report();
    }

    public function render()
    {
        return view('livewire.voter.print.form');
    }

    public function rules()
    {
        return
            [
                'jenis_laporan' => [
                    'required',
                    Rule::in(collect($this->available_reports)->pluck('value')->toArray())
                ],
                'district' => [
                    'required',
                    Rule::in(...collect($this->districts)->pluck('id')->toArray())
                ],
                'village' => [
                    'required',
                    Rule::in(...collect($this->villages)->pluck('id')->toArray())
                ],
                'tps' => [
                    'required',
                    Rule::in(...collect($this->tpses)->pluck('id')->toArray())
                ]
            ];
    }

    public function print()
    {
        $district = $this->district === 'semua' ? 'Semua Kecamatan' : collect($this->districts)->firstWhere('id', $this->district)['text'];
        $village = $this->village === 'semua' ? 'Semua Kelurahan/Desa' : collect($this->villages)->firstWhere('id', $this->village)['text'];
        $tps = $this->tps === 'semua' ? 'Semua TPS' : collect($this->tpses)->firstWhere('id', $this->tps)['text'];
        $team = $this->team === 'semua' ? 'Semua Tim Bersinar' : collect($this->team)->map(fn($team) => collect($this->teams)->firstWhere('id', $team)['text'])->toArray();

        do {
            $unique_code = base64_encode(Carbon::now()->timestamp);
        } while (PrintHistory::where('unique_code', $unique_code)->count());

        $created_at = \Carbon\Carbon::now()->translatedFormat('d M Y H:i:s');

        if (in_array($this->jenis_laporan, ['counter', 'voters'])) {
            DB::beginTransaction();
            try {
                $paper = 'A4';
                $orientation = 'portrait';

                if ($this->jenis_laporan == 'counter') {
                    $filename = 'Data Perhitungan Pemilih.pdf';

                    $view = 'printout.counter';
                    $addition = [
                        'unique_code' => $unique_code,
                        'created_at' => $created_at
                    ];
                } else if ($this->jenis_laporan == 'voters') {
                    $filename = 'Data Pemilih.pdf';

                    $view = 'printout.voters';

                    $addition = [
                        'village' => $village,
                        'tps' => $tps,
                        'team' => collect($team)->join(', '),
                        'unique_code' => $unique_code,
                        'created_at' => $created_at,
                    ];

                    $orientation = 'landscape';
                }

                $payload = [
                    'district' => $district,
                ];

                if (!empty($addition))
                    $payload += $addition;

                $filename = $unique_code . '_' . Carbon::now()->timestamp . '_' . $filename;
                $path = '/' . $this->jenis_laporan . '/' . $filename;

                $translations = [
                    'counter' => 'Data Perhitungan',
                    'voters' => 'Data Pemilih',
                ];

                $paper = [
                    'paper' => $paper,
                    'orientation' => $orientation
                ];

                $history = PrintHistory::create([
                    'filename' => $filename,
                    'type' => !empty($translations[$this->jenis_laporan]) ? $translations[$this->jenis_laporan] : $this->jenis_laporan,
                    'path' => $path,
                    'unique_code' => $unique_code,
                    'payload' => json_encode($payload),
                    'user_id' => auth()->user()->id,
                    'status' => 'on_progress'
                ]);

                dispatch(new Report(
                    type: $this->jenis_laporan,
                    district: $this->district,
                    village: $this->village,
                    tps: $this->tps,
                    team: $this->team,
                    filename: $filename,
                    view: $view,
                    path: $path,
                    paper: $paper,
                    payload: $payload,
                    history: $history,
                ));

                DB::commit();
                $this->emit('refresh_print_history');
                $this->alert('success', 'Laporan berhasil didaftarkan ke antrian, silahkan pantau status laporan pada halaman ini.');
            } catch (\Exception $e) {
                DB::rollBack();
                $this->alert('error', $e->getMessage());
                return;
            } catch (\Throwable $e) {
                DB::rollBack();
                $this->alert('error', $e->getMessage());
                return;
            }
        } else {
            $this->alert('warning', 'Jenis Laporan tidak tersedia.');
        }
    }

    public function set_districts()
    {
        $districts = [
            ...District::get()->map(function ($q, $index) {
                $data = [
                    'id' => $q->id,
                    'text' => $q->name
                ];
                return $data;
            })
        ];
        if ($this->jenis_laporan == 'voters')
            array_unshift($districts, ['id' => 'semua', 'text' => 'Semua']);

        $this->districts = $districts;
    }

    public function set_villages()
    {
        $villages = $this->villages_data();
        $this->villages = [
            ['id' => 'semua', 'text' => 'Semua'],
            ...$villages->map(function ($q, $index) {
                $data = [
                    'id' => $q->id,
                    'text' => $q->name
                ];
                return $data;
            })
        ];
        $this->village = 'semua';
        $this->set_tpses();
        $this->set_teams();
    }

    public function set_tpses()
    {
        $tpses =  $this->tpses_data();
        $this->tpses = [
            ['id' => 'semua', 'text' => 'Semua'],
            ...$tpses->map(function ($q, $index) {
                $data = [
                    'id' => $q->id,
                    'text' => $q->name
                ];
                return $data;
            })
        ];
        $this->tps = 'semua';
        $this->set_teams();
    }

    public function set_teams()
    {
        $teams =  $this->teams_data();
        $this->teams = [
            ...$teams->map(function ($q, $index) {
                $data = [
                    'id' => $q->id,
                    'text' => $q->fullname
                ];
                return $data;
            })
        ];
        $this->team = 'semua';
    }

    public function villages_data()
    {
        return Village::where('district_id', $this->district)
            ->get();
    }

    public function tpses_data()
    {
        return Tps::whereHas('village', fn($q) => $q->where('district_id', $this->district))
            ->where('village_id', $this->village)
            ->get();
    }

    public function teams_data()
    {
        return User::role('Tim Bersinar')
            ->where('district_id', $this->district)
            ->where('village_id', $this->village)
            ->where('tps_id', $this->tps)
            ->get();
    }

    public function change_report()
    {
        $this->set_districts();
        if ($this->jenis_laporan == 'counter') {
            $this->district = [];
            $this->all_districts = true;
        }

        if ($this->jenis_laporan == 'voters') {
            $this->district = 'semua';
            $this->village = 'semua';
            $this->tps = 'semua';
            $this->all_teams = true;
            $this->set_villages();
            $this->set_tpses();
            $this->set_teams();
        }
    }
}
