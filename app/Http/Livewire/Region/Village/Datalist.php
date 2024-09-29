<?php

namespace App\Http\Livewire\Region\Village;

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
    protected $queryString = ['s', 'district'];
    protected $listeners = ['refresh' => 'resetFilter'];

    public $district, $s, $limit;

    public function mount()
    {
        $this->limit = 10;
    }

    public function render()
    {
        $districts = District::all();

        $villages = DB::table('villages', 'vl')
            ->selectRaw(
                'vl.id, vl.name, d.id as district_id, d.name as district_name, '
                    . '(select count(t.id) from tps as t where t.village_id = vl.id) as tpses_count, '
                    . '(select count(v.id) from voters v where '
                    . 'v.village_id = vl.id '
                    . 'and v.tps_id in (select t.id from tps as t where t.village_id = vl.id))'
                    . 'as voters_count, '
                    . '(select sum(voters_total) from tps as t where t.village_id = vl.id) as voters_total'
            )
            ->join('districts as d', 'vl.district_id', '=', 'd.id')
            ->where('vl.name', 'like', "%$this->s%")
            ->when($this->district, fn($q) => $q->where('district_id', $this->district));

        $get_data = $villages->get();
        $villages_voters_count = $get_data->sum('voters_count');
        $villages_voters_total = $get_data->sum('voters_total');

        $villages = $villages->paginate($this->limit, ['*'], 'villagesPage');

        return view('livewire.region.village.datalist', compact(
            'districts',
            'villages',
            'villages_voters_count',
            'villages_voters_total'
        ));
    }

    public function updated($attribute)
    {
        $this->resetPage('villagesPage');
    }

    public function destroy($id)
    {
        if (!auth()->user()->permissions->some('delete district'))
            return abort(403, 'Oooppssss..... Mau ngapain kamu!');

        $village = Village::find($id);
        $voters = Voter::where('village_id', $id)
            ->count();

        if ($village->tpses->count() > 0)
            return $this->alert(
                'warning',
                'Perhatian!',
                ['text' => 'Kelurahan/Desa tidak dapat dihapus. Terdapat lebih dari 1 data TPS pada Kelurahan/Desa yang akan anda hapus. Silahkan hapus TPS tersebut terlebih dahulu.']
            );

        if ($voters > 0)
            return $this->alert(
                'warning',
                'Perhatian!',
                ['text' => 'Kelurahan/Desa tidak dapat dihapus. Terdapat lebih dari 1 data pemilih pada Kelurahan/Desa yang akan anda hapus.']
            );

        $village->delete();
        return $this->alert(
            'success',
            'Sukses!',
            ['text' => 'Berhasil menghapus Kelurahan/Desa.']
        );
    }

    public function resetFilter()
    {
        $this->reset('district', 's');
        $this->resetPage('villagesPage');
    }
}
