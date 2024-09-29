<?php

namespace App\Http\Livewire\Region\District;

use App\Models\History;
use Livewire\Component;
use App\Models\District;
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
            'name' => 'Nama Kecamatan'
        ];
    }

    public function render()
    {
        return view('livewire.region.district.create');
    }

    public function updated($attribute)
    {
        $this->validateOnly($attribute);
    }

    public function store()
    {
        $this->validate();

        if (!auth()->user()->permissions->some('create district'))
            return abort(403, 'Oooppssss..... Mau ngapain kamu!');

        $new_district = District::create(
            [
                'name' => $this->name
            ]
        );

        History::makeHistory('Menambahkan Kecamatan.', 'district.store', $new_district->id);

        $this->emit('refresh');
        $this->reset();

        $this->dispatchBrowserEvent('closeModal');

        $this->alert(
            'success',
            'Sukses!',
            ['text' => 'Berhasil menambahkan Kecamatan.']
        );
    }
}
