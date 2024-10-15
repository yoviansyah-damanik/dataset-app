<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Admin extends Component
{
    use WithPagination, LivewireAlert;

    protected $paginationTheme = 'bootstrap';

    public $users;

    public function mount()
    {
        $this->show_admins();
    }

    public function render()
    {
        return view('livewire.users.admin');
    }

    public function show_admins()
    {
        $this->users =  User::with('district')
            ->role(['Administrator', 'Administrator Keluarga'])
            ->get()
            ->map(function ($user) {
                return [
                    ...$user->toArray(),
                    'district_name' => $user?->district?->name ?? '-'
                ];
            })->toArray();
    }

    public function refresh_admin_password()
    {
        $this->users =  User::with('district')
            ->role(['Administrator', 'Administrator Keluarga'])
            ->get()
            ->map(function ($user) {
                $new_password = Str::random(12);
                $user->update(['password' => bcrypt($new_password)]);
                return [
                    ...$user->toArray(),
                    'district_name' => $user?->district?->name ?? '-',
                    'new_password' => $new_password
                ];
            })->toArray();

        $this->alert('success', 'Kata sandi seluruh Administrator berhasil diubah.');
    }
}
