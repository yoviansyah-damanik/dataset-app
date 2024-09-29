<?php

namespace App\Http\Livewire\Users;

use Exception;
use App\Models\User;
use App\Models\History;
use Livewire\Component;
use App\Models\Voter;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithPagination, LivewireAlert;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refresh_users', 'close_modal'];

    public $is_active = true;
    public $user_role, $s, $role;

    public function mount($s)
    {
        $this->role = 'all';
        $this->s = $s;
    }

    public function render()
    {
        $users = User::with('roles', 'district', 'village', 'tps', 'voters')
            ->withCount('voters')
            ->where(function ($q) {
                $q->whereEncrypted('fullname', 'like', "%$this->s%")
                    ->orWhereEncrypted('username', 'like', "%$this->s%");
            })
            ->where('is_active', $this->is_active)
            ->when($this->role != 'all', fn($q) => $q->role($this->role))
            ->orderBy('district_id', 'asc')
            ->orderBy('village_id', 'asc')
            ->orderBy('tps_id', 'asc')
            ->paginate(10);

        $roles = Role::all();
        return view('livewire.users.index', compact('users', 'roles'));
    }

    public function refresh_users()
    {
        $this->s = '';
        $this->role = 'all';
    }

    public function set_trashed()
    {
        $this->is_active = !$this->is_active;
    }

    public function nonactive($id)
    {
        $user = User::find($id);
        $user->is_active = 0;
        $user->save();

        History::makeHistory('Mengnonaktifkan pengguna.', 'user.nonactive', $id);

        $this->alert(
            'success',
            'Sukses!',
            ['text' => 'Berhasil mengnonaktifkan akun!']
        );
    }

    public function active($id)
    {
        $user = User::find($id);
        $user->is_active = 1;
        $user->save();

        History::makeHistory('Mengaktifkan pengguna.', 'user.active', $id);

        $this->alert(
            'success',
            'Sukses!',
            ['text' => 'Berhasil mengaktifkan akun!']
        );
    }

    public function set_admin($id)
    {
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user = User::find($id);
        $user->assignRole('Administrator');
        $user->update(
            [
                'district_id' => null,
                'village_id' => null,
                'tps_id' => null,
            ]
        );

        $this->alert('success', 'Berhasil memperbaharui akun!');
    }

    public function set_surveyor($id)
    {
        if ($this->user_role == 'Koordinator Kecamatan') {
            if (!$this->district_id)
                return $this->alert(
                    'warning',
                    'Perhatian!',
                    ['text' => 'Silahkan pilih Kecamatan terlebih dahulu.']
                );

            $update =
                [
                    'district_id' => (int)$this->district_id
                ];
        } elseif ($this->user_role == 'Koordinator Kelurahan/Desa') {
            $update =
                [
                    'district_id' => (int)$this->district_id,
                    'village_id' => (int)$this->village_id
                ];
        } else {
            $update =
                [
                    'district_id' => (int)$this->district_id,
                    'village_id' => (int)$this->village_id,
                    'tps_id' => (int)$this->tps_id
                ];
        }

        $roles = Role::get()->pluck('name')->toArray();

        // ddd($id, $this->district_id, $this->village_id, $this->tps_id, $this->user_role, $roles);
        if (!in_array($this->user_role, $roles))
            return $this->alert(
                'warning',
                'Perhatian!',
                ['text' => 'Role yang anda pilih tidak tersedia.']
            );

        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user = User::find($id);
        $user->update($update);
        $user->assignRole($this->user_role);

        $this->reset('district_id', 'village_id', 'tps_id', 'user_role');
        $this->alert(
            'success',
            'Sukses!',
            ['text' => 'Berhasil memperbaharui akun pengguna!']
        );
    }

    public function close_modal()
    {
        $this->dispatchBrowserEvent('closeModal');
    }

    public function delete_user($id)
    {
        $voters = Voter::where('user_id', $id)
            ->count();

        if ($voters > 0) {
            return $this->alert(
                'warning',
                'Perhatian!',
                ['text' => 'Tidak dapat menghapus pengguna. Pengguna memiliki beberapa data pemilih.']
            );
        } else {
            DB::beginTransaction();
            try {
                DB::transaction(function () use ($id) {
                    User::find($id)
                        ->delete();
                    History::where('user_id', $id)
                        ->delete();
                });

                DB::commit();
                return $this->alert(
                    'success',
                    'Sukses!',
                    ['text' => 'Berhasil menghapus pengguna.']
                );
            } catch (Exception $e) {
                DB::rollback();

                return $this->alert(
                    'warning',
                    'Perhatian!',
                    ['text' => $e->getMessage()]
                );
            }
        }
    }
}
