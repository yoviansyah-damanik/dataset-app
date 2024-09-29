<?php

namespace App\Http\Livewire\Users;

use App\Models\Tps;
use App\Models\User;
use App\Models\History;
use App\Models\Village;
use Livewire\Component;
use App\Models\District;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Edit extends Component
{
    use LivewireAlert;

    public $user_id,
        $role_name,
        $district_id,
        $village_id,
        $tps_id;

    protected $listeners = ['set_edit_user'];

    public function render()
    {
        $roles = Role::where('id', '!=', 1)
            ->get();

        return view('livewire.users.edit', compact('roles'));
    }

    public function rules()
    {
        $rules = [
            'role_name' => [
                'required',
                Rule::in(Role::get()->pluck('name'))
            ]
        ];
        if ($this->role_name == 'Koordinator Kecamatan')
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
                    Rule::in(Village::get()->pluck('id'))
                ]
            ];

        if ($this->role_name == 'Koordinator TPS')
            $rules += [
                'district_id' => [
                    'required',
                    Rule::in(District::get()->pluck('id'))
                ],
                'village_id' => [
                    'required',
                    Rule::in(Village::get()->pluck('id'))
                ],
                'tps_id' => [
                    'required',
                    Rule::in(Tps::get()->pluck('id'))
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
            'role_name' => 'role',
            'password' => 'kata Sandi'
        ];
    }

    public function updated($attribute)
    {
        $this->validateOnly($attribute);
    }

    public function set_role()
    {
        if ($this->role_name == 'Koordinator Kecamatan') {
            $this->district_id = null;
            $this->set_districts();
            $this->dispatchBrowserEvent('setDistrictEmpty');
        } elseif ($this->role_name == 'Koordinator Kelurahan/Desa') {
            $this->district_id = null;
            $this->village_id = null;
            $this->set_districts();
            $this->set_villages();
            $this->dispatchBrowserEvent('setDistrictEmpty');
            $this->dispatchBrowserEvent('setVillageEmpty');
        } else {
            $this->district_id = null;
            $this->village_id = null;
            $this->tps_id = null;
            $this->set_districts();
            $this->set_villages();
            $this->set_tpses();
            $this->dispatchBrowserEvent('setDistrictEmpty');
            $this->dispatchBrowserEvent('setVillageEmpty');
            $this->dispatchBrowserEvent('setTpsEmpty');
        }
        $this->resetValidation();
    }

    public function set_districts()
    {
        $districts = District::selectRaw("id, name as text")
            ->orderBy('name', 'asc')
            ->get()
            ->map(function ($district) {
                if ($district->id == $this->district_id)
                    return [
                        'id' => $district->id,
                        'text' => $district->text,
                        'selected' => true
                    ];

                return $district;
            });

        $this->dispatchBrowserEvent('setDistricts', ['districts' => $districts]);
    }

    public function set_villages($isEmpty = false)
    {
        $villages = Village::selectRaw("id, name as text")
            ->where('district_id', $this->district_id)
            ->orderBy('name', 'asc')
            ->get()
            ->map(function ($village) {
                if ($village->id == $this->village_id)
                    return [
                        'id' => $village->id,
                        'text' => $village->text,
                        'selected' => true
                    ];

                return $village;
            });


        $this->dispatchBrowserEvent('setVillages', ['villages' => $villages]);

        if ($isEmpty == true)
            $this->dispatchBrowserEvent('setVillageEmpty');
    }

    public function set_tpses($isEmpty = false)
    {
        $tpses = Tps::selectRaw("id, name as text")
            ->where('village_id', $this->village_id)
            ->orderBy('name', 'asc')
            ->get()
            ->map(function ($tps) {
                if ($tps->id == $this->tps_id)
                    return [
                        'id' => $tps->id,
                        'text' => $tps->text,
                        'selected' => true
                    ];

                return $tps;
            });

        $this->dispatchBrowserEvent('setTpses', ['tpses' => $tpses]);
        if ($isEmpty == true)
            $this->dispatchBrowserEvent('setTpsEmpty');
    }

    public function set_edit_user($id)
    {
        $this->reset();

        $user = User::find($id);

        $this->user_id = $user->id;
        $this->role_name = $user->role_name;
        $this->district_id = $user->district_id;
        $this->village_id = $user->village_id;
        $this->tps_id = $user->tps_id;

        if ($user->role_name == 'Koordinator Kecamatan') {
            $this->set_districts();
        } elseif ($user->role_name == 'Koordinator Kelurahan/Desa') {
            $this->set_villages();
            $this->set_districts();
        } else {
            $this->set_tpses();
            $this->set_villages();
            $this->set_districts();
        }
    }

    public function update()
    {
        if ($this->role_name != 'Administrator')
            $this->validate();

        // ddd($this->district_id, $this->village_id, $this->tps_id);
        $user = User::find($this->user_id);
        if ($this->role_name == 'Koordinator Kecamatan') {
            $user->district_id = $this->district_id;
            $user->village_id = null;
            $user->tps_id = null;
        } elseif ($this->role_name == 'Koordinator Kelurahan/Desa') {
            $user->district_id = $this->district_id;
            $user->village_id = $this->village_id;
            $user->tps_id = null;
        } else {
            $user->district_id = $this->district_id;
            $user->village_id = $this->village_id;
            $user->tps_id = $this->tps_id;
        }

        $user->save();
        DB::table('model_has_roles')
            ->where('model_uuid', $this->user_id)
            ->delete();
        $user->assignRole($this->role_name);

        History::makeHistory('Memperbaharui pengguna.', 'user.update', $user->id);

        $this->alert(
            'success',
            'Sukses!',
            ['text' => 'Pengguna berhasil diperbaharui.']
        );

        $this->reset();
        $this->emit('close_modal');
        $this->emit('refresh_users');
    }
}
