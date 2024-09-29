<?php

namespace App\Http\Livewire\Master\Profession;

use Livewire\Component;
use App\Models\Profession;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Edit extends Component
{
    use LivewireAlert;

    protected $listeners = ['set_edit_profession'];

    public $profession_id, $name;

    protected $rules = [
        'name' => 'required|string|max:255'
    ];

    public function validationAttributes()
    {
        return [
            'name' => 'Nama Pekerjaan'
        ];
    }

    public function render()
    {
        return view('livewire.master.profession.edit');
    }

    public function set_edit_profession($id)
    {
        $profession = Profession::find($id);
        $this->profession_id = $profession->id;
        $this->name = $profession->name;
        $this->resetValidation();
    }

    public function update()
    {
        $this->validate();

        if (!auth()->user()->permissions->some('update profession'))
            return abort(403, 'Oooppssss..... Mau ngapain kamu!');

        Profession::findOrFail($this->profession_id)
            ->update([
                'name' => $this->name,
                'user_id' => auth()->user()->id
            ]);

        $this->emit('refresh');
        $this->dispatchBrowserEvent('closeModal');

        $this->alert(
            'success',
            'Sukses!',
            ['text' => 'Berhasil memperbaharui Pekerjaan.']
        );
    }
}
