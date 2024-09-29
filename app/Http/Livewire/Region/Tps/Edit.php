<?php

namespace App\Http\Livewire\Region\Tps;

use App\Models\Village;
use Livewire\Component;
use App\Models\District;
use App\Models\Tps;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Edit extends Component
{
    use LivewireAlert;
    protected $listeners = ['set_edit_tps'];

    public $district_id, $village_id, $tps_id, $name, $voters_total;

    public function render()
    {
        $districts = District::orderBy('name', 'asc')
            ->get();

        return view('livewire.region.tps.edit', compact('districts'));
    }

    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'district_id' => [
                'required',
                Rule::in(District::get()->pluck('id'))
            ],
            'village_id' => [
                'required',
                Rule::in(Village::get()->pluck('id'))
            ],
            'voters_total' => 'required|numeric'
        ];
    }

    public function validationAttributes()
    {
        return [
            'name' => 'Nama TPS',
            'district_id' => 'Kecamatan',
            'village_id' => 'Kecamatan',
            'voters_total' => 'Total DPT'
        ];
    }

    public function set_edit_tps($district_id, $village_id, $tps_id)
    {
        $tps = Tps::find($tps_id);
        $this->tps_id = $tps->id;
        $this->name = $tps->name;
        $this->voters_total = $tps->voters_total;

        $this->district_id = $district_id;
        $this->village_id = $village_id;
        $villages = Village::orderBy('name', 'asc')
            ->where('district_id', $district_id)
            ->get(['id', 'name'])
            ->map(fn($village) => ['id' => $village->id, 'text' => $village->name])
            ->toArray();
        $this->dispatchBrowserEvent('setVillages', $villages);
        $this->dispatchBrowserEvent('setDistrict', $district_id);
        $this->dispatchBrowserEvent('setVillage', $village_id);
        $this->resetValidation();
    }

    public function update()
    {
        $this->validate();

        if (!auth()->user()->permissions->some('update tps'))
            return abort(403, 'Oooppssss..... Mau ngapain kamu!');

        Tps::find($this->tps_id)
            ->update([
                'village_id' => $this->village_id,
                'name' => $this->name
            ]);

        $this->emit('refresh');
        $this->dispatchBrowserEvent('closeModal');

        $this->alert(
            'success',
            'Sukses!',
            ['text' => 'Berhasil memperbaharui TPS.']
        );
    }
}
