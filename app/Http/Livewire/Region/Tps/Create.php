<?php

namespace App\Http\Livewire\Region\Tps;

use App\Models\Tps;
use App\Models\Village;
use Livewire\Component;
use App\Models\District;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Create extends Component
{
    use LivewireAlert;
    public $name, $district_id, $village_id, $voters_total;

    public function render()
    {
        $districts = District::orderBy('name', 'asc')
            ->get();

        $villages = Village::where('district_id', $this->district_id)
            ->orderBy('name', 'asc')
            ->get();

        return view('livewire.region.tps.create', compact('districts', 'villages'));
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

    public function updated($attribute)
    {
        $this->validateOnly($attribute);
    }

    public function store()
    {
        $this->validate();

        if (!auth()->user()->permissions->some('create tps'))
            return abort(403, 'Oooppssss..... Mau ngapain kamu!');

        Tps::create([
            'village_id' => $this->village_id,
            'name' => $this->name,
            'voters_total' => $this->voters_total
        ]);

        $this->emit('refresh');
        $this->reset('name');

        $this->dispatchBrowserEvent('closeModal');
        // $this->set_villages();
        $this->alert(
            'success',
            'Sukses!',
            ['text' => 'Berhasil menambahkan TPS.']
        );
    }

    public function set_villages()
    {
        $villages = Village::where('district_id', $this->district_id)
            ->orderBy('name', 'asc')
            ->get();

        $this->dispatchBrowserEvent('setVillageData', $villages->map(function ($q, $index) {
            $data = [
                'id' => $q->id,
                'text' => $q->name
            ];
            if ($index == 0) {
                $data += [
                    'selected' => true
                ];
                $this->village_id = $q->id;
            }
            return $data;
        }));
    }
}
