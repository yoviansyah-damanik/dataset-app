<?php

namespace App\Http\Livewire\Master\MaritalStatus;

use App\Models\History;
use Livewire\Component;
use App\Models\MaritalStatus;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Create extends Component
{
    use LivewireAlert;
    public $name;

    protected $rules = [
        'name' => 'required|string|max:255'
    ];

    public function validationAttributes()
    {
        return [
            'name' => 'Nama Status Perkawinan'
        ];
    }

    public function render()
    {
        return view('livewire.master.marital-status.create');
    }

    public function updated($attribute)
    {
        $this->validateOnly($attribute);
    }


    public function store()
    {
        $this->validate();

        if (!auth()->user()->permissions->some('create marital_status'))
            return abort(403, 'Oooppssss..... Mau ngapain kamu!');

        $new_marital_status = MaritalStatus::create(
            [
                'name' => $this->name,
                'user_id' => auth()->user()->id
            ]
        );

        History::makeHistory('Menambahkan Status Perwakinan.', 'marital_status.store', $new_marital_status->id);

        $this->emit('refresh');
        $this->reset();

        $this->dispatchBrowserEvent('closeModal');

        $this->alert(
            'success',
            'Sukses!',
            ['text' => 'Berhasil menambahkan Status Perwakinan.']
        );
    }
}
