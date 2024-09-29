<?php

namespace App\Http\Livewire\Master\Religion;

use App\Models\History;
use Livewire\Component;
use App\Models\Religion;
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
            'name' => 'Nama Agama'
        ];
    }

    public function render()
    {
        return view('livewire.master.religion.create');
    }

    public function updated($attribute)
    {
        $this->validateOnly($attribute);
    }

    public function store()
    {
        $this->validate();

        if (!auth()->user()->permissions->some('create religion'))
            return abort(403, 'Oooppssss..... Mau ngapain kamu!');

        $new_religion = Religion::create(
            [
                'name' => $this->name,
                'user_id' => auth()->user()->id
            ]
        );

        History::makeHistory('Menambahkan Agama.', 'religion.store', $new_religion->id);

        $this->emit('refresh');
        $this->reset();

        $this->dispatchBrowserEvent('closeModal');

        $this->alert(
            'success',
            'Sukses!',
            ['text' => 'Berhasil menambahkan Agama.']
        );
    }
}
