<?php

namespace App\Http\Livewire\Dpt;

use App\Models\Dpt;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $per_page = 10;
    public $search = '';

    public function render()
    {
        $dpts = Dpt::with('voter')
            ->where('name', 'like', '%' . $this->search . '%')
            ->paginate($this->per_page);

        return view('livewire.dpt.index', compact('dpts'));
    }

    public function updated($attribute)
    {
        $this->resetPage();
    }
}
