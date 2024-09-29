<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\MaritalStatus;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MaritalStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $marital_statuses = ['Kawin', 'Belum Kawin', 'Cerai Hidup', 'Cerai Mati'];
        foreach ($marital_statuses as $marital_status) {
            MaritalStatus::create(
                [
                    'name' => $marital_status,
                    'user_id' => User::role('Superadmin')->first()->id
                ]
            );
        }
    }
}
