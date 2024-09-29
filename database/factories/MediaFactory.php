<?php

namespace Database\Factories;

use App\Models\Voter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'path' => $this->faker->imageUrl(),
            'mime_type' => 'image',
            'type' => 'KTP',
            'user_id' => function (array $attributes) {
                return Voter::find($attributes['mediable_id'])->user_id;
            }
        ];
    }
}
