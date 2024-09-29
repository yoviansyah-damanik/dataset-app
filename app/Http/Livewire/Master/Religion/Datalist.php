<?php

namespace App\Http\Livewire\Master\Religion;

use Livewire\Component;
use App\Models\Religion;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Datalist extends Component
{
    use WithPagination, LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['s'];
    protected $listeners = ['refresh' => 'resetFilter'];

    public $s;
    public $limit = 10;
    public function render()
    {
        $religions = DB::table('religions', 'r')
            ->selectRaw('r.id,r.name, '
                . '(select count(v.id) from voters as v where v.religion_id = r.id) as voters_count')
            ->where('name', 'like', "%$this->s%");

        $get_data = $religions->get();
        $religions_voters_count = $get_data->sum('voters_count');

        $religions = $religions->paginate($this->limit, ['*'], 'religionsPage');

        return view('livewire.master.religion.datalist', compact('religions', 'religions_voters_count'));
    }

    public function destroy($id)
    {
        if (!auth()->user()->permissions->some('delete religion'))
            return abort(403, 'Oooppssss..... Mau ngapain kamu!');

        $religion = Religion::findOrFail($id);
        try {
            if ($religion->voters()->count() > 0)
                return $this->alert(
                    'warning',
                    'Perhatian!',
                    ['text' => 'Agama tidak dapat dihapus. Terdapat lebih dari 1 data pemilih pada Agama yang akan anda hapus.']
                );

            $religion->delete();
            $this->alert(
                'success',
                'Sukses!',
                ['text' => 'Berhasil menghapus Agama.']
            );
        } catch (\Exception $e) {
            $this->alert();
        }
    }

    public function resetFilter()
    {
        $this->reset('s');
        $this->resetPage('religionPage');
    }
}
