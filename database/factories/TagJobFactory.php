<?php

namespace Database\Factories;

use App\Models\Tag;
use App\Models\Job;
use App\Models\TagJob;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TagJob>
 */
class TagJobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_tag' => Tag::factory(),
            'id_job' => Job::factory(),
        ];
    }
}
