<?php

namespace App\Http\Livewire\General;

use Livewire\Component;
use App\Models\Configuration;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use RealRashid\SweetAlert\Facades\Alert;

class Logo extends Component
{
    use LivewireAlert, WithFileUploads;
    public $logo, $favicon, $ads;

    protected $rules = [
        'logo' => 'nullable|image|max:1024|mimes:jpg,jpeg,png,gif,svg,bmp',
        'favicon' => 'nullable|image|max:1024|mimes:jpg,jpeg,png,gif,svg,bmp',
        'ads' => 'nullable|image|max:1024|mimes:jpg,jpeg,png,gif,svg,bmp',
    ];

    public function render()
    {
        return view('livewire.general.logo');
    }

    public function validationAttributes()
    {
        return [
            'logo' => 'logo utama',
            'ads' => 'gambar iklan'
        ];
    }

    public function updated($attribute)
    {
        $this->validateOnly($attribute);
    }

    public function update()
    {
        $this->validate();

        if ($this->logo) {
            $logo_filename = $this->logo->storeAs('configuration', date('ymdHis') . '_LOGO.' . $this->logo->getClientOriginalExtension(), 'public');

            $logo = Configuration::where('attribute', 'app_logo');
            Storage::delete("public/" . $logo->first()->value);

            $logo->update(['value' => $logo_filename]);
        }

        if ($this->favicon) {
            $favicon_filename = $this->favicon->storeAs('configuration', date('ymdHis') . '_FAVICON.' . $this->favicon->getClientOriginalExtension(), 'public');

            $favicon = Configuration::where('attribute', 'app_favicon');
            Storage::delete("public/" . $favicon->first()->value);

            $favicon->update(['value' => $favicon_filename]);
        }

        if ($this->ads) {
            $ads_filename = $this->ads->storeAs('configuration', date('ymdHis') . '_ADS.' . $this->ads->getClientOriginalExtension(), 'public');

            $ads = Configuration::where('attribute', 'app_ads');
            Storage::delete("public/" . $ads->first()->value);

            $ads->update(['value' => $ads_filename]);
        }

        $this->reset();
        Artisan::call('cache:clear');

        $this->alert('success', 'Berhasil memperbaharui logo, favicon, dan ads.');
    }
}
