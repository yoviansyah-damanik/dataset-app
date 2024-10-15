<?php

namespace App\Jobs;

use App\Models\Dpt as ModelsDpt;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Dpt implements ShouldQueue
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
        ModelsDpt::truncate();
        $file = fopen(resource_path() . "/files/all_dpt.csv", "r");
        while (! feof($file)) {
            $data = fgetcsv($file);
            if ($data) {
                \App\Models\Dpt::create([
                    'name' => $data[0],
                    'gender' => $data[1],
                    'age' => $data[2],
                    'address' => $data[3],
                    'rt' => $data[4],
                    'rw' => $data[5],
                    'district_id' => $data[6],
                    'village_id' => $data[7],
                    'tps_id' => $data[8],
                ]);
            }
        }
    }
}
