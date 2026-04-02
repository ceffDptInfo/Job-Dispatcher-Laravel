<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\SlicerProfile;
use App\Models\User;
use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;


    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test',
            'email' => 'test@example.com',
        ]);

        SlicerProfile::factory()->createMany(
            [
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
                'material' => 'PETG',
                ]
            ]
        );

         Job::factory()->createMany(
            [
                [
                    'name'              => 'Benchy_Stress_Test',
                    'path'              => '/uploads/models/benchy/',
                    'state'             => 'waiting to be sliced',
                    'stl_filename'      => '3dbenchy_v2.stl',
                    'gcode_filename'    => null, 
                    'filament'          => 14.5,
                    'duration'          => null,
                    'create_at'         => now(), 
                    'slice_at'          => null,  
                    'print_at'          => null,  
                    'finish_at'         => null,  
                    'id_printer'        => null, 
                    'id_slicer_profile' => 1,    
                    'id_user'           => 1,    
                ],
                [
                    'name'              => 'Moving_flower',
                    'path'              => '/uploads/models/flower/',
                    'state'             => 'Waiting to be printed',
                    'stl_filename'      => 'flower_full.stl',
                    'gcode_filename'    => 'flower_04noz_pla.gcode',
                    'filament'          => 60.7,
                    'duration'          => 2, 
                    'create_at'         => now()->subDays(1),
                    'slice_at'          => now(),
                    'print_at'          => null,
                    'finish_at'         => null,
                    'id_printer'        => null,
                    'id_slicer_profile' => 2,
                    'id_user'           => 1,
                ],
                [
                    'name'              => 'Articulated_Dragon',
                    'path'              => '/uploads/models/dragon/',
                    'state'             => 'Finished',
                    'stl_filename'      => 'dragon_full.stl',
                    'gcode_filename'    => 'dragon_04noz_pla.gcode',
                    'filament'          => 150.2,
                    'duration'          => 5, 
                    'create_at'         => now()->subDays(1),
                    'slice_at'          => now()->subHours(5),
                    'print_at'          => now()->subHours(4),
                    'finish_at'         => now(),
                    'id_printer'        => 'Ender-3-V2-01',
                    'id_slicer_profile' => 2,
                    'id_user'           => 1,
                ],
            ]
        );
    }
}
