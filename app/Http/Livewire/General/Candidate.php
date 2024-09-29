<?php

namespace App\Http\Livewire\General;

use Livewire\Component;
use App\Models\Configuration;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Candidate extends Component
{
    use WithFileUploads, LivewireAlert;

    public $candidate_1_name;
    public $candidate_1_picture;
    public $candidate_2_name;
    public $candidate_2_picture;
    public $candidate_callsign;

    public function mount()
    {
        $configs = Configuration::whereIn('attribute', [
            'candidate_1_name',
            'candidate_1_picture',
            'candidate_2_name',
            'candidate_2_picture',
            'candidate_callsign',
        ])
            ->get()->pluck('value', 'attribute')->toArray();

        extract($configs);

        $this->candidate_1_name = $candidate_1_name;
        $this->candidate_1_picture = $candidate_1_picture;
        $this->candidate_2_name = $candidate_2_name;
        $this->candidate_2_picture = $candidate_2_picture;
        $this->candidate_callsign = $candidate_callsign;
    }

    public function render()
    {
        return view('livewire.general.candidate');
    }

    public function rules()
    {
        return [
            'candidate_1_picture' => 'nullable|image|max:1024|dimensions:ratio=1/1,min_height:400',
            'candidate_2_picture' => 'nullable|image|max:1024|dimensions:ratio=1/1,min_height:400',
            'candidate_1_name' => 'required|string|max:200',
            'candidate_2_name' => 'required|string|max:200'
        ];
    }

    public function validationAttributes()
    {
        return [
            'candidate_1_picture' => "Gambar Calon " . $this->candidate_callsign,
            'candidate_2_picture' => "Gambar Calon Wakil " . $this->candidate_callsign,
            'candidate_1_name' => "Nama Calon " . $this->candidate_callsign,
            'candidate_2_name' => "Nama Calon Wakil " . $this->candidate_callsign,
        ];
    }

    public function updated($attribute)
    {
        $this->validateOnly($attribute);
    }

    public function update_1()
    {
        $this->validateOnly('candidate_1_picture');
        $this->validateOnly('candidate_1_name');

        try {
            if ($this->candidate_1_picture) {
                $candidate_1_picture_filename = 'storage/' . $this->candidate_1_picture->storeAs('configuration', date('ymdHis') . '_CANDIDATE_1.' . $this->candidate_1_picture->getClientOriginalExtension(), 'public');

                $candidate_1_picture = Configuration::where('attribute', 'candidate_1_picture');
                Storage::delete("public/" . $candidate_1_picture->first()->value);

                $candidate_1_picture->update(['value' => $candidate_1_picture_filename]);
            }

            Configuration::where('attribute', 'candidate_1_name')
                ->update(['value' => $this->candidate_1_name]);

            $this->alert('success', 'Berhasil memperbaharui data Calon ' . $this->candidate_callsign . '.');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        } catch (\Throwable $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function update_2()
    {
        $this->validateOnly('candidate_2_picture');
        $this->validateOnly('candidate_2_name');

        try {
            if ($this->candidate_2_picture) {
                $candidate_2_picture_filename = 'storage/' . $this->candidate_2_picture->storeAs('configuration', date('ymdHis') . '_CANDIDATE_2.' . $this->candidate_2_picture->getClientOriginalExtension(), 'public');

                $candidate_2_picture = Configuration::where('attribute', 'candidate_2_picture');
                Storage::delete("public/" . $candidate_2_picture->first()->value);

                $candidate_2_picture->update(['value' => $candidate_2_picture_filename]);
            }

            Configuration::where('attribute', 'candidate_2_name')
                ->update(['value' => $this->candidate_2_name]);

            $this->alert('success', 'Berhasil memperbaharui data Calon Wakil ' . $this->candidate_callsign . '.');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        } catch (\Throwable $e) {
            $this->alert('error', $e->getMessage());
        }
    }
}
