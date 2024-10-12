<?php

namespace App\Http\Livewire\Voter;

use App\Models\Tps;
use App\Models\Voter;
use App\Models\History;
use App\Models\Village;
use Livewire\Component;
use App\Models\District;
use App\Models\Religion;
use App\Models\Profession;
use App\Models\Nasionality;
use App\Models\MaritalStatus;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Edit extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $old_voter, $currentNik,
        $nik,
        $nama,
        $alamat,
        $tempat_lahir,
        $tanggal_lahir,
        $jenis_kelamin,
        $rt,
        $rw,
        $kecamatan,
        $kelurahan,
        $tps,
        $agama,
        $status_perkawinan,
        $pekerjaan,
        $kewarganegaraan,
        $no_telp,
        $preview_ktp,
        $preview_kk,
        $preview_ktp_old,
        $preview_kk_old,
        $id_voter,
        $ktp,
        $kk,
        $current_ktp,
        $current_kk;

    public $districts,
        $villages,
        $tps_,
        $religions,
        $marital_statuses,
        $professions,
        $nasionalities;

    public bool $is_empty = true;

    public function mount($voter)
    {
        if (!in_array(auth()->user()->role_name, ['Superadmin', 'Administrator']) && $voter->user_id != auth()->user()->id)
            return abort(401);

        $this->set_init();

        $this->old_voter = $voter;
        $this->id_voter = $voter->id;
        $this->currentNik = $voter->nik;
        $this->nik = $voter->nik;
        $this->nama = $voter->name;
        $this->alamat = $voter->address;
        $this->tempat_lahir = $voter->place_of_birth;
        $this->tanggal_lahir = $voter->date_of_birth->format('Y-m-d');
        $this->jenis_kelamin = $voter->gender;
        $this->rt = $voter->rt;
        $this->rw = $voter->rw;
        $this->kecamatan = $voter->district_id;
        $this->kelurahan = $voter->village_id;
        $this->tps = $voter->tps_id;
        $this->agama = $voter->religion_id;
        $this->status_perkawinan = $voter->marital_status_id;
        $this->pekerjaan = $voter->profession_id;
        $this->kewarganegaraan = $voter->nasionality_id;
        if ($voter->ktp) {
            $this->current_ktp = $voter->ktp;
            $this->preview_ktp_old = $voter->ktp_path;
        }
        if ($voter->kk) {
            $this->current_kk = $voter->kk;
            $this->preview_kk_old = $voter->kk_path;
        }
        $this->no_telp = $voter->phone_number;

        // $this->dispatchBrowserEvent('reloadAdditionalInput');
    }

    public function set_init()
    {
        // $this->districts = District::get();
        // $this->villages = $this->villages_data();
        // $this->tps_ = $this->tpses_data();
        $this->religions = Religion::get();
        $this->marital_statuses = MaritalStatus::get();
        $this->professions = Profession::get();
        $this->nasionalities = Nasionality::get();

        // $this->dispatchBrowserEvent('reloadDistrict', ['is_empty' => true]);
        $this->dispatchBrowserEvent('reloadAdditionalInput');

        // $this->dispatchBrowserEvent('setRegionData', [
        //     'district_id' => $this->kecamatan,
        //     'village_id' => $this->kelurahan,
        //     'tps_id' => $this->tps,
        // ]);

        // $this->dispatchBrowserEvent('setAdditionalData', [
        //     'religion_id' => $this->agama,
        //     'marital_status_id' => $this->status_perkawinan,
        //     'profession_id' => $this->pekerjaan,
        //     'nasionality_id' => $this->kewarganegaraan,
        // ]);
    }

    public function render()
    {
        return view('livewire.voter.edit');
    }

    public function rules()
    {
        return [
            'nik' => ['required', 'numeric', 'digits:16', Rule::unique('voters')->ignore($this->currentNik, 'nik')],
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => [
                'required',
                Rule::in(["Laki-laki", "Perempuan"])
            ],
            'rt' => 'nullable|string',
            'rw' => 'nullable|string',
            'kecamatan' => 'required|numeric|exists:districts,id',
            'kelurahan' => [
                'required',
                'numeric',
                'exists:villages,id',
                Rule::in(Village::where('district_id', $this->kecamatan)->get()->pluck('id'))
            ],
            'tps' => [
                'required',
                'numeric',
                'exists:tps,id',
                Rule::in(Tps::where('village_id', $this->kelurahan)->get()->pluck('id'))
            ],
            'agama' => [
                'required',
                Rule::in(Religion::get()->pluck('id')->toArray())
            ],
            'status_perkawinan' => [
                'required',
                Rule::in(MaritalStatus::get()->pluck('id')->toArray())
            ],
            'pekerjaan' => [
                'required',
                Rule::in(Profession::get()->pluck('id')->toArray())
            ],
            'kewarganegaraan' => [
                'required',
                Rule::in(Nasionality::get()->pluck('id')->toArray())
            ],
            'no_telp' => 'nullable|numeric',
            'ktp' => 'nullable|file|image|max:2048',
            'kk' => 'nullable|file|image|max:2048',
        ];
    }

    public function updated($attribute)
    {
        if ($attribute == 'ktp')
            $this->preview_ktp = $this->ktp->temporaryUrl();

        if ($attribute == 'kk')
            $this->preview_kk = $this->kk->temporaryUrl();
    }

    public function setNull($type)
    {
        if ($type == 'ktp') {
            $this->reset(['ktp', 'preview_ktp']);
        }
        if ($type == 'kk') {
            $this->reset(['kk', 'preview_kk']);
        }
    }

    public function update()
    {
        $this->validate();
        try {
            $ktp = $this->ktp;
            if ($ktp) {
                if ($this->current_ktp)
                    Storage::disk('public')->delete($this->current_ktp);
                $ktp_filename = $ktp->store('voters', 'public');
            }

            $kk = $this->kk;
            if ($kk) {
                if ($this->current_kk)
                    Storage::disk('public')->delete($this->current_kk);
                $kk_filename = $kk->store('voters', 'public');
            }

            $new_voter = Voter::find($this->id_voter);
            $new_voter->name = $this->nama;
            if ($ktp)
                $new_voter->ktp = $ktp_filename;
            if ($kk)
                $new_voter->kk = $kk_filename;

            // $new_voter->nik = $this->nik;
            $new_voter->address = $this->alamat;
            $new_voter->place_of_birth = $this->tempat_lahir;
            $new_voter->date_of_birth = $this->tanggal_lahir;
            $new_voter->gender = $this->jenis_kelamin;
            $new_voter->rt = sprintf('%02d', $this->rt) ?? 0;
            $new_voter->rw = sprintf('%02d', $this->rw) ?? 0;
            $new_voter->district_id = $this->kecamatan;
            $new_voter->village_id = $this->kelurahan;
            $new_voter->tps_id = $this->tps;
            $new_voter->religion_id = $this->agama;
            $new_voter->marital_status_id = $this->status_perkawinan;
            $new_voter->profession_id = $this->pekerjaan;
            $new_voter->phone_number = $this->no_telp;
            $new_voter->nasionality_id = $this->kewarganegaraan;
            $new_voter->save();

            History::makeHistory('Memperbaharui Pemilih dengan ID: ' . $new_voter->id, 'Old: ' . $this->old_voter . ' New:' . $new_voter, 'edit', ref_id: $new_voter->id);
            Alert::toast('Berhasil memperbaharui pemilih.', 'success');
            return redirect()->route('voters.show', $this->id_voter);
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }
}
