<?php

namespace App\Http\Livewire\Region\Village;

use App\Models\Village;
use Livewire\Component;
use App\Models\District;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Edit extends Component
{
    use LivewireAlert;
    protected $listeners = ['set_edit_village'];

    public $district_id, $village_id, $name;

    public function render()
    {
        $districts = District::orderBy('name', 'asc')
            ->get();

        return view('livewire.region.village.edit', compact('districts'));
    }

    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'district_id' => [
                'required',
                Rule::in(District::get()->pluck('id'))
            ]
        ];
    }

    public function set_edit_village($district_id, $village_id)
    {
        $village = Village::find($village_id);
        $this->district_id = $district_id;
        $this->village_id = $village->id;
        $this->name = $village->name;
        $this->dispatchBrowserEvent('setDistrict', $district_id);
        $this->resetValidation();
    }

    public function update()
    {
        $this->validate();

        if (!auth()->user()->permissions->some('edit village'))
            return abort(403, 'Oooppssss..... Mau ngapain kamu!');

        Village::find($this->village_id)
            ->update([
                'district_id' => $this->district_id,
                'name' => $this->name
            ]);

        $this->emit('refresh');
        $this->dispatchBrowserEvent('closeModal');

        $this->alert(
            'success',
            'Sukses!',
            ['text' => 'Berhasil memperbaharui Kelurahan/Kecamatan.']
        );
    }
}
