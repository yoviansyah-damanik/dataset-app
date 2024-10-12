<?php

namespace App\Http\Livewire\Dpt;

use App\Models\Dpt;
use App\Models\Tps;
use App\Models\Village;
use Livewire\Component;
use App\Models\District;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $per_page = 10;
    public $search = '';
    public $status;
    public $district, $village, $tps;

    public function mount()
    {
        $this->status = 'semua';

        if (auth()->user()->role_name != 'Superadmin') {
            $this->district = auth()->user()->district_id;

            if (!in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan'])) {
                $this->village = auth()->user()->village_id;
            }

            if (!in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan', 'Koordinator Kelurahan/Desa'])) {
                $this->tps = auth()->user()->tps_id;
            }
        }
    }

    public function render()
    {
        $districts = District::all();

        $villages = Village::where('district_id', $this->district)
            ->get();

        $tpses = Tps::whereHas(
            'village',
            fn($q) => $q->where('id', $this->village)
                ->where('district_id', $this->district)
        )
            ->get();

        $dpts = Dpt::with('voter', 'district', 'village', 'tps')
            ->where('name', 'like', '%' . $this->search . '%')

            ->when($this->status != 'semua', fn($q) => $q->when(
                $this->status == 'terdata',
                fn($r) => $r->whereHas('voter'),
                fn($r) => $r->whereDoesntHave('voter')
            ))
            ->when(
                $this->district,
                fn($q) => $q->where('district_id', $this->district)
                    ->when(
                        $this->village,
                        fn($r) => $r->where('village_id', $this->village)
                            ->when($this->tps, fn($s) => $s->where('tps_id', $this->tps))
                    )
            )

            ->paginate($this->per_page);


        return view('livewire.dpt.index', compact('dpts', 'districts', 'villages', 'tpses'));
    }

    public function updated($attribute)
    {
        if ($attribute == 'district') {
            $this->village = null;
            $this->tps = null;
        }

        if ($attribute == 'village') {
            $this->tps = null;
        }

        $this->resetPage();
    }
}
