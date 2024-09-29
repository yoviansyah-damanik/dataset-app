<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Religion;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReligionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $religions = ['Islam', 'Kristen', 'Katolik', 'Buddha', 'Hindu', 'Konghucu'];
        foreach ($religions as $religion) {
            Religion::create([
                'name' => $religion,
                'user_id' => User::role('Superadmin')->first()->id
            ]);
        }
    }
}
