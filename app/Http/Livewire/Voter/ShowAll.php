<?php

namespace App\Http\Livewire\Voter;

use App\Models\Tps;
use App\Models\User;
use App\Models\Village;
use Livewire\Component;
use App\Models\District;
use App\Models\Voter;
use Livewire\WithPagination;

class ShowAll extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['set_data', 'set_show_region'];

    public bool $isFilter = false;
    public $district, $village, $tps, $user;
    public $district_name, $village_name, $tps_name;
    public $search = '';
    public $attribute_search = 'name';

    public $is_show = false;

    public function render()
    {
        $voters = [];
        $voters_total = 0;
        if ($this->is_show) {
            $voters = Voter::with('village', 'district', 'tps', 'religion', 'profession', 'marital_status', 'nasionality', 'created_by', 'team_by')
                ->when($this->district?->id, fn($q) => $q->where('district_id', $this->district->id))
                ->when($this->village?->id, fn($q) => $q->where('village_id', $this->village->id))
                ->when($this->tps?->id, fn($q) => $q->where('tps_id', $this->tps->id))
                ->when($this->user?->role_name == 'Tim Bersinar', fn($q) => $q->where('team_id', $this->user->id))
                ->whereEncrypted($this->attribute_search, 'like', '%' . $this->search . '%')
                ->paginate(10, ['*'], 'showVoters');

            if ($this->district?->id && !$this->village?->id && !$this->tps?->id)
                $voters_total = $this->district->voters_total;
            elseif ($this->district?->id && $this->village?->id && !$this->tps?->id)
                $voters_total = $this->village->voters_total;
            elseif ($this->district?->id && $this->village?->id && $this->tps?->id)
                $voters_total = $this->tps->voters_total;
            else
                $voters_total = District::with('tpses')->withCount('voters')
                    ->get()
                    ->sum(fn($q) => $q->tpses->sum('voters_total'));
        }

        $this->dispatchBrowserEvent('votersLoaded');

        return view('livewire.voter.show-all', compact('voters', 'voters_total'));
    }

    public function updatingSearch()
    {
        $this->resetPage('showVoters');
    }

    public function set_data(User $user)
    {
        $this->reset(
            [
                'district',
                'district_name',
                'village',
                'village_name',
                'tps',
                'tps_name',
                'user'
            ]
        );

        $this->user = $user;

        if ($user->role_name != 'Superadmin') {
            $this->district = $user->district;
            $this->district_name = $user->district->name;

            if (in_array($user->role_name, ['Koordinator Kelurahan/Desa', 'Koordinator TPS', 'Tim Bersinar'])) {
                $this->village = $user->village;
                $this->village_name = $user->village->name;
            }

            if (in_array($user->role_name, ['Koordinator TPS', 'Tim Bersinar'])) {
                $this->tps = $user->tps;
                $this->tps_name = $user->tps->name;
            }
        }

        $this->resetPage('showVoters');
        $this->is_show = true;
    }

    public function set_show_region(District $district, ?Village $village = null, ?Tps $tps = null)
    {
        $this->district = $district;
        $this->district_name = $district->name;

        if ($village) {
            $this->village = $village;
            $this->village_name = $village->name;
        }

        if ($tps) {
            $this->tps = $tps;
            $this->tps_name = $tps->name;
        }

        $this->resetPage('showVoters');
        $this->is_show = true;
    }
}
