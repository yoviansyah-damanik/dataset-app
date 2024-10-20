<?php

namespace App\Http\Livewire\Voter;

use Carbon\Carbon;
use App\Models\Tps;
use App\Models\Voter;
use App\Models\History;
use App\Models\Village;
use Livewire\Component;
use App\Models\District;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithPagination;
    use LivewireAlert;

    protected $paginationTheme = 'bootstrap';

    public $per_page = 10;
    public $search = '';
    public $attribute_search = 'name';
    public $filter;
    public $sortBy;
    public $year = 'semua';
    public $view = 'user';
    public $district, $village, $tps;

    public function mount()
    {
        $this->view = auth()->user()->role_name == 'Superadmin' ? 'admin' : 'user';

        if (auth()->user()->role_name != 'Superadmin') {
            $this->district = auth()->user()->district_id;

            if (!in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan'])) {
                $this->village = auth()->user()->village_id;
            }

            if (!in_array(auth()->user()->role_name, ['Administrator', 'Koordinator Kecamatan', 'Koordinator Kelurahan/Desa'])) {
                $this->tps = auth()->user()->tps_id;
            }
        }
    }

    public function render()
    {
        $voters = Voter::with('village', 'district', 'tps', 'religion', 'profession', 'marital_status', 'nasionality', 'created_by', 'team_by')
            ->whereEncrypted($this->attribute_search, 'like', "%$this->search%")
            ->when($this->filter == 'gender-1', function ($q) {
                $q->where('gender', 'Laki-laki');
            })
            ->when($this->filter == 'gender-2', function ($q) {
                $q->where('gender', 'Perempuan');
            })
            ->when($this->filter == 'age-1', function ($q) {
                $start = 17;
                $end = 25;
                $q->where('age', '>=', $start)
                    ->where('age', '<=', $end);
            })
            ->when($this->filter == 'age-2', function ($q) {
                $start = 25;
                $end = 35;
                $q->where('age', '>=', $start)
                    ->where('age', '<=', $end);
            })
            ->when($this->filter == 'age-3', function ($q) {
                $start = 35;
                $end = 45;
                $q->where('age', '>=', $start)
                    ->where('age', '<=', $end);
            })
            ->when($this->filter == 'age-4', function ($q) {
                $start = 45;
                $end = 55;
                $q->where('age', '>=', $start)
                    ->where('age', '<=', $end);
            })
            ->when($this->filter == 'age-5', function ($q) {
                $end = 55;
                $q->where('age', '<=', $end);
            })
            ->when($this->filter == 'file-1', function ($q) {
                $q->whereNotNull('ktp');
            })
            ->when($this->filter == 'file-2', function ($q) {
                $q->whereNotNull('kk');
            })
            ->when($this->filter == 'file-3', function ($q) {
                $q->whereNotNull('kk')
                    ->whereNotNull('ktp');
            })
            ->when($this->filter == 'file-4', function ($q) {
                $q->whereNull('ktp');
            })
            ->when($this->filter == 'file-5', function ($q) {
                $q->whereNull('kk');
            })
            ->when($this->filter == 'file-6', function ($q) {
                $q->whereNull('kk')
                    ->whereNull('ktp');
            })
            ->when($this->sortBy == 'sortBy-1', fn($q) => $q->orderBy('age', 'desc'))
            ->when($this->sortBy == 'sortBy-2', fn($q) => $q->orderBy('age', 'asc'))
            ->when($this->sortBy == 'sortBy-3', fn($q) => $q->orderBy('name', 'asc'))
            ->when($this->sortBy == 'sortBy-4', fn($q) => $q->orderBy('name', 'desc'))
            ->when($this->sortBy == 'sortBy-5', fn($q) => $q->orderBy('created_at', 'desc'))
            ->when($this->sortBy == 'sortBy-6', fn($q) => $q->orderBy('created_at', 'asc'))
            // ->when($this->view === 'user', fn($q) => $q->where('user_id', Auth::user()->id))
            // ->when($this->year !== 'semua', fn($q) => $q->where('year', $this->year))
            ->when($this->district, fn($q) => $q->where('district_id', $this->district))
            ->when($this->village, fn($q) => $q->where('village_id', $this->village))
            ->when($this->tps, fn($q) => $q->where('tps_id', $this->tps))
            ->when(
                in_array(auth()->user()->role_name, ['Administrator Keluarga', 'Koordinator Keluarga']),
                fn($q) => $q->when(
                    auth()->user()->role_name == 'Administrator Keluarga',
                    fn($r) => $r->whereNotNull('family_coor_id'),
                    fn($r) => $r->where('family_coor_id', auth()->user()->id)
                )
            )
            ->paginate($this->per_page);

        if (!$voters)
            $this->alert('warning', 'Tidak ada data ditemukan.');

        $districts = District::all();

        $villages = Village::where('district_id', $this->district)
            ->get();

        $tpses = Tps::whereHas('village', fn($q) => $q->where('id', $this->village)
            ->where('district_id', $this->district))->get();

        $this->dispatchBrowserEvent('votersLoaded');

        return view('livewire.voter.index', [
            'voters' => $voters,
            'districts' => $districts,
            'villages' => $villages,
            'tpses' => $tpses,
        ]);
    }

    public function updated($attribute)
    {
        if ($attribute == 'district') {
            $this->village = null;
            $this->tps = null;
        }

        if ($attribute == 'village') {
            $this->tps = null;
        }

        $this->resetPage();
    }

    public function destroy($id)
    {
        try {
            if (!auth()->user()->permissions->some('delete voter'))
                return abort(403, 'Oooppssss..... Mau ngapain kamu!');

            $voter = Voter::find($id);
            $ktp = $voter->ktp;
            if ($ktp)
                Storage::delete($ktp);

            $kk = $voter->kk;
            if ($kk)
                Storage::delete($kk);

            $voter->delete();

            History::makeHistory('Menghapus Pemilih dengan ID: ' . $voter->id, $voter, 'delete', ref_id: $voter->id);

            $this->alert('success', 'Berhasil hapus data pemilih.');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }
}
