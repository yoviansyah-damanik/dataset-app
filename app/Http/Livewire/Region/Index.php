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
            'villages.voters',
            'villages.tpses.voters',
            'villages' => function ($q) {
                $q->withCount('voters')
                    ->orderBy('name', 'asc');
            },
            'villages.tpses' => function ($q) {
                $q->withCount('voters')
                    ->orderBy('name', 'asc');
            },
        ])
            ->withCount('voters')
            ->get();

        $districts_voters_count = $districts->sum('voters_count');
        $districts_voters_total = $districts
            ->sum(fn($q) => $q->tpses->sum('voters_total'));

        return view('livewire.region.index', compact(
            'districts',
            'districts_voters_count',
            'districts_voters_total',
        ));
    }
}
