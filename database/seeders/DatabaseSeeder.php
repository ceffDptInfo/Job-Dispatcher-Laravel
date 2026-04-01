<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\SlicerProfile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test',
            'email' => 'test@example.com',
        ]);

        SlicerProfile::factory()->createMany([
           [ 
            'name' => 'sclicer one',
            'path' => 'C:\'test\'sclicerOne',
            'color' => 'Red',
            'material' => 'PLA',
            ],
            [ 
            'name' => 'sclicer two',
            'path' => 'C:\'test\'sclicerTwo',
            'color' => 'Black',
            'material' => 'PLA',
            ]
        ]);

        //  Job::factory()->create([
        //     'name' => 'Test',
        //     'email' => 'test@example.com',
        // ]);
    }
}
