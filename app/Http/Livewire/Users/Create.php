<?php

namespace App\Http\Livewire\Users;

use App\Models\Tps;
use App\Models\User;
use App\Models\History;
use App\Models\Village;
use Livewire\Component;
use App\Models\District;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Create extends Component
{
    use LivewireAlert;

    public $username,
        $fullname,
        $email,
        $password,
        $role_name,
        $district_id,
        $village_id,
        $tps_id;

    public bool $is_empty = true;

    public $districts,
        $villages,
        $tps_;

    protected $listeners = ['clear_create_validation'];

    public function render()
    {
        $roles = Role::where('name', '!=', 'Superadmin')
            ->get();

        $this->dispatchBrowserEvent('reloadDistrict', ['is_empty' => false]);

        return view('livewire.users.create', compact('roles'));
    }

    public function rules()
    {
        $rules =  [
            'username' => 'required|unique_encrypted:users,username|max:16',
            'fullname' => 'required',
            'email' => 'required|email:dns|unique_encrypted:users,email',
            'password' => 'required|min:8',
            'role_name' => [
                'required',
                Rule::in(Role::get()->pluck('name'))
            ]
        ];

        if (in_array($this->role_name, ['Koordinator Kecamatan', 'Administrator']))
            $rules += [
                'district_id' => [
                    'required',
                    Rule::in(District::get()->pluck('id'))
                ]
            ];

        if ($this->role_name == 'Koordinator Kelurahan/Desa')
            $rules += [
                'district_id' => [
                    'required',
                    Rule::in(District::get()->pluck('id'))
                ],
                'village_id' => [
                    'required',
                    Rule::in(Village::where('district_id', $this->district_id)->get()->pluck('id'))
                ]
            ];

        if (in_array($this->role_name, ['Koordinator TPS', 'Tim Bersinar']))
            $rules += [
                'district_id' => [
                    'required',
                    Rule::in(District::get()->pluck('id'))
                ],
                'village_id' => [
                    'required',
                    Rule::in(Village::where('district_id', $this->district_id)->get()->pluck('id'))
                ],
                'tps_id' => [
                    'required',
                    Rule::in(Tps::whereHas('village', fn($q) => $q->where('district_id', $this->district_id))
                        ->where('village_id', $this->village_id)
                        ->get()
                        ->pluck('id'))
                ]
            ];

        return $rules;
    }

    public function validationAttributes()
    {
        return [
            'username' => 'nama penguna',
            'fullname' => 'nama lengkap',
            'district_id' => 'kecamatan',
            'village_id' => 'kelurahan/Desa',
            'tps_id' => 'TPS',
            'role_name' => 'peran',
            'password' => 'kata Sandi'
        ];
    }

    public function updated($attribute)
    {
        $this->validateOnly($attribute);
    }

    public function store()
    {
        $this->validate();

        if ($this->role_name == 'Koordinator Kecamatan') {
            $exist_user = User::role('Administrator')
                ->where('district_id', $this->district_id)
                ->first();

            if ($exist_user) {
                $this->alert('warning', 'Administrator pada kecamatan sudah ada.');
                return;
            }
        }

        $new_user = new User;
        $new_user->username = $this->username;
        $new_user->fullname = $this->fullname;
        $new_user->email = $this->email;
        if ($this->role_name == 'Koordinator Kecamatan') {
            $new_user->district_id = $this->district_id;
        } elseif ($this->role_name == 'Koordinator Kelurahan/Desa') {
            $new_user->district_id = $this->district_id;
            $new_user->village_id = $this->village_id;
        } else {
            $new_user->district_id = $this->district_id;
            $new_user->village_id = $this->village_id;
            $new_user->tps_id = $this->tps_id;
        }
        $new_user->password = Hash::make($this->password);
        $new_user->save();

        $new_user->assignRole($this->role_name);

        History::makeHistory('Mendaftarkan pengguna baru.', 'user.store', $new_user->id);

        $this->alert(
            'success',
            'Sukses!',
            ['text' => 'Pengguna berhasil ditambahkan.']
        );

        $this->reset();
        $this->is_empty = true;
        $this->emit('close_modal');
        $this->emit('refresh_users');
    }

    public function set_init()
    {
        $this->districts = District::get();
        $this->villages = $this->villages_data();
        $this->tps_ = $this->tpses_data();

        $this->district_id = null;
        $this->village_id = null;
        $this->tps_id = null;

        $this->dispatchBrowserEvent('reloadDistrict', ['is_empty' => $this->is_empty]);
    }

    public function set_villages()
    {
        $villages = $this->villages_data();

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

    public function set_tpses()
    {
        $tpses =  $this->tpses_data();

        $this->dispatchBrowserEvent('setTpsData', $tpses->map(function ($q, $index) {
            $data = [
                'id' => $q->id,
                'text' => $q->name
            ];
            if ($index == 0) {
                $data += [
                    'selected' => true
                ];
                $this->tps_id = $q->id;
            }
            return $data;
        }));
    }

    public function villages_data()
    {
        return Village::where('district_id', $this->district_id)
            ->limit(10)
            ->get();
    }

    public function tpses_data()
    {
        return Tps::whereHas('village', fn($q) => $q->where('district_id', $this->district_id))
            ->where('village_id', $this->village_id)
            ->limit(10)
            ->get();
    }

    public function clear_create_validation()
    {
        $this->resetValidation();
    }
}
