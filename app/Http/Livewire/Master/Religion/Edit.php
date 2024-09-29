<?php

namespace App\Http\Livewire\Master\Religion;

use Livewire\Component;
use App\Models\Religion;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Edit extends Component
{
    use LivewireAlert;

    protected $listeners = ['set_edit_religion'];

    public $religion_id, $name;

    protected $rules = [
        'name' => 'required|string|max:255'
    ];

    public function validationAttributes()
    {
        return [
            'name' => 'Nama Agama'
        ];
    }

    public function render()
    {
        return view('livewire.master.religion.edit');
    }

    public function set_edit_religion($id)
    {
        $religion = Religion::find($id);
        $this->religion_id = $religion->id;
        $this->name = $religion->name;
        $this->resetValidation();
    }

    public function update()
    {
        $this->validate();

        if (!auth()->user()->permissions->some('create religion'))
            return abort(403, 'Oooppssss..... Mau ngapain kamu!');

        Religion::findOrFail($this->religion_id)
            ->update([
                'name' => $this->name,
                'user_id' => auth()->user()->id
            ]);

        $this->emit('refresh');
        $this->dispatchBrowserEvent('closeModal');

        $this->alert(
            'success',
            'Sukses!',
            ['text' => 'Berhasil memperbaharui Agama.']
        );
    }
}
