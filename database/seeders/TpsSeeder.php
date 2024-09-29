<?php

namespace Database\Seeders;

use App\Models\Tps;
use App\Models\Village;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TpsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Village::all() as $village) {
            foreach (range(1, rand(2, 5)) as $x) {
                Tps::create(
                    [
                        'village_id' => $village->id,
                        'name' => 'TPS ' . $x,
                        'voters_total' => rand(50, 100)
                    ]
                );
            }
        }
    }
}
