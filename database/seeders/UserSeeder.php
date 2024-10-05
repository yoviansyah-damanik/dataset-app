<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\District;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'superadmin',
            'fullname' => 'Superadmin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('password')
        ])->assignRole('Superadmin');

        \App\Models\User::create([
            'username' => 'admin_psp_utara',
            'fullname' => 'Admin Utara',
            'email' => 'admin_utara@gmail.com',
            'password' => Hash::make('password'),
            'district_id' => District::where('name', 'Padangsidimpuan Utara')->first()->id
        ])->assignRole('Administrator');


        \App\Models\User::create([
            'username' => 'koordinator_kecamatan_utara',
            'fullname' => 'Koordinator Utara',
            'email' => 'koor_utara@gmail.com',
            'password' => Hash::make('password'),
            'district_id' => District::where('name', 'Padangsidimpuan Utara')->first()->id
        ])->assignRole('Koordinator Kecamatan');

        \App\Models\User::create([
            'username' => 'admin_psp_selatan',
            'fullname' => 'Admin Selatan',
            'email' => 'admin_selatan@gmail.com',
            'password' => Hash::make('password'),
            'district_id' => District::where('name', 'Padangsidimpuan Selatan')->first()->id
        ])->assignRole('Administrator');

        \App\Models\User::create([
            'username' => 'admin_psp_tenggara',
            'fullname' => 'Admin Tenggara',
            'email' => 'admin_tenggara@gmail.com',
            'password' => Hash::make('password'),
            'district_id' => District::where('name', 'Padangsidimpuan Tenggara')->first()->id
        ])->assignRole('Administrator');

        \App\Models\User::create([
            'username' => 'admin_psp_hutaimbaru',
            'fullname' => 'Admin Hutaimbaru',
            'email' => 'admin_hutaimbaru@gmail.com',
            'password' => Hash::make('password'),
            'district_id' => District::where('name', 'Padangsidimpuan Hutaimbaru')->first()->id
        ])->assignRole('Administrator');

        \App\Models\User::create([
            'username' => 'admin_psp_batunadua',
            'fullname' => 'Admin Batunadua',
            'email' => 'admin_batunadua@gmail.com',
            'password' => Hash::make('password'),
            'district_id' => District::where('name', 'Padangsidimpuan Batunadua')->first()->id
        ])->assignRole('Administrator');

        \App\Models\User::create([
            'username' => 'admin_psp_angkola_judul',
            'fullname' => 'Admin Angkola Judul',
            'email' => 'admin_angkola_judul@gmail.com',
            'password' => Hash::make('password'),
            'district_id' => District::where('name', 'Padangsidimpuan Angkola Julu')->first()->id
        ])->assignRole('Administrator');

        \App\Models\User::create([
            'username' => 'admin_keluarga',
            'fullname' => 'Admin Keluarga',
            'email' => 'admin_keluarga@gmail.com',
            'password' => Hash::make('password'),
        ])->assignRole('Administrator Keluarga');

        // User::factory()
        //     ->count(15)
        //     ->create()
        //     ->each(function ($user) {
        //         $district_id = District::inRandomOrder()->first();

        //         $user->district_id = $district_id->id;
        //         $user->save();

        //         $user->assignRole('Koordinator Kecamatan');
        //     });

        // User::factory()
        //     ->count(40)
        //     ->create()
        //     ->each(function ($user) {
        //         $district_id = District::inRandomOrder()->first();
        //         $village_id = $district_id->villages->random();

        //         $user->district_id = $district_id->id;
        //         $user->village_id = $village_id->id;
        //         $user->save();

        //         $user->assignRole('Koordinator Kelurahan/Desa');
        //     });

        // User::factory()
        //     ->count(100)
        //     ->create()
        //     ->each(function ($user) {
        //         $district_id = District::inRandomOrder()->first();
        //         $village_id = $district_id->villages->random();
        //         $tps_id = $village_id->tpses->random();

        //         $user->district_id = $district_id->id;
        //         $user->village_id = $village_id->id;
        //         $user->tps_id = $tps_id->id;
        //         $user->save();

        //         $user->assignRole('Koordinator TPS');
        //     });

        foreach (District::all() as $district) {
            User::factory()
                ->count(1)
                ->create()
                ->each(function ($user) use ($district) {
                    $user->district_id = $district->id;
                    $user->save();
                    $user->assignRole('Koordinator Kecamatan');
                });

            foreach ($district->villages as $village) {
                User::factory()
                    ->count(1)
                    ->create()
                    ->each(function ($user) use ($district, $village) {
                        $user->district_id = $district->id;
                        $user->village_id = $village->id;
                        $user->save();
                        $user->assignRole('Koordinator Kelurahan/Desa');
                    });

                foreach ($village->tpses as $tps) {
                    User::factory()
                        ->count(1)
                        ->create()
                        ->each(function ($user) use ($district, $village, $tps) {
                            $user->district_id = $district->id;
                            $user->village_id = $village->id;
                            $user->tps_id = $tps->id;
                            $user->save();
                            $user->assignRole('Koordinator TPS');
                        });
                }
            }
        }

        User::factory()
            ->count(10)
            ->create()
            ->each(function ($user) {
                $district_id = District::inRandomOrder()->first();
                $village_id = $district_id->villages->random();
                $tps_id = $village_id->tpses->random();

                $user->district_id = $district_id->id;
                $user->village_id = $village_id->id;
                $user->tps_id = $tps_id->id;
                $user->save();

                $user->assignRole('Tim Bersinar');
            });

        foreach (District::get() as $district) {
            foreach ($district->villages as $village) {
                foreach ($village->tpses as $tps) {
                    User::factory()
                        ->count(rand(1, 3))
                        ->create()
                        ->each(function ($user) use ($district, $village, $tps) {
                            $user->username = "tp_" . Str::of($tps->name)->lower()->replace(' ', '_') . '_' . Str::random(8);
                            $user->email = "tp_" . Str::of($tps->name)->lower()->replace(' ', '_') . '_' . Str::random(8) . '@gmail.com';
                            $user->district_id = $district->id;
                            $user->village_id = $village->id;
                            $user->tps_id = $tps->id;
                            $user->save();

                            $user->assignRole('Tim Bersinar');
                        });
                }
            }
        }
    }
}
