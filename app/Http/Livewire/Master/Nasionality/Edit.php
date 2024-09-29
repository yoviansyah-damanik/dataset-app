<?php

namespace App\Http\Livewire\Master\Nasionality;

use Livewire\Component;
use App\Models\Nasionality;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Edit extends Component
{
    use LivewireAlert;

    protected $listeners = ['set_edit_nasionality'];

    public $nasionality_id, $name;

    protected $rules = [
        'name' => 'required|string|max:255'
    ];

    public function validationAttributes()
    {
        return [
            'name' => 'Nama Kewarganegaraan'
        ];
    }

    public function render()
    {
        return view('livewire.master.nasionality.edit');
    }

    public function set_edit_nasionality($id)
    {
        $nasionality = Nasionality::find($id);
        $this->nasionality_id = $nasionality->id;
        $this->name = $nasionality->name;
        $this->resetValidation();
    }

    public function update()
    {
        $this->validate();

        if (!auth()->user()->permissions->some('update nasionality'))
            return abort(403, 'Oooppssss..... Mau ngapain kamu!');

        Nasionality::findOrFail($this->nasionality_id)
            ->update([
                'name' => $this->name,
                'user_id' => auth()->user()->id
            ]);

        $this->emit('refresh');
        $this->dispatchBrowserEvent('closeModal');

        $this->alert(
            'success',
            'Sukses!',
            ['text' => 'Berhasil memperbaharui Kewarganegaraan.']
        );
    }
}
