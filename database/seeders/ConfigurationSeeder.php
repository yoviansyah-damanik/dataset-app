<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Configuration::create(
            [
                'attribute' => 'app_name',
                'value' => 'Berkarakter Bersih Aman dan Sejahtera'
            ]
        );

        Configuration::create(
            [
                'attribute' => 'abb_app_name',
                'value' => 'BERSINAR'
            ]
        );

        Configuration::create(
            [
                'attribute' => 'unit_name',
                'value' => 'Tim Kemenangan Irsan-Ali'
            ]
        );

        Configuration::create(
            [
                'attribute' => 'app_logo',
                'value' => null
            ]
        );

        Configuration::create(
            [
                'attribute' => 'app_favicon',
                'value' => null
            ]
        );

        Configuration::create(
            [
                'attribute' => 'app_ads',
                'value' => null
            ]
        );

        Configuration::create(
            [
                'attribute' => 'app_login_background',
                'value' => null
            ]
        );

        Configuration::create(
            [
                'attribute' => 'version',
                'value' => '1.0.0'
            ]
        );

        Configuration::create(
            [
                'attribute' => 'candidate_callsign',
                'value' => 'Wali Kota'
            ]
        );

        Configuration::create(
            [
                'attribute' => 'candidate_1_name',
                'value' => null
            ]
        );

        Configuration::create(
            [
                'attribute' => 'candidate_1_picture',
                'value' => null
            ]
        );

        Configuration::create(
            [
                'attribute' => 'candidate_2_name',
                'value' => null
            ]
        );

        Configuration::create(
            [
                'attribute' => 'candidate_2_picture',
                'value' => null
            ]
        );
    }
}
