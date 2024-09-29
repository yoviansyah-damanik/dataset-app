<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;
use App\Models\Religion;
use App\Models\Profession;
use App\Models\Nasionality;
use App\Models\MaritalStatus;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public array $voters_by_religion,
        $voters_by_marital_status,
        $voters_by_profession,
        $voters_by_nasionality;

    public function render()
    {
        $total_religions = Religion::count();
        $total_professions = Profession::count();
        $total_nasionalities = Nasionality::count();
        $total_marital_statuses = MaritalStatus::count();

        $this->voters_by_religion = DB::table('religions', 'r')->selectRaw('r.name, count(v.id) as total_voters')
            ->leftJoin('voters as v', 'v.religion_id', '=', 'r.id')
            ->when(
                auth()->user()->role_name != 'Superadmin',
                fn($q) => $q->where('district_id', auth()->user()->district_id)
                    ->when(
                        !in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan']),
                        fn($q) => $q->where('village_id', auth()->user()->village_id)
                    )
                    ->when(
                        !in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan', 'Koordinator Kelurahan/Desa']),
                        fn($q) => $q->where('tps_id', auth()->user()->tps_id)
                    )
            )
            ->when(
                auth()->user()->role_name != 'Superadmin',
                fn($q) => $q->where('district_id', auth()->user()->district_id)
                    ->when(
                        !in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan']),
                        fn($q) => $q->where('village_id', auth()->user()->village_id)
                    )
                    ->when(
                        !in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan', 'Koordinator Kelurahan/Desa']),
                        fn($q) => $q->where('tps_id', auth()->user()->tps_id)
                    )
            )
            ->groupBy('r.id')
            ->get()
            ->map(fn($religion) => [
                'label' => $religion->name,
                'data' => $religion->total_voters
            ])
            ->toArray();

        $this->voters_by_marital_status = DB::table('marital_statuses', 'ms')->selectRaw('ms.name, count(v.id) as total_voters')
            ->leftJoin('voters as v', 'v.marital_status_id', '=', 'ms.id')
            ->when(
                auth()->user()->role_name != 'Superadmin',
                fn($q) => $q->where('district_id', auth()->user()->district_id)
                    ->when(
                        !in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan']),
                        fn($q) => $q->where('village_id', auth()->user()->village_id)
                    )
                    ->when(
                        !in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan', 'Koordinator Kelurahan/Desa']),
                        fn($q) => $q->where('tps_id', auth()->user()->tps_id)
                    )
            )
            ->groupBy('ms.id')
            ->get()
            ->map(fn($marital_status) => [
                'label' => $marital_status->name,
                'data' => $marital_status->total_voters
            ])
            ->toArray();

        $this->voters_by_profession = DB::table('professions', 'p')->selectRaw('p.name, count(v.id) as total_voters')
            ->leftJoin('voters as v', 'v.profession_id', '=', 'p.id')
            ->when(
                auth()->user()->role_name != 'Superadmin',
                fn($q) => $q->where('district_id', auth()->user()->district_id)
                    ->when(
                        !in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan']),
                        fn($q) => $q->where('village_id', auth()->user()->village_id)
                    )
                    ->when(
                        !in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan', 'Koordinator Kelurahan/Desa']),
                        fn($q) => $q->where('tps_id', auth()->user()->tps_id)
                    )
            )
            ->groupBy('p.id')
            ->get()
            ->map(fn($profession) => [
                'label' => $profession->name,
                'data' => $profession->total_voters
            ])
            ->toArray();

        $this->voters_by_nasionality = DB::table('nasionalities', 'n')->selectRaw('n.name, count(v.id) as total_voters')
            ->leftJoin('voters as v', 'v.nasionality_id', '=', 'n.id')
            ->when(
                auth()->user()->role_name != 'Superadmin',
                fn($q) => $q->where('district_id', auth()->user()->district_id)
                    ->when(
                        !in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan']),
                        fn($q) => $q->where('village_id', auth()->user()->village_id)
                    )
                    ->when(
                        !in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan', 'Koordinator Kelurahan/Desa']),
                        fn($q) => $q->where('tps_id', auth()->user()->tps_id)
                    )
            )
            ->groupBy('n.id')
            ->get()
            ->map(fn($nasionality) => [
                'label' => $nasionality->name,
                'data' => $nasionality->total_voters
            ])
            ->toArray();

        return view('livewire.master.index', compact(
            'total_religions',
            'total_professions',
            'total_nasionalities',
            'total_marital_statuses',
        ));
    }
}
