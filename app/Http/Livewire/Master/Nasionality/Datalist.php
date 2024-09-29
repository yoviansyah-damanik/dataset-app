<?php

namespace App\Http\Livewire\Master\Nasionality;

use Livewire\Component;
use App\Models\Nasionality;
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
        $nasionalities = DB::table('nasionalities', 'n')
            ->selectRaw('n.id,n.name, '
                . '(select count(v.id) from voters as v where v.nasionality_id = n.id) as voters_count')
            ->where('name', 'like', "%$this->s%");

        $get_data = $nasionalities->get();
        $nasionalities_voters_count = $get_data->sum('voters_count');

        $nasionalities = $nasionalities->paginate($this->limit, ['*'], 'nasionalitiesPage');

        return view('livewire.master.nasionality.datalist', compact('nasionalities', 'nasionalities_voters_count'));
    }

    public function destroy($id)
    {
        if (!auth()->user()->permissions->some('delete nasionality'))
            return abort(403, 'Oooppssss..... Mau ngapain kamu!');

        $nasionality = Nasionality::findOrFail($id);
        try {
            if ($nasionality->voters()->count() > 0)
                return $this->alert(
                    'warning',
                    'Perhatian!',
                    ['text' => 'Kewarganegaraan tidak dapat dihapus. Terdapat lebih dari 1 data pemilih pada Kewarganegaraan yang akan anda hapus.']
                );

            $nasionality->delete();
            $this->alert(
                'success',
                'Sukses!',
                ['text' => 'Berhasil menghapus Kewarganegaraan.']
            );
        } catch (\Exception $e) {
            $this->alert();
        }
    }

    public function resetFilter()
    {
        $this->reset('s');
        $this->resetPage('nasionalityPage');
    }
}
