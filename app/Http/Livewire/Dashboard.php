<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Voter;
use Livewire\Component;
use App\Models\District;
use App\Models\MaritalStatus;
use App\Models\Nasionality;
use App\Models\Profession;
use App\Models\Religion;
use App\Models\Tps;
use App\Models\Village;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $view = 'user';

    public $voters_by_age,
        $voters_by_gender,
        $voters_by_religion,
        $voters_by_marital_status,
        $voters_by_nasionality,
        $voters_by_profession,
        $coordinator_1_total,
        $coordinator_2_total,
        $coordinator_3_total,
        $coordinator_4_total,
        $administrator_total,
        $users_total,
        $voters_total;

    public $districts_total,
        $villages_total,
        $tpses_total;

    public $religions_total,
        $nasionalities_total,
        $marital_statuses_total,
        $professions_total;

    public $voters_by_district, $voters_by_village, $voters_by_tps;

    public $districts, $district, $district_name;

    public $most_voters_district,
        $most_voters_village,
        $most_voters_tps;

    public function mount()
    {
        $this->view = auth()->user()->role_name == 'Superadmin' ? 'admin' : 'user';
        $this->district_name = auth()->user()?->district?->name;

        if (auth()->user()->role_name == 'Superadmin') {
            $this->districts = District::get();
            $this->district = $this->districts->first()->id;
            $this->district_name = $this->districts->first()->name;
        }

        $this->init_data();
    }

    public function init_data()
    {
        $this->voters_total = auth()->user()->voters_count;

        $this->voters_by_gender = Voter::selectRaw('gender, count(id) as total_voters')
            ->groupBy('gender')
            ->when(
                $this->view == 'user',
                fn($viewQuery) => $viewQuery->when(
                    auth()->user()->role_name != 'Superadmin',
                    fn($q) => $q->when(
                        in_array(auth()->user()->role_name, ['Koordinator Keluarga', 'Administrator Keluarga']),
                        fn($r) => $r->when(
                            auth()->user()->role_name == 'Administrator Keluarga',
                            fn($s) => $s->whereNotNull('family_coor_id'),
                            fn($s) => $s->where('family_coor_id', auth()->user()->id)
                        ),
                        fn($r) => $r->where('district_id', auth()->user()->district_id)
                            ->when(
                                !in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan']),
                                fn($s) => $s->where('village_id', auth()->user()->village_id)
                            )
                            ->when(
                                !in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan', 'Koordinator Kelurahan/Desa']),
                                fn($s) => $s->where('tps_id', auth()->user()->tps_id)
                            )
                    )
                )
            )
            ->get()
            ->map(fn($gender) => [
                'label' => $gender->gender,
                'data' => $gender->total_voters
            ])
            ->toArray();

        $this->voters_by_religion = DB::table('religions', 'r')
            ->selectRaw('r.name, count(v.id) as total_voters')
            ->join('voters as v', 'v.religion_id', '=', 'r.id')
            ->groupBy('r.id')
            ->when(
                $this->view == 'user',
                fn($viewQuery) => $viewQuery->when(
                    auth()->user()->role_name != 'Superadmin',
                    fn($q) => $q->when(
                        in_array(auth()->user()->role_name, ['Koordinator Keluarga', 'Administrator Keluarga']),
                        fn($r) => $r->when(
                            auth()->user()->role_name == 'Administrator Keluarga',
                            fn($s) => $s->whereNotNull('family_coor_id'),
                            fn($s) => $s->where('family_coor_id', auth()->user()->id)
                        ),
                        fn($r) => $r->where('district_id', auth()->user()->district_id)
                            ->when(
                                !in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan']),
                                fn($s) => $s->where('village_id', auth()->user()->village_id)
                            )
                            ->when(
                                !in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan', 'Koordinator Kelurahan/Desa']),
                                fn($s) => $s->where('tps_id', auth()->user()->tps_id)
                            )
                    )
                )
            )
            ->get()
            ->map(fn($religion) => [
                'label' => $religion->name,
                'data' => $religion->total_voters
            ])
            ->toArray();

        $this->voters_by_marital_status = DB::table('marital_statuses', 'ms')
            ->selectRaw('ms.name, count(v.id) as total_voters')
            ->join('voters as v', 'v.marital_status_id', '=', 'ms.id')
            ->groupBy('ms.id')
            ->when(
                $this->view == 'user',
                fn($viewQuery) => $viewQuery->when(
                    auth()->user()->role_name != 'Superadmin',
                    fn($q) => $q->when(
                        in_array(auth()->user()->role_name, ['Koordinator Keluarga', 'Administrator Keluarga']),
                        fn($r) => $r->when(
                            auth()->user()->role_name == 'Administrator Keluarga',
                            fn($s) => $s->whereNotNull('family_coor_id'),
                            fn($s) => $s->where('family_coor_id', auth()->user()->id)
                        ),
                        fn($r) => $r->where('district_id', auth()->user()->district_id)
                            ->when(
                                !in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan']),
                                fn($s) => $s->where('village_id', auth()->user()->village_id)
                            )
                            ->when(
                                !in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan', 'Koordinator Kelurahan/Desa']),
                                fn($s) => $s->where('tps_id', auth()->user()->tps_id)
                            )
                    )
                )
            )
            ->get()
            ->map(fn($marital_status) => [
                'label' => $marital_status->name,
                'data' => $marital_status->total_voters
            ])
            ->toArray();

        $this->voters_by_profession = DB::table('professions', 'p')
            ->selectRaw('p.name, count(v.id) as total_voters')
            ->join('voters as v', 'v.profession_id', '=', 'p.id')
            ->groupBy('p.id')
            ->when(
                $this->view == 'user',
                fn($viewQuery) => $viewQuery->when(
                    auth()->user()->role_name != 'Superadmin',
                    fn($q) => $q->when(
                        in_array(auth()->user()->role_name, ['Koordinator Keluarga', 'Administrator Keluarga']),
                        fn($r) => $r->when(
                            auth()->user()->role_name == 'Administrator Keluarga',
                            fn($s) => $s->whereNotNull('family_coor_id'),
                            fn($s) => $s->where('family_coor_id', auth()->user()->id)
                        ),
                        fn($r) => $r->where('district_id', auth()->user()->district_id)
                            ->when(
                                !in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan']),
                                fn($s) => $s->where('village_id', auth()->user()->village_id)
                            )
                            ->when(
                                !in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan', 'Koordinator Kelurahan/Desa']),
                                fn($s) => $s->where('tps_id', auth()->user()->tps_id)
                            )
                    )
                )
            )
            ->get()
            ->map(fn($profession) => [
                'label' => $profession->name,
                'data' => $profession->total_voters
            ])
            ->toArray();

        $this->voters_by_nasionality = DB::table('nasionalities', 'n')
            ->selectRaw('n.name, count(v.id) as total_voters')
            ->join('voters as v', 'v.nasionality_id', '=', 'n.id')
            ->groupBy('n.id')
            ->when(
                $this->view == 'user',
                fn($viewQuery) => $viewQuery->when(
                    auth()->user()->role_name != 'Superadmin',
                    fn($q) => $q->when(
                        in_array(auth()->user()->role_name, ['Koordinator Keluarga', 'Administrator Keluarga']),
                        fn($r) => $r->when(
                            auth()->user()->role_name == 'Administrator Keluarga',
                            fn($s) => $s->whereNotNull('family_coor_id'),
                            fn($s) => $s->where('family_coor_id', auth()->user()->id)
                        ),
                        fn($r) => $r->where('district_id', auth()->user()->district_id)
                            ->when(
                                !in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan']),
                                fn($s) => $s->where('village_id', auth()->user()->village_id)
                            )
                            ->when(
                                !in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan', 'Koordinator Kelurahan/Desa']),
                                fn($s) => $s->where('tps_id', auth()->user()->tps_id)
                            )
                    )
                )
            )
            ->get()
            ->map(fn($nasionality) => [
                'label' => $nasionality->name,
                'data' => $nasionality->total_voters
            ])
            ->toArray();

        $start = 17;
        $end =  25;
        $age_17_25 = Voter::selectRaw('count(id) as total_voters')
            ->when(
                $this->view == 'user',
                fn($viewQuery) => $viewQuery->when(
                    auth()->user()->role_name != 'Superadmin',
                    fn($q) => $q->when(
                        in_array(auth()->user()->role_name, ['Koordinator Keluarga', 'Administrator Keluarga']),
                        fn($r) => $r->when(
                            auth()->user()->role_name == 'Administrator Keluarga',
                            fn($s) => $s->whereNotNull('family_coor_id'),
                            fn($s) => $s->where('family_coor_id', auth()->user()->id)
                        ),
                        fn($r) => $r->where('district_id', auth()->user()->district_id)
                            ->when(
                                !in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan']),
                                fn($s) => $s->where('village_id', auth()->user()->village_id)
                            )
                            ->when(
                                !in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan', 'Koordinator Kelurahan/Desa']),
                                fn($s) => $s->where('tps_id', auth()->user()->tps_id)
                            )
                    )
                )
            )
            ->where('age', '>=', $start)
            ->where('age', '<=', $end)
            ->first()->total_voters;

        $start = 25;
        $end =  35;

        $age_25_35 = Voter::selectRaw('count(id) as total_voters')
            ->when(
                $this->view == 'user',
                fn($viewQuery) => $viewQuery->when(
                    auth()->user()->role_name != 'Superadmin',
                    fn($q) => $q->when(
                        in_array(auth()->user()->role_name, ['Koordinator Keluarga', 'Administrator Keluarga']),
                        fn($r) => $r->when(
                            auth()->user()->role_name == 'Administrator Keluarga',
                            fn($s) => $s->whereNotNull('family_coor_id'),
                            fn($s) => $s->where('family_coor_id', auth()->user()->id)
                        ),
                        fn($r) => $r->where('district_id', auth()->user()->district_id)
                            ->when(
                                !in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan']),
                                fn($s) => $s->where('village_id', auth()->user()->village_id)
                            )
                            ->when(
                                !in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan', 'Koordinator Kelurahan/Desa']),
                                fn($s) => $s->where('tps_id', auth()->user()->tps_id)
                            )
                    )
                )
            )
            ->where('age', '>=', $start)
            ->where('age', '<=', $end)
            ->first()->total_voters;

        $start = 35;
        $end =  45;
        $age_35_45 = Voter::selectRaw('count(id) as total_voters')
            ->when(
                $this->view == 'user',
                fn($viewQuery) => $viewQuery->when(
                    auth()->user()->role_name != 'Superadmin',
                    fn($q) => $q->when(
                        in_array(auth()->user()->role_name, ['Koordinator Keluarga', 'Administrator Keluarga']),
                        fn($r) => $r->when(
                            auth()->user()->role_name == 'Administrator Keluarga',
                            fn($s) => $s->whereNotNull('family_coor_id'),
                            fn($s) => $s->where('family_coor_id', auth()->user()->id)
                        ),
                        fn($r) => $r->where('district_id', auth()->user()->district_id)
                            ->when(
                                !in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan']),
                                fn($s) => $s->where('village_id', auth()->user()->village_id)
                            )
                            ->when(
                                !in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan', 'Koordinator Kelurahan/Desa']),
                                fn($s) => $s->where('tps_id', auth()->user()->tps_id)
                            )
                    )
                )
            )
            ->where('age', '>=', $start)
            ->where('age', '<=', $end)
            ->first()->total_voters;

        $start = 45;
        $end =  55;
        $age_45_55 = Voter::selectRaw('count(id) as total_voters')
            ->when(
                $this->view == 'user',
                fn($viewQuery) => $viewQuery->when(
                    auth()->user()->role_name != 'Superadmin',
                    fn($q) => $q->when(
                        in_array(auth()->user()->role_name, ['Koordinator Keluarga', 'Administrator Keluarga']),
                        fn($r) => $r->when(
                            auth()->user()->role_name == 'Administrator Keluarga',
                            fn($s) => $s->whereNotNull('family_coor_id'),
                            fn($s) => $s->where('family_coor_id', auth()->user()->id)
                        ),
                        fn($r) => $r->where('district_id', auth()->user()->district_id)
                            ->when(
                                !in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan']),
                                fn($s) => $s->where('village_id', auth()->user()->village_id)
                            )
                            ->when(
                                !in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan', 'Koordinator Kelurahan/Desa']),
                                fn($s) => $s->where('tps_id', auth()->user()->tps_id)
                            )
                    )
                )
            )
            ->where('age', '>=', $start)
            ->where('age', '<=', $end)
            ->first()->total_voters;

        $end = 55;
        $age_55_up = Voter::selectRaw('count(id) as total_voters')
            ->when(
                $this->view == 'user',
                fn($viewQuery) => $viewQuery->when(
                    auth()->user()->role_name != 'Superadmin',
                    fn($q) => $q->when(
                        in_array(auth()->user()->role_name, ['Koordinator Keluarga', 'Administrator Keluarga']),
                        fn($r) => $r->when(
                            auth()->user()->role_name == 'Administrator Keluarga',
                            fn($s) => $s->whereNotNull('family_coor_id'),
                            fn($s) => $s->where('family_coor_id', auth()->user()->id)
                        ),
                        fn($r) => $r->where('district_id', auth()->user()->district_id)
                            ->when(
                                !in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan']),
                                fn($s) => $s->where('village_id', auth()->user()->village_id)
                            )
                            ->when(
                                !in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan', 'Koordinator Kelurahan/Desa']),
                                fn($s) => $s->where('tps_id', auth()->user()->tps_id)
                            )
                    )
                )
            )
            ->where('age', '<=', $end)
            ->first()->total_voters;


        $this->voters_by_age = [
            [
                'label' => '17-25 Tahun',
                'data' => $age_17_25
            ],
            [
                'label' => '25-35 Tahun',
                'data' => $age_25_35
            ],
            [
                'label' => '35-45 Tahun',
                'data' => $age_35_45
            ],
            [
                'label' => '45-55 Tahun',
                'data' => $age_45_55
            ],
            [
                'label' => '>55 Tahun',
                'data' => $age_55_up
            ],
        ];

        if (auth()->user()->role_name == 'Superadmin') {
            $this->user_recap();
            $this->region_recap();
            $this->master_recap();
            $this->voters_by_district();
            $this->most_voters_district();
            $this->most_voters_village();
            $this->most_voters_tps();
        }

        $this->voters_by_village(auth()->user()->role_name == 'Superadmin' ? $this->district : auth()->user()->district_id);
        $this->voters_by_tps(auth()->user()->role_name == 'Superadmin' ? $this->district : auth()->user()->district_id);
    }

    public function render()
    {
        $box_color = ['box-primary', 'box-secondary', 'box-third', 'box-fourth', 'box-fifth', 'box-sixth'];

        $this->dispatchBrowserEvent('chartLoaded');
        return view('livewire.dashboard', [
            'box_color' => $box_color,
        ]);
    }

    public function set_district_name()
    {
        $this->district_name = District::find($this->district)->name;

        if (auth()->user()->role_name == 'Superadmin') {
            $this->voters_by_district();
            $this->voters_by_village(auth()->user()->role_name == 'Superadmin' ? $this->district : auth()->user()->district_id);
            $this->voters_by_tps(auth()->user()->role_name == 'Superadmin' ? $this->district : auth()->user()->district_id);
            // $this->most_voters_district();
            // $this->most_voters_village();
            // $this->most_voters_tps();
        }
    }

    public function user_recap()
    {
        $this->users_total = User::count();

        $this->coordinator_1_total = User::role('Koordinator Kecamatan')->count();
        $this->coordinator_2_total = User::role('Koordinator Kelurahan/Desa')->count();
        $this->coordinator_3_total = User::role('Koordinator TPS')->count();
        $this->coordinator_4_total = User::role('Tim Bersinar')->count();
        $this->administrator_total = User::role(['Administrator', 'Superadmin'])->count();
    }

    public function region_recap()
    {
        $this->districts_total = District::count();
        $this->villages_total = Village::count();
        $this->tpses_total = Tps::count();
    }

    public function master_recap()
    {
        $this->religions_total = Religion::count();
        $this->nasionalities_total = Nasionality::count();
        $this->marital_statuses_total = MaritalStatus::count();
        $this->professions_total = Profession::count();
    }

    public function voters_by_district()
    {
        $voters_by_district = DB::table('districts', 'd')
            ->selectRaw(
                'd.name, '
                    . '(select count(v.id) from voters v '
                    . 'where v.district_id = d.id) as voters_count, '
                    . '(select count(dpt.id) from dpts dpt where dpt.district_id = d.id) as voters_total'
            )->get();

        $this->voters_by_district = $voters_by_district->map(
            fn($q) => ['label' => $q->name, 'voters_count' => $q->voters_count, 'voters_total' => $q->voters_total]
        )->toArray();
    }

    public function most_voters_district()
    {
        $this->most_voters_district = collect($this->voters_by_district)
            ->sortByDesc('voters_count')
            ->take(3)
            ->values();
    }

    public function voters_by_village($district)
    {
        $voters_by_village = DB::table('villages', 'vl')
            ->selectRaw(
                'vl.name, d.name as district_name, '
                    . '(select count(v.id) from voters v where v.village_id = vl.id) as voters_count, '
                    . '(select count(dpt.id) from dpts dpt where dpt.village_id = vl.id) as voters_total'
            )
            ->join('districts as d', 'd.id', '=', 'vl.district_id')
            ->where('vl.district_id', $district)
            ->get();

        $this->voters_by_village = $voters_by_village->map(
            fn($q) => ['label' => $q->name, 'district_name' => $q->district_name, 'voters_count' => $q->voters_count, 'voters_total' => $q->voters_total]
        )->toArray();
    }

    public function most_voters_village()
    {
        $this->most_voters_village = DB::table('villages', 'vl')
            ->selectRaw(
                'vl.name, d.name as district_name, '
                    . '(select count(v.id) from voters v where v.village_id = vl.id) as voters_count, '
                    . '(select count(dpt.id) from dpts dpt where dpt.village_id = vl.id) as voters_total'
            )
            ->join('districts as d', 'd.id', '=', 'vl.district_id')
            ->orderBy('voters_count', 'desc')
            ->limit(3)
            ->get()
            ->map(
                fn($q) => ['label' => $q->name, 'district_name' => $q->district_name, 'voters_count' => $q->voters_count, 'voters_total' => $q->voters_total]
            )->toArray();
    }

    public function voters_by_tps($district)
    {
        $villages = Village::where('district_id', $district)
            ->get();

        $this->voters_by_tps = $villages->map(
            function ($village) {
                return [
                    'village_id' => $village->id,
                    'village_name' => $village->name,
                    'tpses' => DB::table('tps', 't')
                        ->selectRaw(
                            't.name as tps_name, t.voters_total, '
                                . '(select count(v.id) from voters v where v.tps_id = t.id)'
                                . 'as voters_count, '
                                . '(select count(dpt.id) from dpts dpt where dpt.tps_id = t.id)'
                                . 'as voters_total'
                        )
                        ->where('t.village_id', $village->id)
                        ->get()
                ];
            }
        )->toArray();
    }

    public function most_voters_tps()
    {
        $this->most_voters_tps = DB::table('tps', 't')
            ->selectRaw(
                't.name, d.name as district_name, vl.name as village_name, '
                    . '(select count(v.id) from voters v where v.tps_id = t.id) as voters_count, '
                    . '(select count(dpt.id) from dpts dpt where dpt.tps_id = t.id) as voters_total'
            )
            ->join('villages as vl', 'vl.id', '=', 't.village_id')
            ->join('districts as d', 'd.id', '=', 'vl.district_id')
            ->orderBy('voters_count', 'desc')
            ->limit(3)
            ->get()
            ->map(
                fn($q) => ['label' => $q->name, 'district_name' => $q->district_name, 'village_name' => $q->village_name, 'voters_count' => $q->voters_count, 'voters_total' => $q->voters_total]
            )->toArray();
    }
}
