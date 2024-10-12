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
            'name' => 'PADANGSIDIMPUAN UTARA'
        ]);
        District::create([
            'name' => 'PADANGSIDIMPUAN TENGGARA'
        ]);
        District::create([
            'name' => 'PADANGSIDIMPUAN SELATAN'
        ]);
        District::create([
            'name' => 'PADANGSIDIMPUAN HUTAIMBARU'
        ]);
        District::create([
            'name' => 'PADANGSIDIMPUAN BATUNADUA'
        ]);
        District::create([
            'name' => 'PADANGSIDIMPUAN ANGKOLA JULU'
        ]);
    }
}
