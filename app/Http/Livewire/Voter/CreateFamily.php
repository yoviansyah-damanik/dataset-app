<?php

namespace App\Http\Livewire\Voter;

use App\Models\Dpt;
use App\Models\Tps;
use App\Models\User;
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
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CreateFamily extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $nik,
        $cek_nik,
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
        $ktp,
        $kk,
        $no_telp,
        $preview_ktp,
        $preview_kk;

    public $religions,
        $marital_statuses,
        $professions,
        $nasionalities;

    public $valid_message;
    public $dpts, $dpt;
    public $data;
    public $family_coor;
    public $is_nik_valid = false;
    public $search;
    public $remember = false;

    public $districts,
        $villages,
        $tpses;

    public int $step = 1;
    public bool $is_empty = false;

    public function mount() {}

    public function render()
    {
        if ($this->step == 1) {
            $this->data = Dpt::with('tps', 'village', 'district')->where('name', 'like', $this->search . '%')
                ->whereDoesntHave('voter')
                ->limit(20)
                ->get();
        }

        if ($this->step == 2) {
            $this->data = User::with('voters_by_family', 'district', 'village', 'tps', 'roles')
                ->withCount('voters_by_family')
                ->role('Koordinator Keluarga')
                ->whereEncrypted('fullname', 'like', "%$this->search%")
                ->limit(10)
                ->get();
        }

        if ($this->step == 3) {
            $this->reset('data');
        }

        return view('livewire.voter.create-family');
    }

    public function updated($attribute)
    {
        // $this->resetValidation();

        if ($attribute == 'ktp')
            $this->preview_ktp = $this->ktp->temporaryUrl();

        if ($attribute == 'kk')
            $this->preview_kk = $this->kk->temporaryUrl();
    }

    public function set_districts()
    {
        $this->districts = District::get();
        $this->kecamatan = $this->districts->where('id', $this->kecamatan)->first()->id;
        $this->set_villages();
    }

    public function set_villages()
    {
        $this->villages = Village::where('district_id', $this->kecamatan)->get();
        $this->kelurahan = $this->villages->where('id', $this->kelurahan)->first()->id;
        $this->set_tpses();
    }

    public function set_tpses()
    {
        $this->tpses = Tps::where('village_id', $this->kelurahan)->get();
        $this->tps = $this->tpses->where('id', $this->tps)->first()->id;
    }

    public function next_step()
    {
        $this->reset('search');
        switch ($this->step) {
            case 1:
                if (!$this->dpt) {
                    $this->alert('warning', 'Silahkan pilih DPT terlebih dahulu.');
                    return;
                }
                if (!$this->nik) {
                    $this->alert('warning', 'Silahkan masukkan NIK yang valid.');
                    return;
                }
                $this->check_nik();
                $this->reset('valid_message');

                if ($this->remember) {
                    $this->set_init();
                    $this->step = 3;
                }

                break;
            case 2:
                if (!$this->family_coor) {
                    $this->alert('warning', 'Silahkan pilih Koordinator Keluarga terlebih dahulu.');
                    return;
                }

                $this->set_init();
                break;
        }

        if (!$this->remember)
            $this->step++;
    }

    public function store()
    {
        $this->validate([
            'nik' => 'required|numeric|unique:voters,nik|digits:16',
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
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
                // Rule::in(Village::where('district_id', $this->kecamatan)->get('id')->pluck('id')->toArray())
            ],
            'tps' => [
                'required',
                'numeric',
                'exists:tps,id',
                // Rule::in(Tps::where('village_id', $this->kelurahan)->get('id')->pluck('id')->toArray())
            ],
            'agama' => [
                'required',
                Rule::in($this->religions->pluck('id')->toArray())
            ],
            'status_perkawinan' => [
                'required',
                Rule::in($this->marital_statuses->pluck('id')->toArray())
            ],
            'pekerjaan' => [
                'required',
                Rule::in($this->professions->pluck('id')->toArray())
            ],
            'kewarganegaraan' => [
                'required',
                Rule::in($this->nasionalities->pluck('id')->toArray())
            ],
            'no_telp' => 'nullable|numeric',
            'ktp' => 'nullable|file|image|max:2048',
            'kk' => 'nullable|file|image|max:2048',
        ]);

        DB::beginTransaction();
        try {
            if ($this->kk)
                $ktp_filename = $this->kk->store('voters', 'public');
            if ($this->ktp)
                $kk_filename = $this->ktp->store('voters', 'public');

            $new_voter = new Voter;
            $new_voter->name = $this->nama;
            if ($this->ktp)
                $new_voter->ktp = $ktp_filename;
            if ($this->kk)
                $new_voter->kk = $kk_filename;
            $new_voter->nik = $this->nik;
            $new_voter->address = $this->alamat ?? null;
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
            $new_voter->phone_number = $this->no_telp ?? null;
            $new_voter->nasionality_id = $this->kewarganegaraan;
            $new_voter->user_id = auth()->user()->id;
            $new_voter->family_coor_id = $this->family_coor->id;
            $new_voter->dpt_id = $this->dpt->id;
            $new_voter->save();

            History::makeHistory('Membuat Pemilih dengan ID: ' . $new_voter->id, $new_voter, 'create', ref_id: $new_voter->id);

            // $permission = Permission::create(['name' => 'show voter ' . $new_voter->id]);

            // if (auth()->user()->role_name == 'Administrator Keluarga') {
            //     $ids = [auth()->user()->id, $this->family_coor->id];

            //     User::whereIn('id', $ids)
            //         ->get()
            //         ->each(
            //             function ($user) use ($permission) {
            //                 $user->givePermissionTo($permission);
            //             }
            //         );
            // }

            // User::where('district_id', $this->kecamatan)
            //     ->orWhere('village_id', $this->kelurahan)
            //     ->orWhere('tps_id', $this->tps)
            //     ->role([
            //         'Superadmin',
            //         'Administrator',
            //         'Koordinator Kecamatan',
            //         'Koordinator Kelurahan/Desa',
            //         'Koordinator TPS'
            //     ])
            //     ->get()
            //     ->each(
            //         function ($user) use ($permission) {
            //             $user->givePermissionTo($permission);
            //         }
            //     );

            DB::commit();
            $this->alert('success', 'Berhasil menambahkan pemilih.');

            if (!$this->remember)
                $this->reset_semua();
            else
                $this->reset_sebagian();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->alert('error', $e->getMessage());
        }
    }

    public function set_init()
    {
        $this->religions = Religion::get();
        $this->marital_statuses = MaritalStatus::get();
        $this->professions = Profession::get();
        $this->nasionalities = Nasionality::get();

        $this->reset([
            'agama',
            'kewarganegaraan',
            'pekerjaan',
            'status_perkawinan'
        ]);

        $this->agama = $this->religions->first()->id;
        $this->kewarganegaraan = $this->nasionalities->first()->id;
        $this->pekerjaan = $this->professions->first()->id;
        $this->status_perkawinan = $this->marital_statuses->first()->id;

        $this->nama = $this->dpt->name;
        $this->jenis_kelamin = $this->dpt->genderFull;
        $this->reset('districts', 'villages', 'tpses', 'data');
        $this->set_districts();
    }

    public function check_nik()
    {
        $this->reset('nik');
        $this->validate(
            [
                'cek_nik' => 'required|string|digits:16',
            ],
            [],
            ['cek_nik' => 'NIK']
        );

        $is_exist = Voter::whereEncrypted('nik', $this->cek_nik)
            ->first();

        $this->reset('valid_message');
        if (!$is_exist) {
            $this->nik = $this->cek_nik;
            $this->is_nik_valid = true;
            $this->valid_message = 'NIK tidak terdaftar dengan pemilih manapun. NIK dapat digunakan.';
        } else {
            $this->step = 1;
            $this->is_nik_valid = false;
            if ($is_exist->family_coor_id)
                $this->valid_message = 'NIK telah didaftarkan oleh <strong>' . $is_exist->created_by->fullname . '</strong> dengan Tim Keluarga <strong>' . $is_exist->family_coor->fullname . '</strong> dengan nama <strong>' . $is_exist->name . '</strong> pada <strong>' . $is_exist->tps->name . ', ' . $is_exist->village->name . ', ' . $is_exist->district->name . '</strong>.';
            else
                $this->valid_message = 'NIK telah didaftarkan oleh <strong>' . $is_exist->created_by->fullname . '</strong> dengan Tim Bersinar <strong>' . $is_exist->team_by->fullname . '</strong> dengan nama <strong>' . $is_exist->name . '</strong> pada <strong>' . $is_exist->tps->name . ', ' . $is_exist->village->name . ', ' . $is_exist->district->name . '</strong>.';
        }
    }

    public function reset_semua()
    {
        $this->reset();
        $this->resetValidation();
        $this->step = 1;
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

    public function reset_sebagian()
    {
        $this->reset(
            'nik',
            'dpt',
            'nama',
            'alamat',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'rt',
            'rw',
            'agama',
            'status_perkawinan',
            'pekerjaan',
            'kewarganegaraan',
            'kk',
            'ktp',
            'no_telp',
            'preview_ktp',
            'preview_kk',
            'cek_nik'
        );
        $this->step = 1;
    }

    public function set_dpt(Dpt $dpt)
    {
        $this->dpt = $dpt;

        $this->kecamatan = $dpt->district_id;
        $this->kelurahan = $dpt->village_id;
        $this->tps = $dpt->tps_id;
    }

    public function set_family_coor(User $user)
    {
        $this->family_coor = $user;
    }

    public function reset_region($region)
    {
        if ($region == 'district')
            $this->reset('village', 'tps_');
        if ($region == 'village')
            $this->reset('tps_');
    }
}
