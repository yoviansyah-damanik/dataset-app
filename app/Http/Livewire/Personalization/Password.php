<?php

namespace App\Http\Livewire\Personalization;

use App\Models\User;
use App\Models\History;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Password extends Component
{
    use LivewireAlert;

    public $old_password, $new_password, $confirm_new_password;

    public function render()
    {
        return view('livewire.personalization.password');
    }

    public function rules()
    {
        return [
            'old_password' => 'required|current_password',
            'new_password' => 'required|min:8|different:old_password',
            'confirm_new_password' => 'required|min:8|same:new_password',
        ];
    }

    public function validationAttributes()
    {
        return [
            'old_password' => 'kata sandi lama',
            'new_password' => 'kata sandi baru',
            'confirm_new_password' => 'konfirmasi kata sandi baru',
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
        $user->password = Hash::make($this->new_password);
        $user->save();

        History::makeHistory('Memperbaharui kata sandi.', 'personalization.update');

        $this->alert(
            'success',
            'Sukses!',
            [
                'text' => 'Berhasil memperbarui kata sandi.'
            ]
        );

        $this->reset();
    }
}
