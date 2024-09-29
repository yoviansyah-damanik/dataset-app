<?php

namespace App\Http\Livewire\Region\District;

use App\Models\Voter;
use Livewire\Component;
use App\Models\District;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Datalist extends Component
{
    use WithPagination, LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['s'];
    protected $listeners = ['refresh' => 'resetFilter'];

    public $s, $limit;

    public function mount()
    {
        $this->limit = 10;
    }

    public function render()
    {
        $districts = DB::table('districts', 'd')
            ->selectRaw(
                'd.id, d.name, '
                    . '(select count(vl.id) from villages as vl where vl.district_id = d.id) as villages_count, '
                    . '(select count(v.id) from voters v '
                    . 'where v.district_id = d.id '
                    . 'and v.village_id in (select vl.id from villages as vl where vl.district_id = d.id) '
                    . 'and v.tps_id in (select t.id from tps as t where t.village_id in (select vl.id from villages as vl where vl.district_id = d.id)))'
                    . 'as voters_count, '
                    . '(select sum((select sum(voters_total) from tps as t where t.village_id = vl.id)) from villages as vl where vl.district_id = d.id) as voters_total'
            )
            ->where('d.name', 'like', "%$this->s%");

        $get_data = $districts->get();
        $districts_voters_count = $get_data->sum('voters_count');
        $districts_voters_total = $get_data->sum('voters_total');

        $districts = $districts->paginate($this->limit, ['*'], 'districtsPage');

        return view('livewire.region.district.datalist', compact(
            'districts',
            'districts_voters_count',
            'districts_voters_total',
        ));
    }

    public function updated($attribute)
    {
        $this->resetPage('districtsPage');
    }

    public function destroy($id)
    {
        if (!auth()->user()->permissions->some('delete district'))
            return abort(403, 'Oooppssss..... Mau ngapain kamu!');

        $district = District::find($id);
        $voters = Voter::where('district_id', $id)
            ->count();

        if ($district->villages->count() > 0)
            return $this->alert(
                'warning',
                'Perhatian!',
                ['text' => 'Kecamatan tidak dapat dihapus. Terdapat lebih dari 1 data Kelurahan/Desa pada kecamatan yang akan anda hapus. Silahkan hapus Kelurahan/Desa tersebut terlebih dahulu.']
            );

        if ($voters > 0)
            return $this->alert(
                'warning',
                'Perhatian!',
                ['text' => 'Kecamatan tidak dapat dihapus. Terdapat lebih dari 1 data pemilih pada Kecamatan yang akan anda hapus.']
            );

        $district->delete();
        return $this->alert(
            'success',
            'Sukses!',
            ['text' => 'Berhasil menghapus Kecamatan.']
        );
    }

    public function resetFilter()
    {
        $this->reset('s');
        $this->resetPage('districtsPage');
    }
}
