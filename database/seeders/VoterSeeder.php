<?php

namespace Database\Seeders;

use App\Models\Voter;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VoterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Voter::factory(1000)
            ->create();
    }
}
