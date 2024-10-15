<?php

namespace App\Http\Livewire\Region;

use Livewire\Component;
use App\Models\District;

class Index extends Component
{
    protected $listeners = ['refresh_regions' => '$refresh'];

    public function render()
    {
        $districts = District::with([
            'voters',
            'villages' => function ($q) {
                $q->withCount(['dpts', 'voters']);
            },
            'villages.tpses' => function ($q) {
                $q->withCount(['dpts', 'voters']);
            },
        ])
            ->withCount('voters', 'dpts')
            ->get();

        $districts_voters_count = $districts
            ->sum('voters_count');

        $districts_voters_total = $districts
            ->sum('dpts_count');

        return view('livewire.region.index', compact(
            'districts',
            'districts_voters_count',
            'districts_voters_total',
        ));
    }
}
