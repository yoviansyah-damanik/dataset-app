<?php

namespace App\Http\Livewire\Master\MaritalStatus;

use Livewire\Component;
use App\Models\MaritalStatus;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Edit extends Component
{
    use LivewireAlert;

    protected $listeners = ['set_edit_marital_status'];

    public $marital_status_id, $name;

    protected $rules = [
        'name' => 'required|string|max:255'
    ];

    public function validationAttributes()
    {
        return [
            'name' => 'Nama Status Perkawinan'
        ];
    }

    public function render()
    {
        return view('livewire.master.marital-status.edit');
    }

    public function set_edit_marital_status($id)
    {
        $marital_status = MaritalStatus::find($id);
        $this->marital_status_id = $marital_status->id;
        $this->name = $marital_status->name;
        $this->resetValidation();
    }

    public function update()
    {
        $this->validate();

        if (!auth()->user()->permissions->some('update marital_status'))
            return abort(403, 'Oooppssss..... Mau ngapain kamu!');

        MaritalStatus::findOrFail($this->marital_status_id)
            ->update([
                'name' => $this->name,
                'user_id' => auth()->user()->id
            ]);

        $this->emit('refresh');
        $this->dispatchBrowserEvent('closeModal');

        $this->alert(
            'success',
            'Sukses!',
            ['text' => 'Berhasil memperbaharui Status Perkawinan.']
        );
    }
}
