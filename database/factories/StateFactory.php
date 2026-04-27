<?php

namespace Database\Factories;

use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<State>
 */
class StateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return 
        [
            'code' => strtoupper($this->faker->unique()->lexify('???')),
            
            'name' => $this->faker->randomElement(['finished', 'waiting']),
            
            'color' => $this->faker->safeHexColor()
        ];
    }
}
