<?php

namespace App\Http\Livewire\Voter;

use App\Models\User;
use App\Models\Voter;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Transfer extends Component
{
    use LivewireAlert;

    public $pemilih;
    public $old_team;
    public $search;
    public $team_search;
    public $selected_voter;
    public $selected_team;

    public $step = 1;

    public function render()
    {
        $data = '';
        if ($this->step == 1)
            $data = Voter::with('district', 'village', 'tps')
                ->whereEncrypted('name', 'like', "$this->search%")
                ->orWhereEncrypted('nik', 'like', "$this->search%")
                ->whereNull('family_coor_id')
                ->limit(10)
                ->get();

        if ($this->step == 3)
            $data = User::with('voters_by_team', 'district', 'village', 'tps', 'roles')
                ->withCount('voters_by_team')
                ->whereEncrypted('fullname', 'like', "$this->team_search%")
                ->where('id', '!=', $this->old_team->id)
                ->role('Tim Bersinar')
                ->limit(10)
                ->get();

        return view('livewire.voter.transfer', compact('data'));
    }

    public function set_voter(Voter $voter)
    {
        $this->selected_voter = $voter;
        $this->old_team = $voter->team_by;
        $this->increment();
        $this->reset('search', 'team_search');
    }

    public function set_team(User $user)
    {
        $this->selected_team = $user;
        $this->reset('team_search');
        $this->increment();
    }

    public function save()
    {
        try {
            Voter::findOrFail($this->selected_voter->id)
                ->update([
                    'team_id' => $this->selected_team->id,
                    'district_id' => $this->selected_team->district_id,
                    'village_id' => $this->selected_team->village_id,
                    'tps_id' => $this->selected_team->tps_id,
                ]);

            $this->alert('success', 'Berhasil melakukan transfer.');
            $this->step = 1;
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        } catch (\Throwable $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function increment()
    {
        if ($this->step + 1 > 0)
            $this->step++;
    }

    public function decrement()
    {
        if ($this->step + 1 > 0)
            $this->step--;
    }
}
