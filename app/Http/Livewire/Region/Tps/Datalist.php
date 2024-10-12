<?php

namespace App\Http\Livewire\Region\Tps;

use App\Models\Tps;
use App\Models\Voter;
use App\Models\Village;
use Livewire\Component;
use App\Models\District;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Datalist extends Component
{
    use WithPagination, LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['s', 'district', 'village'];
    protected $listeners = ['refresh' => 'resetFilter'];

    public $s, $limit, $district, $village;

    public function mount()
    {
        $this->limit = 10;
    }

    public function render()
    {
        $districts = District::get();
        $villages = Village::where('district_id', $this->district)
            ->get();

        $tpses = DB::table('tps', 't')
            ->selectRaw(
                't.id, t.name, t.voters_total, (select count(dpts.id) from dpts where dpts.tps_id = t.id) as dpts_count, d.id as district_id, d.name as district_name, vl.id as village_id, vl.name as village_name, '
                    . '(select count(v.id) from voters v where '
                    . 'v.tps_id = t.id) as voters_count'
            )
            ->join('villages as vl', 'vl.id', '=', 't.village_id')
            ->join('districts as d', 'vl.district_id', '=', 'd.id')
            ->where('t.name', 'like', "%$this->s%")
            // ->where('dpts_count', '!=', 'voters_total')
            ->when(
                $this->district,
                fn($q) =>
                $q->where('district_id', $this->district)
                    ->when($this->village, fn($q) => $q->where('village_id', $this->village))
            );
        // ->get();

        // $tpses = Tps::with('district', 'village')
        // ->withCount('voters', 'dpts');
        // ->where('voters_count', '!=', 'dpts_count');

        $get_data = $tpses->get();
        $tpses_voters_count = $get_data->sum('voters_count');
        $tpses_voters_total = $get_data->sum('dpts_count');

        $tpses = $tpses->paginate($this->limit, ['*'], 'tpsPage');

        return view('livewire.region.tps.datalist', compact(
            'tpses',
            'districts',
            'villages',
            'tpses_voters_count',
            'tpses_voters_total',
        ));
    }

    public function updated($attribute)
    {
        $this->resetPage('tpsPage');

        if ($attribute == 'district') {
            $this->village = null;
        }
    }

    public function destroy($id)
    {
        if (!auth()->user()->permissions->some('delete district'))
            return abort(403, 'Oooppssss..... Mau ngapain kamu!');

        $tps = Tps::find($id);
        $voters = Voter::where('tps_id', $id)
            ->count();

        if ($tps->voters->count() > 0)
            return $this->alert(
                'warning',
                'Perhatian!',
                ['text' => 'TPS tidak dapat dihapus. Terdapat lebih dari 1 data Pemilih pada TPS yang akan anda hapus. Silahkan hapus Pemilih tersebut terlebih dahulu.']
            );

        if ($voters > 0)
            return $this->alert(
                'warning',
                'Perhatian!',
                ['text' => 'TPS tidak dapat dihapus. Terdapat lebih dari 1 data pemilih pada TPS yang akan anda hapus.']
            );

        $tps->delete();
        return $this->alert(
            'success',
            'Sukses!',
            ['text' => 'Berhasil menghapus TPS.']
        );
    }

    public function resetFilter()
    {
        $this->reset('district', 'village', 's');
        $this->resetPage('tpsPage');
    }
}
