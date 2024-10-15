<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Collection;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class Coordinator implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data_added = new Collection();
        User::withoutRole('Superadmin')
            ->delete();
        // \Spatie\Permission\Models\Permission::truncate();
        // \Spatie\Permission\Models\Role::truncate();
        // START DISTRICT COOR
        $file = fopen(resource_path() . "/files/koor kecamatan.csv", "r");
        while (! feof($file)) {
            $data = fgetcsv($file);
            if ($data) {
                $username = \Illuminate\Support\Str::of($data[1] . ' ' . $data[0])->lower()->snake()->value;
                $payload = [
                    'username' => $username,
                    'fullname' => $data[1],
                    'district' => "PADANGSIDIMPUAN $data[0]",
                    'password' => bcrypt($username)
                ];

                \App\Models\User::create($payload)->assignRole('Koordinator Kecamatan');
                $data_added->push([...$payload, 'role' => 'Koordinator Kecamatan']);
            }
        }
        fclose($file);

        // START VILLAGE COOR, TPS COOR, TEAM
        $file1 = fopen(resource_path() . "/files/koor kelurahan, koor tps, tim bersinar.csv", "r");
        $file2 = fopen(resource_path() . "/files/koor kelurahan, koor tps, tim bersinar 2.csv", "r");
        $file3 = fopen(resource_path() . "/files/koor kelurahan, koor tps, tim bersinar 3.csv", "r");
        // 0 => Kode
        // 1 => Nama
        // 2 => Peran
        // 3 => Kecamatan
        // 4 => Kelurahan
        // 5 => TPS

        foreach (range(1, 3) as $x) {
            while (! feof(${'file' . $x})) {
                $data = fgetcsv(${'file' . $x});
                if ($data) {
                    $username = $data[0] . ' ' . explode(' ', $data[1])[0];
                    if (count(explode(' ', $data[1])) > 1)
                        $username .= ' ' . explode(' ', $data[1])[1];

                    $username = \Illuminate\Support\Str::of($username)->lower()->snake()->value;

                    if (in_array($data[2], ['Koordinator Kelurahan/Desa', 'Koordinator TPS']))
                        $username = "coor_" . $username;

                    $payload = [
                        'username' => $username,
                        'fullname' => $data[1],
                        'district_id' => \App\Models\District::where('name', "PADANGSIDIMPUAN $data[3]")->first()->id,
                        'village_id' => \App\Models\Village::where('name', $data[4])->first()->id,
                        'tps_id' => \App\Models\Tps::where('name', "TPS $data[5]")->first()->id,
                        'password' => bcrypt($username)
                    ];

                    \App\Models\User::create($payload)->assignRole($data[2]);

                    $data_added->push([
                        ...$payload,
                        'role' => $data[2]
                    ]);
                }
            }
        }
        fclose(${'file' . $x});
    }
}