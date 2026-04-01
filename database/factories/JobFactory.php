<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\SlicerProfile;
use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'path' => '/uploads/jobs/' . $this->faker->uuid(),
            'stl_filename' => $this->faker->word() . '.stl',
            
            'gcode_filename' => null,
            'filament' => $this->faker->randomFloat(2, 10, 500),
            'created_time' => now(),
            'sliced_time' => null,
            'printing_time' => null,
            'finished_time' => null,
            'id_printer' => null,

            'id_slicer_profile' => SlicerProfile::factory(),
            'id_user' => User::factory(),
        ];
    }
}
