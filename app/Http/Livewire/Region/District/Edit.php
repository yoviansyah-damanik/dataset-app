<?php

namespace App\Http\Livewire\Region\District;

use Livewire\Component;
use App\Models\District;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Edit extends Component
{
    use LivewireAlert;

    protected $listeners = ['set_edit_district'];

    public $district_id, $name;

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
        return view('livewire.region.district.edit');
    }

    public function set_edit_district($id)
    {
        $district = District::find($id);
        $this->district_id = $district->id;
        $this->name = $district->name;
        $this->resetValidation();
    }

    public function update()
    {
        $this->validate();

        if (!auth()->user()->permissions->some('update district'))
            return abort(403, 'Oooppssss..... Mau ngapain kamu!');

        District::find($this->district_id)
            ->update(['name' => $this->name]);

        $this->emit('refresh');
        $this->dispatchBrowserEvent('closeModal');

        $this->alert(
            'success',
            'Sukses!',
            ['text' => 'Berhasil memperbaharui Kecamatan.']
        );
    }
}
