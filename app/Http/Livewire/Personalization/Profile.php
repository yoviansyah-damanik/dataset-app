<?php

namespace App\Http\Livewire\Personalization;

use App\Models\User;
use App\Models\History;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Profile extends Component
{
    use LivewireAlert;

    public $username, $fullname, $email;

    public function mount()
    {
        $this->username = Auth::user()->username;
        $this->fullname = Auth::user()->fullname;
        $this->email = Auth::user()->email;
    }

    public function render()
    {
        return view('livewire.personalization.profile');
    }

    public function rules()
    {
        return [
            'username' => 'required|max:16|unique:users,username,' . Auth::id(),
            'fullname' => 'required|max:30',
            'email' => 'required|unique:users,email,' . Auth::id(),
        ];
    }

    public function validationAttributes()
    {
        return [
            'username' => 'nama pengguna',
            'fullname' => 'nama lengkap',
        ];
    }

    public function updated($attribute)
    {
        $this->validateOnly($attribute);
    }

    public function update()
    {
        $this->validate();

        $user = User::find(Auth::id());
        $user->username = $this->username;
        $user->fullname = $this->fullname;
        $user->email = $this->email;
        $user->save();

        History::makeHistory('Memperbaharui profil.', 'personalization.update');

        $this->alert(
            'success',
            'Sukses!',
            [
                'text' => 'Berhasil memperbarui profil.'
            ]
        );
    }
}
