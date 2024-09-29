<?php

namespace App\Http\Livewire\Region\Village;

use App\Models\Village;
use Livewire\Component;
use App\Models\District;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Create extends Component
{
    use LivewireAlert;
    public $name, $district_id;

    public function render()
    {
        $districts = District::orderBy('name', 'asc')->get();

        return view('livewire.region.village.create', compact('districts'));
    }

    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'district_id' => [
                'required',
                Rule::in(District::get()->pluck('id')->toArray())
            ]
        ];
    }

    public function validationAttributes()
    {
        return [
            'name' => 'Nama Kelurahan/Desa',
            'district_id' => 'Kecamatan'
        ];
    }

    public function updated($attribute)
    {
        $this->validateOnly($attribute);
    }

    public function store()
    {
        $this->validate();

        if (!auth()->user()->permissions->some('create village'))
            return abort(403, 'Oooppssss..... Mau ngapain kamu!');

        Village::create([
            'district_id' => $this->district_id,
            'name' => $this->name
        ]);

        $this->emit('refresh');
        $this->reset('name');

        $this->dispatchBrowserEvent('closeModal');
        $this->alert(
            'success',
            'Sukses!',
            ['text' => 'Berhasil menambahkan Kelurahan/Desa.']
        );
    }
}
