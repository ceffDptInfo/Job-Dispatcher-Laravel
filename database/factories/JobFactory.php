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
            'name' => substr($this->faker->words(3, true), 0, 50),
            'path' => $this->faker->lexify('/uploads/jobs/'),
            'state' => $this->faker->randomElement(['pending', 'processing', 'completed', 'failed']),
            'stl_filename' => substr($this->faker->word() . '.stl', 0, 100),
            
            'gcode_filename' => null,
            'filament' => $this->faker->randomFloat(2, 10, 500),
            'duration' => null,
            
            'create_at' => now(), 
            'slice_at' => null,
            'print_at' => null,
            'finish_at' => null,
            'id_printer' => null,

            'id_slicer_profile' => SlicerProfile::factory(),
            'id_user' => User::factory(),
        ];
    }
}