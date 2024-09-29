<?php

namespace Database\Seeders;

use App\Models\Nasionality;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NasionalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nasionalities = ['Indonesia'];
        foreach ($nasionalities as $nasionality) {
            Nasionality::create(
                [
                    'name' => $nasionality,
                    'user_id' => User::role('Superadmin')->first()->id
                ]
            );
        }
    }
}
