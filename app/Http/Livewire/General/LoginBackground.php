<?php

namespace App\Http\Livewire\General;

use Livewire\Component;
use App\Models\Configuration;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class LoginBackground extends Component
{
    use WithFileUploads;

    public $login_background;

    protected $rules = [
        'login_background' => 'required|image|max:1024|mimes:jpg,jpeg,png,gif,svg,bmp,webp',
    ];

    public function render()
    {
        return view('livewire.general.login-background');
    }

    public function validationAttributes()
    {
        return [
            'login_background' => 'background',
        ];
    }

    public function updated($attribute)
    {
        $this->validateOnly($attribute);
    }

    public function update()
    {
        $this->validate();

        if ($this->login_background) {
            $login_background_filename = $this->login_background->storeAs('configuration', date('ymdHis') . '_LOGIN_BACKGROUND.' . $this->login_background->getClientOriginalExtension(), 'public');

            $login_background = Configuration::where('attribute', 'app_login_background');
            Storage::delete("public/" . $login_background->first()->value);

            $login_background->update(['value' => $login_background_filename]);
        }

        $this->reset();
        Artisan::call('cache:clear');

        Alert::success('Sukses!', 'Berhasil memperbaharui login background.');
        return to_route('configuration');
    }
}
