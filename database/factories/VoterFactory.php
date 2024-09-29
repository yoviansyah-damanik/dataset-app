<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Village;
use App\Models\District;
use App\Models\Religion;
use App\Models\Profession;
use App\Models\Nasionality;
use App\Models\MaritalStatus;
use App\Models\Tps;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Voter>
 */
class VoterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::role('Tim Bersinar')
            ->inRandomOrder()
            ->first();
        $district_id = $user->district_id;
        $village_id = $user->village_id ?? Village::where('district_id', $district_id)->inRandomOrder()->first()->id;
        $tps_id = $user->tps_id ?? Tps::where('village_id', $village_id)->inRandomOrder()->first()->id;

        return [
            'nik' => $this->faker->numerify('################'),
            'name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'place_of_birth' => $this->faker->city(),
            'date_of_birth' => $this->faker->date('Y-m-d', Carbon::now()->subYears(17)),
            'gender' => ['Laki-laki', 'Perempuan'][mt_rand(0, 1)],
            'rt' => sprintf('%02d', mt_rand(0, 9)),
            'rw' => sprintf('%02d', mt_rand(0, 9)),
            'district_id' => $district_id,
            'village_id' => $village_id,
            'tps_id' => $tps_id,
            'religion_id' => Religion::inRandomOrder()->first()->id,
            'marital_status_id' => MaritalStatus::inRandomOrder()->first()->id,
            'profession_id' => Profession::inRandomOrder()->first()->id,
            'nasionality_id' => Nasionality::inRandomOrder()->first()->id,
            'phone_number' => str($this->faker->phoneNumber())->remove(' '),
            'year' => 2024,
            'team_id' => $user->id,
            'user_id' => $user->id,
            'created_at' => \Carbon\Carbon::now()->addDays(rand(-10, 0)),
            'updated_at' => \Carbon\Carbon::now()->addDays(rand(-10, 0)),
            'ktp' => rand(0, 1) ? $this->faker->imageUrl() : null,
            'kk' => rand(0, 1) ? $this->faker->imageUrl() : null
        ];
    }
}
