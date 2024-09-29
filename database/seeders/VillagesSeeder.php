<?php

namespace Database\Seeders;

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
        $district_1 = ['Batang Ayumi Jae', 'Batang Ayumi Julu', 'Bincar', 'Bonan Dolok', 'Kantin', 'Kayu Ombun', 'Losung Batu', 'Panyanggar', 'Sadabuan', 'Tanobato', 'Timbangan', 'Tobat', 'Wek I', 'Wek II', 'Wek III', 'Wek IV'];
        $district_2 = ['Goti', 'Huta Koje', 'Huta Lombang', 'Huta Padang', 'Hutalimbong', 'Labuhan Labo', 'Labuhan Rasoki', 'Manegen', 'Manunggang Jae', 'Manunggang Julu', 'Palopat Pijor Koling', 'Perkebunan Pijor Koling', 'Purbatua Pijor Koling', 'Salambue', 'Sigulang', 'Tarutung Baru', 'Pijor Koling', 'Sihitang'];
        $district_3 = ['Aek Tampang', 'Hanopan', 'Losung', 'Padang Matinggi', 'Padang Matinggi Lestari', 'Sidangkal', 'Silandit', 'Sitamiang', 'Sitamiang Baru', 'Ujung Padang', 'Wek V', 'Wek VI'];
        $district_4 = ['Huta Padang', 'Partihaman Saroha', 'Sabungan Sipabangun', 'Singali', 'Tinjoman Lama', 'Hutaimbaru', 'Lembah Lubuk Manik', 'Lubuk Raya', 'Palopat Maria', 'Sabungan Jae'];
        $district_5 = ['Aek Bayur', 'Aek Najaji', 'Aek Tuhul', 'Bargot Topong', 'Baruas', 'Batang Bahal', 'Gunung Hasahatan', 'Pudun Jae', 'Pudun Julu', 'Purwodadi', 'Siloting', 'Simirik', 'Ujung Gurap', 'Batunadua Jae', 'Batunadua Julu'];
        $district_6 = ['Batu Layan', 'Joring Lombang', 'Joring Natobang', 'Mompang', 'Pintu Langit Jae', 'Rimba Soping', 'Simasom', 'Simatohir'];

        for ($x = 1; $x <= 6; $x++) {
            foreach (${'district_' . $x} as $item) {
                Village::create([
                    'district_id' => $x,
                    'name' => $item
                ]);
            }
        }
    }
}
