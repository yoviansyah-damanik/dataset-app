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
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Create extends Component
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
        $agama,
        $status_perkawinan,
        $pekerjaan,
        $kewarganegaraan,
        $ktp,
        $kk,
        $no_telp,
        $tps,
        $preview_ktp,
        $preview_kk;

    public $religions,
        $marital_statuses,
        $professions,
        $nasionalities;

    public $valid_message;
    public $dpts, $dpt;
    public $data;
    public $district_coor, $village_coor, $tps_coor, $team;
    public $is_nik_valid = false;
    public $search;
    public $remember = false;

    public $districts,
        $villages,
        $tpses,
        $district,
        $village,
        $tps_;

    public int $step = 1;
    public bool $is_empty = false;

    public function mount() {}

    public function render()
    {
        if ($this->step != 2)
            $this->reset('districts', 'villages', 'tpses');

        if ($this->step == 1) {
            $this->data = Dpt::with('tps', 'village', 'district')->where('name', 'like', '%' . $this->search . '%')
                ->whereDoesntHave('voter')
                ->limit(10)
                ->get();
        }

        if ($this->step == 2) {
            if (auth()->user()->role_name == 'Superadmin') {
                $this->districts = District::get();

                if (!$this->district)
                    $this->district = $this->districts->first()->id;

                $this->villages = Village::when(
                    $this->district,
                    fn($q) => $q->where('district_id', $this->district),
                    fn($q) => $q->whereNull('id')
                )
                    ->get();

                if (!$this->village)
                    $this->village = $this->villages->first()->id;

                $this->tpses = Tps::when(
                    $this->village,
                    fn($q) => $q->where('village_id', $this->village),
                    fn($q) => $q->whereNull('id')
                )
                    ->get();

                if (!$this->tps_)
                    $this->tps_ = $this->tpses->first()->id;
            }

            $this->data = User::with('voters_by_team', 'district', 'village', 'tps', 'roles')
                ->withCount('voters_by_team')
                ->role('Tim Bersinar')
                ->when(
                    auth()->user()->role_name != 'Superadmin',
                    fn($q) => $q->where('district_id', auth()->user()->district_id),
                    fn($q) => $q->when(
                        $this->district,
                        fn($r) => $r->where('district_id', $this->district)
                    )
                        ->when(
                            $this->village,
                            fn($r) => $r->where('village_id', $this->village)
                        )
                        ->when(
                            $this->tps_,
                            fn($r) => $r->where('tps_id', $this->tps_)
                        )
                )
                ->whereEncrypted('fullname', 'like', "%$this->search%")
                ->limit(10)
                ->get();
        }

        if ($this->step == 3) {
            $this->data = User::with('voters_by_team', 'district', 'village', 'tps', 'roles')
                ->withCount('voters_by_team')
                ->role('Koordinator Kecamatan')
                ->where('district_id', $this->kecamatan)
                ->whereEncrypted('fullname', 'like', "%$this->search%")
                ->limit(10)
                ->get();
        }

        if ($this->step == 4) {
            $this->data = User::with('voters_by_team', 'district', 'village', 'tps', 'roles')
                ->withCount('voters_by_team')
                ->role('Koordinator Kelurahan/Desa')
                ->where('district_id', $this->kecamatan)
                ->where('village_id', $this->kelurahan)
                ->whereEncrypted('fullname', 'like', "%$this->search%")
                ->limit(10)
                ->get();
        }

        if ($this->step == 5) {
            $this->data = User::with('voters_by_team', 'district', 'village', 'tps', 'roles')
                ->withCount('voters_by_team')
                ->role('Koordinator TPS')
                ->where('district_id', $this->kecamatan)
                ->where('village_id', $this->kelurahan)
                ->where('tps_id', $this->tps)
                ->whereEncrypted('fullname', 'like', "%$this->search%")
                ->limit(10)
                ->get();
        }

        if ($this->step == 6) {
            $this->reset('data');
        }

        $this->dispatchBrowserEvent('reloadDistrict', ['is_empty' => false]);
        $this->dispatchBrowserEvent('reloadAdditionalInput', ['is_empty' => false]);
        return view('livewire.voter.create');
    }

    public function updated($attribute)
    {
        // $this->resetValidation();

        if ($attribute == 'ktp')
            $this->preview_ktp = $this->ktp->temporaryUrl();

        if ($attribute == 'kk')
            $this->preview_kk = $this->kk->temporaryUrl();
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
                    $this->step = 6;
                }

                break;
            case 2:
                if (!$this->team) {
                    $this->alert('warning', 'Silahkan pilih Tim Bersinar terlebih dahulu.');
                    return;
                }
                break;
            case 3:
                if (!$this->district_coor) {
                    $this->alert('warning', 'Silahkan pilih Tim Bersinar terlebih dahulu.');
                    return;
                }
                break;
            case 4:
                if (!$this->village_coor) {
                    $this->alert('warning', 'Silahkan pilih Tim Bersinar terlebih dahulu.');
                    return;
                }
                break;
            case 5:
                if (!$this->tps_coor) {
                    $this->alert('warning', 'Silahkan pilih Tim Bersinar terlebih dahulu.');
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
            'ktp' => 'required|file|image|max:2048',
            'kk' => 'required|file|image|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $ktp_filename = $this->kk->store('voters', 'public');
            $kk_filename = $this->ktp->store('voters', 'public');

            $new_voter = new Voter;
            $new_voter->name = $this->nama;
            $new_voter->ktp = $ktp_filename;
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
            $new_voter->district_coor_id = $this->district_coor->id;
            $new_voter->village_coor_id = $this->village_coor->id;
            $new_voter->tps_coor_id = $this->tps_coor->id;
            $new_voter->team_id = $this->team->id;
            $new_voter->dpt_id = $this->dpt->id;
            $new_voter->save();

            if (!$this->remember)
                $this->reset_semua();
            else
                $this->reset_sebagian();

            History::makeHistory('Membuat Pemilih dengan ID: ' . $new_voter->id, $new_voter, 'create', ref_id: $new_voter->id);

            DB::commit();
            $this->alert('success', 'Berhasil menambahkan pemilih.');
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

        $this->dispatchBrowserEvent('reloadAdditionalInput', ['is_empty' => true]);

        $this->nama = $this->dpt->name;
        $this->jenis_kelamin = $this->dpt->genderFull;

        $this->reset('districts', 'villages', 'tpses', 'data');
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
            $this->valid_message = 'NIK telah didaftarkan oleh <strong>' . $is_exist->created_by->fullname . '</strong> dengan Tim Bersinar <strong>' . $is_exist->team_by->fullname . '</strong> dengan nama <strong>' . $is_exist->name . '</strong> pada <strong>' . $is_exist->tps->name . ', ' . $is_exist->village->name . ', ' . $is_exist->district->name . '</strong>.';
        }
    }

    public function reset_semua()
    {
        $this->reset();
        $this->resetValidation();
        $this->step = 1;
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
    }

    public function set_district_coor(User $user)
    {
        $this->district_coor = $user;
    }

    public function set_village_coor(User $user)
    {
        $this->village_coor = $user;
    }

    public function set_tps_coor(User $user)
    {
        $this->tps_coor = $user;
    }

    public function set_team(User $user)
    {
        $this->kecamatan = $user->district_id;
        $this->kelurahan = $user->village_id;
        $this->tps = $user->tps_id;

        $this->team = $user;
    }

    public function reset_region($region)
    {
        if ($region == 'district')
            $this->reset('village', 'tps_');
        if ($region == 'village')
            $this->reset('tps_');
    }
}
