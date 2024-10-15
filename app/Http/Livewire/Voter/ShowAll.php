<?php

namespace App\Http\Livewire\Voter;

use App\Models\Dpt;
use App\Models\Tps;
use App\Models\User;
use App\Models\Voter;
use App\Models\Village;
use Livewire\Component;
use App\Models\District;
use Livewire\WithPagination;

class ShowAll extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['set_data', 'set_show_region'];

    public bool $isFilter = false;
    public $district, $village, $tps, $user, $family;
    public $district_name, $village_name, $tps_name;
    public $search = '';
    public $attribute_search = 'name';
    public $dpts_count = 0;

    public $is_show = false;

    public function render()
    {
        $voters = [];
        if ($this->is_show) {
            $voters = Voter::with('village', 'district', 'tps', 'religion', 'profession', 'marital_status', 'nasionality', 'created_by', 'team_by', 'family_coor')
                ->when(
                    $this->family,
                    function ($q) {
                        if ($this->family->role_name == 'Koordinator Keluarga')
                            $q->where('family_coor_id', $this->family->id);
                        else
                            $q->whereNull('district_id');
                    },
                    fn($q) => $q
                        ->when($this->district?->id, fn($r) => $r->where('district_id', $this->district->id))
                        ->when($this->village?->id, fn($r) => $r->where('village_id', $this->village->id))
                        ->when($this->tps?->id, fn($r) => $r->where('tps_id', $this->tps->id))
                        ->when($this->user?->role_name == 'Tim Bersinar', fn($r) => $r->where('team_id', $this->user->id))
                )

                ->whereEncrypted($this->attribute_search, 'like', '%' . $this->search . '%')
                ->paginate(10, ['*'], 'showVoters');

            if ($this->district?->id && !$this->village?->id && !$this->tps?->id)
                $this->dpts_count = $this->district->dpts_count;
            elseif ($this->district?->id && $this->village?->id && !$this->tps?->id)
                $this->dpts_count = $this->village->dpts_count;
            elseif ($this->district?->id && $this->village?->id && $this->tps?->id)
                $this->dpts_count = $this->tps->dpts_count;
            else
                $this->dpts_count = Dpt::count();
        }

        $this->dispatchBrowserEvent('votersLoaded');

        return view('livewire.voter.show-all', compact('voters'));
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
                'user',
                'dpts_count',
                'family'
            ]
        );

        $this->user = $user;

        if ($user->role_name != 'Superadmin') {
            if (in_array($user->role_name, ['Koordinator Keluarga', 'Administrator Keluarga'])) {
                $this->family = $user;
            } else {
                $this->district = $user->district->loadCount('dpts');
                $this->district_name = $user->district->name;

                if (in_array($user->role_name, ['Koordinator Kelurahan/Desa', 'Koordinator TPS', 'Tim Bersinar'])) {
                    $this->village = $user->village->loadCount('dpts');
                    $this->village_name = $user->village->name;
                }

                if (in_array($user->role_name, ['Koordinator TPS', 'Tim Bersinar'])) {
                    $this->tps = $user->tps->loadCount('dpts');
                    $this->tps_name = $user->tps->name;
                }
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
