<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistrictsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        District::create([
            'name' => 'Padangsidimpuan Utara'
        ]);
        District::create([
            'name' => 'Padangsidimpuan Tenggara'
        ]);
        District::create([
            'name' => 'Padangsidimpuan Selatan'
        ]);
        District::create([
            'name' => 'Padangsidimpuan Hutaimbaru'
        ]);
        District::create([
            'name' => 'Padangsidimpuan Batunadua'
        ]);
        District::create([
            'name' => 'Padangsidimpuan Angkola Julu'
        ]);
    }
}
