<?php

namespace App\Http\Livewire\General;

use Livewire\Component;
use App\Models\Configuration;
use App\Helpers\GeneralHelper;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use RealRashid\SweetAlert\Facades\Alert;

class Information extends Component
{
    use LivewireAlert;
    public $app_name, $app_name_abb, $unit_name;

    public function mount()
    {
        $this->app_name = GeneralHelper::get_app_name();
        $this->app_name_abb = GeneralHelper::get_abb_app_name();
        $this->unit_name = GeneralHelper::get_unit_name();
    }

    public function render()
    {
        return view('livewire.general.information');
    }

    public function rules()
    {
        return [
            'app_name' => 'required|string|max:255',
            'app_name_abb' => 'required|string|max:255',
            'unit_name' => 'required|string|max:255',
        ];
    }

    public function validationAttributes()
    {
        return [
            'app_name' => 'nama aplikasi',
            'app_name_abb' => 'singkatan',
            'unit_name' => 'nama pengguna aplikasi',
        ];
    }

    public function updated($attribute)
    {
        $this->validateOnly($attribute);
    }

    public function update()
    {
        $this->validate();
        try {
            Configuration::where('attribute', 'app_name')
                ->update(['value' => $this->app_name]);
            Configuration::where('attribute', 'app_name_abb')
                ->update(['value' => $this->app_name_abb]);
            Configuration::where('attribute', 'unit_name')
                ->update(['value' => $this->unit_name]);

            $this->alert('success', 'Berhasil memperbaharui informasi sistem.');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        } catch (\Throwable $e) {
            $this->alert('error', $e->getMessage());
        }
    }
}
