<?php

namespace App\Http\Livewire\Log;

use App\Models\History;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $type, $title;

    public function mount()
    {
        $this->type = 'user';
        $this->title = 'Log Aktivitas Pengguna';
    }

    public function render()
    {
        $histories = History::with('user')
            ->latest();

        if ($this->type == 'user')
            $histories = $histories->where('user_id', Auth::id());

        $histories = $histories->paginate(10);

        return view('livewire.log.index', compact('histories'));
    }
}
