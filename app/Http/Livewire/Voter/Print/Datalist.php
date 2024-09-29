<?php

namespace App\Http\Livewire\Voter\Print;

use Livewire\Component;
use App\Models\PrintHistory;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Datalist extends Component
{
    use WithPagination, LivewireAlert;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refresh_print_history' => '$refresh'];

    public function render()
    {
        $histories = PrintHistory::with('user', 'district')->latest()
            ->paginate(10);

        return view('livewire.voter.print.datalist', compact('histories'));
    }

    public function download($unique_number)
    {
        $history = PrintHistory::whereEncrypted('unique_code', $unique_number)
            ->first();

        if ($history)
            return Storage::download('public' . '/' . $history->path, $history->filename);

        $this->alert('error', 'Tidak ada laporan ditemukan.');
        return;
    }

    public function destroy($unique_number)
    {
        $history = PrintHistory::whereEncrypted('unique_code', $unique_number)
            ->first();

        if ($history) {
            $history->delete();
            Storage::delete('public/' . $history->path);

            $this->alert('success', 'Berhasil menghapus riwayat cetak laporan.');
            return;
        }

        $this->alert('error', 'Tidak ada laporan ditemukan.');
        return;
    }
}
