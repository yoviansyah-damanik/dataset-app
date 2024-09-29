<?php

namespace App\Http\Livewire\Master\Profession;

use Livewire\Component;
use App\Models\Profession;
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
        $professions = DB::table('professions', 'r')
            ->selectRaw('r.id,r.name, '
                . '(select count(v.id) from voters as v where v.profession_id = r.id) as voters_count')
            ->where('name', 'like', "%$this->s%");

        $get_data = $professions->get();
        $professions_voters_count = $get_data->sum('voters_count');

        $professions = $professions->paginate($this->limit, ['*'], 'professionsPage');

        return view('livewire.master.profession.datalist', compact('professions', 'professions_voters_count'));
    }

    public function destroy($id)
    {
        if (!auth()->user()->permissions->some('delete profession'))
            return abort(403, 'Oooppssss..... Mau ngapain kamu!');

        $profession = Profession::findOrFail($id);
        try {
            if ($profession->voters()->count() > 0)
                return $this->alert(
                    'warning',
                    'Perhatian!',
                    ['text' => 'Pekerjaan tidak dapat dihapus. Terdapat lebih dari 1 data pemilih pada Pekerjaan yang akan anda hapus.']
                );

            $profession->delete();
            $this->alert(
                'success',
                'Sukses!',
                ['text' => 'Berhasil menghapus Pekerjaan.']
            );
        } catch (\Exception $e) {
            $this->alert();
        }
    }

    public function resetFilter()
    {
        $this->reset('s');
        $this->resetPage('professionPage');
    }
}
