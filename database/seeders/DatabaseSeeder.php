<?php

namespace Database\Seeders;

use App\Models\Voter;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            [
                RolesAndPermissionsSeeder::class,
                DistrictsSeeder::class,
                VillagesSeeder::class,
                TpsSeeder::class,
                UserSeeder::class,
                ConfigurationSeeder::class,
                NasionalitySeeder::class,
                MaritalStatusSeeder::class,
                ProfessionSeeder::class,
                ReligionSeeder::class,
                // VoterSeeder::class,
            ]
        );
    }
}
