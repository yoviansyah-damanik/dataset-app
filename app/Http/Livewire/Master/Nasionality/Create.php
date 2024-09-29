<?php

namespace App\Http\Livewire\Master\Nasionality;

use App\Models\History;
use Livewire\Component;
use App\Models\Nasionality;
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
            'name' => 'Nama Kewarganegaraan'
        ];
    }

    public function render()
    {
        return view('livewire.master.nasionality.create');
    }

    public function updated($attribute)
    {
        $this->validateOnly($attribute);
    }

    public function store()
    {
        $this->validate();

        if (!auth()->user()->permissions->some('create nasionality'))
            return abort(403, 'Oooppssss..... Mau ngapain kamu!');

        $new_nasionality = Nasionality::create(
            [
                'name' => $this->name,
                'user_id' => auth()->user()->id
            ]
        );

        History::makeHistory('Menambahkan Kewarganegaraan.', 'nasionality.store', $new_nasionality->id);

        $this->emit('refresh');
        $this->reset();

        $this->dispatchBrowserEvent('closeModal');

        $this->alert(
            'success',
            'Sukses!',
            ['text' => 'Berhasil menambahkan Kewarganegaraan.']
        );
    }
}
