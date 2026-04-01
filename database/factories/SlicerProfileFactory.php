<?php

namespace Database\Factories;

use App\Models\SlicerProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SlicerProfile>
 */
class SlicerProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       return [
            'name' => $this->faker->unique()->randomElement([
                'Detail Preset', 
                'Fast Draft', 
                'Strength Optimized', 
                'Flexible TPU Profile', 
                'High Temp PETG'
            ]) . ' ' . $this->faker->numberBetween(1, 100),
            
            'path' => '/configs/profiles/' . $this->faker->slug() . '.ini',
            
            'color' => $this->faker->safeColorName(),
            
            'material' => $this->faker->randomElement([
                'PLA', 
                'ABS', 
                'PETG', 
                'TPU', 
                'ASA', 
                'Nylon'
            ]),
        ];
    }
}
