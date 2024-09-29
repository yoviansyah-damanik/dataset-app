<?php

namespace App\Http\Livewire\Master\MaritalStatus;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\MaritalStatus;
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
        $marital_statuses = DB::table('marital_statuses', 'ms')
            ->selectRaw('ms.id,ms.name, '
                . '(select count(v.id) from voters as v where v.marital_status_id = ms.id) as voters_count')
            ->where('name', 'like', "%$this->s%");

        $get_data = $marital_statuses->get();
        $marital_statuses_voters_count = $get_data->sum('voters_count');

        $marital_statuses = $marital_statuses->paginate($this->limit, ['*'], 'maritalStatusPage');

        return view('livewire.master.marital-status.datalist', compact('marital_statuses', 'marital_statuses_voters_count'));
    }

    public function destroy($id)
    {
        if (!auth()->user()->permissions->some('delete marital_status'))
            return abort(403, 'Oooppssss..... Mau ngapain kamu!');

        $marital_status = MaritalStatus::findOrFail($id);
        try {
            if ($marital_status->voters()->count() > 0)
                return $this->alert(
                    'warning',
                    'Perhatian!',
                    ['text' => 'Status Perkawinan tidak dapat dihapus. Terdapat lebih dari 1 data pemilih pada Status Perkawinan yang akan anda hapus.']
                );

            $marital_status->delete();
            $this->alert(
                'success',
                'Sukses!',
                ['text' => 'Berhasil menghapus Status Perkawinan.']
            );
        } catch (\Exception $e) {
            $this->alert();
        }
    }

    public function resetFilter()
    {
        $this->reset('s');
        $this->resetPage('maritalStatusPage');
    }
}
