<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Village;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VillagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $villages = [
            ['district_name' => 'PADANGSIDIMPUAN ANGKOLA JULU', 'village_name' => 'BATU LAYAN'],
            ['district_name' => 'PADANGSIDIMPUAN ANGKOLA JULU', 'village_name' => 'JORING LOMBANG'],
            ['district_name' => 'PADANGSIDIMPUAN ANGKOLA JULU', 'village_name' => 'JORING NATOBANG'],
            ['district_name' => 'PADANGSIDIMPUAN ANGKOLA JULU', 'village_name' => 'MOMPANG'],
            ['district_name' => 'PADANGSIDIMPUAN ANGKOLA JULU', 'village_name' => 'PINTU LANGIT JAE'],
            ['district_name' => 'PADANGSIDIMPUAN ANGKOLA JULU', 'village_name' => 'RIMBA SOPING'],
            ['district_name' => 'PADANGSIDIMPUAN ANGKOLA JULU', 'village_name' => 'SIMASOM'],
            ['district_name' => 'PADANGSIDIMPUAN ANGKOLA JULU', 'village_name' => 'SIMATOHIR'],
            ['district_name' => 'PADANGSIDIMPUAN BATUNADUA', 'village_name' => 'AEK BAYUR'],
            ['district_name' => 'PADANGSIDIMPUAN BATUNADUA', 'village_name' => 'AEK NAJAJI'],
            ['district_name' => 'PADANGSIDIMPUAN BATUNADUA', 'village_name' => 'AEK TUHUL'],
            ['district_name' => 'PADANGSIDIMPUAN BATUNADUA', 'village_name' => 'BARGOT TOPONG'],
            ['district_name' => 'PADANGSIDIMPUAN BATUNADUA', 'village_name' => 'BARUAS'],
            ['district_name' => 'PADANGSIDIMPUAN BATUNADUA', 'village_name' => 'BATANG BAHAL'],
            ['district_name' => 'PADANGSIDIMPUAN BATUNADUA', 'village_name' => 'BATUNADUA JAE'],
            ['district_name' => 'PADANGSIDIMPUAN BATUNADUA', 'village_name' => 'BATUNADUA JULU'],
            ['district_name' => 'PADANGSIDIMPUAN BATUNADUA', 'village_name' => 'GUNUNG HASAHATAN'],
            ['district_name' => 'PADANGSIDIMPUAN BATUNADUA', 'village_name' => 'PUDUN JAE'],
            ['district_name' => 'PADANGSIDIMPUAN BATUNADUA', 'village_name' => 'PUDUN JULU'],
            ['district_name' => 'PADANGSIDIMPUAN BATUNADUA', 'village_name' => 'PURWODADI'],
            ['district_name' => 'PADANGSIDIMPUAN BATUNADUA', 'village_name' => 'SILOTING'],
            ['district_name' => 'PADANGSIDIMPUAN BATUNADUA', 'village_name' => 'SIMIRIK'],
            ['district_name' => 'PADANGSIDIMPUAN BATUNADUA', 'village_name' => 'UJUNG GURAP'],
            ['district_name' => 'PADANGSIDIMPUAN HUTAIMBARU', 'village_name' => 'HUTA PADANG'],
            ['district_name' => 'PADANGSIDIMPUAN HUTAIMBARU', 'village_name' => 'HUTAIMBARU'],
            ['district_name' => 'PADANGSIDIMPUAN HUTAIMBARU', 'village_name' => 'LEMBAH LUBUK MANIK'],
            ['district_name' => 'PADANGSIDIMPUAN HUTAIMBARU', 'village_name' => 'LUBUK RAYA'],
            ['district_name' => 'PADANGSIDIMPUAN HUTAIMBARU', 'village_name' => 'PALOPAT MARIA'],
            ['district_name' => 'PADANGSIDIMPUAN HUTAIMBARU', 'village_name' => 'PARTIHAMAN SAROHA'],
            ['district_name' => 'PADANGSIDIMPUAN HUTAIMBARU', 'village_name' => 'SABUNGAN JAE'],
            ['district_name' => 'PADANGSIDIMPUAN HUTAIMBARU', 'village_name' => 'SABUNGAN SIPABANGUN'],
            ['district_name' => 'PADANGSIDIMPUAN HUTAIMBARU', 'village_name' => 'SINGALI'],
            ['district_name' => 'PADANGSIDIMPUAN HUTAIMBARU', 'village_name' => 'TINJOMAN LAMA'],
            ['district_name' => 'PADANGSIDIMPUAN SELATAN', 'village_name' => 'AEK TAMPANG'],
            ['district_name' => 'PADANGSIDIMPUAN SELATAN', 'village_name' => 'HANOPAN'],
            ['district_name' => 'PADANGSIDIMPUAN SELATAN', 'village_name' => 'LOSUNG'],
            ['district_name' => 'PADANGSIDIMPUAN SELATAN', 'village_name' => 'PADANG MATINGGI'],
            ['district_name' => 'PADANGSIDIMPUAN SELATAN', 'village_name' => 'PADANG MATINGGI LESTARI'],
            ['district_name' => 'PADANGSIDIMPUAN SELATAN', 'village_name' => 'SIDANGKAL'],
            ['district_name' => 'PADANGSIDIMPUAN SELATAN', 'village_name' => 'SILANDIT'],
            ['district_name' => 'PADANGSIDIMPUAN SELATAN', 'village_name' => 'SITAMIANG'],
            ['district_name' => 'PADANGSIDIMPUAN SELATAN', 'village_name' => 'SITAMIANG BARU'],
            ['district_name' => 'PADANGSIDIMPUAN SELATAN', 'village_name' => 'UJUNG PADANG'],
            ['district_name' => 'PADANGSIDIMPUAN SELATAN', 'village_name' => 'WEK V'],
            ['district_name' => 'PADANGSIDIMPUAN SELATAN', 'village_name' => 'WEK VI'],
            ['district_name' => 'PADANGSIDIMPUAN TENGGARA', 'village_name' => 'GOTI'],
            ['district_name' => 'PADANGSIDIMPUAN TENGGARA', 'village_name' => 'HUTA KOJE'],
            ['district_name' => 'PADANGSIDIMPUAN TENGGARA', 'village_name' => 'HUTA LOMBANG'],
            ['district_name' => 'PADANGSIDIMPUAN TENGGARA', 'village_name' => 'HUTA PADANG'],
            ['district_name' => 'PADANGSIDIMPUAN TENGGARA', 'village_name' => 'HUTALIMBONG'],
            ['district_name' => 'PADANGSIDIMPUAN TENGGARA', 'village_name' => 'LABUHAN LABO'],
            ['district_name' => 'PADANGSIDIMPUAN TENGGARA', 'village_name' => 'LABUHAN RASOKI'],
            ['district_name' => 'PADANGSIDIMPUAN TENGGARA', 'village_name' => 'MANEGEN'],
            ['district_name' => 'PADANGSIDIMPUAN TENGGARA', 'village_name' => 'MANUNGGANG JAE'],
            ['district_name' => 'PADANGSIDIMPUAN TENGGARA', 'village_name' => 'MANUNGGANG JULU'],
            ['district_name' => 'PADANGSIDIMPUAN TENGGARA', 'village_name' => 'PALOPAT PK'],
            ['district_name' => 'PADANGSIDIMPUAN TENGGARA', 'village_name' => 'PERKEBUNAN PK'],
            ['district_name' => 'PADANGSIDIMPUAN TENGGARA', 'village_name' => 'PIJOR KOLING'],
            ['district_name' => 'PADANGSIDIMPUAN TENGGARA', 'village_name' => 'PURBATUA PK'],
            ['district_name' => 'PADANGSIDIMPUAN TENGGARA', 'village_name' => 'SALAMBUE'],
            ['district_name' => 'PADANGSIDIMPUAN TENGGARA', 'village_name' => 'SIGULANG'],
            ['district_name' => 'PADANGSIDIMPUAN TENGGARA', 'village_name' => 'SIHITANG'],
            ['district_name' => 'PADANGSIDIMPUAN TENGGARA', 'village_name' => 'TARUTUNG BARU'],
            ['district_name' => 'PADANGSIDIMPUAN UTARA', 'village_name' => 'BATANG AYUMI JAE'],
            ['district_name' => 'PADANGSIDIMPUAN UTARA', 'village_name' => 'BATANG AYUMI JULU'],
            ['district_name' => 'PADANGSIDIMPUAN UTARA', 'village_name' => 'BINCAR'],
            ['district_name' => 'PADANGSIDIMPUAN UTARA', 'village_name' => 'BONAN DOLOK'],
            ['district_name' => 'PADANGSIDIMPUAN UTARA', 'village_name' => 'KANTIN'],
            ['district_name' => 'PADANGSIDIMPUAN UTARA', 'village_name' => 'KAYU OMBUN'],
            ['district_name' => 'PADANGSIDIMPUAN UTARA', 'village_name' => 'LOSUNG BATU'],
            ['district_name' => 'PADANGSIDIMPUAN UTARA', 'village_name' => 'PANYANGGAR'],
            ['district_name' => 'PADANGSIDIMPUAN UTARA', 'village_name' => 'SADABUAN'],
            ['district_name' => 'PADANGSIDIMPUAN UTARA', 'village_name' => 'TANOBATO'],
            ['district_name' => 'PADANGSIDIMPUAN UTARA', 'village_name' => 'TIMBANGAN'],
            ['district_name' => 'PADANGSIDIMPUAN UTARA', 'village_name' => 'TOBAT'],
            ['district_name' => 'PADANGSIDIMPUAN UTARA', 'village_name' => 'WEK I'],
            ['district_name' => 'PADANGSIDIMPUAN UTARA', 'village_name' => 'WEK II'],
            ['district_name' => 'PADANGSIDIMPUAN UTARA', 'village_name' => 'WEK III'],
            ['district_name' => 'PADANGSIDIMPUAN UTARA', 'village_name' => 'WEK IV'],
        ];

        foreach ($villages as $village) {
            Village::create([
                'district_id' => District::where('name', $village['district_name'])->first()->id,
                'name' => $village['village_name']
            ]);
        }
    }
}
