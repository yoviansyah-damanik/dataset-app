<?php

namespace App\Http\Livewire\Master\Profession;

use App\Models\History;
use Livewire\Component;
use App\Models\Profession;
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
            'name' => 'Nama Pekerjaan'
        ];
    }

    public function render()
    {
        return view('livewire.master.profession.create');
    }

    public function updated($attribute)
    {
        $this->validateOnly($attribute);
    }


    public function store()
    {
        $this->validate();

        if (!auth()->user()->permissions->some('create profession'))
            return abort(403, 'Oooppssss..... Mau ngapain kamu!');

        $new_profession = Profession::create(
            [
                'name' => $this->name,
                'user_id' => auth()->user()->id
            ]
        );

        History::makeHistory('Menambahkan Pekerjaan.', 'profession.store', $new_profession->id);

        $this->emit('refresh');
        $this->reset();

        $this->dispatchBrowserEvent('closeModal');

        $this->alert(
            'success',
            'Sukses!',
            ['text' => 'Berhasil menambahkan Pekerjaan.']
        );
    }
}
