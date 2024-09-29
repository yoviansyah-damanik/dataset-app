<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profession;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $professions = ['ASN', 'Petani', 'TNI/Polri', 'Wiraswasta', 'Tidak Bekerja', 'Guru/Dosen'];
        foreach ($professions as $profession) {
            Profession::create([
                'name' => $profession,
                'user_id' => User::role('Superadmin')->first()->id
            ]);
        }
    }
}
