<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\SlicerProfile;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->createMany(
            [
                [ 
                'name' => 'Admin',
                'email' => 'admin@ceff.ch',
                'password'=> bcrypt('1234'),
                'role' => 'admin',
                ],

                [
                'name' => 'Leila',
                'email' => 'leila@ceff.ch',
                'password'=> bcrypt('1234'),
                'role' => 'user',
                ],

                [
                'name' => 'Gwen',
                'email' => 'gwendoline@ceff.ch',
                'password'=> bcrypt('1234'),
                'role' => 'user',
                ],

                [
                'name' => 'Simon',
                'email' => 'simon@ceff.ch',
                'password'=> bcrypt('1234'),
                'role' => 'user',
                ],

                [
                'name' => 'Gyan',
                'email' => 'gyan@ceff.ch',
                'password'=> bcrypt('1234'),
                'role' => 'user',
                ],
            ]
        );

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
                ],
                [ 
                'name' => 'sclicer tree',
                'path' => 'C:\'test\'sclicerTwo',
                'color' => 'Black',
                'material' => 'ABS',
                ],
                [ 
                'name' => 'sclicer four',
                'path' => 'C:\'test\'sclicerTwo',
                'color' => 'Black',
                'material' => 'Nylon',
                ]
            ]
        );

        State::factory()->createMany(
            [
                [
                    'name' => 'waiting',
                ],
                [
                    'name' => 'sliced',
                ],
                [
                    'name' => 'error_slicing',
                ],
                [
                    'name' => 'printing',
                ],
                [
                    'name' => 'error_printing',
                ],
                [
                    'name' => 'finished',
                ],
            ]
        );

         Job::factory()->createMany(
            [
                [
                    'name'              => 'Benchy_Stress_Test',
                    'path'              => '/uploads/models/benchy/',
                    'name_state'        => 'waiting',
                    'stl_filename'      => '3dbenchy_v2.stl',
                    'gcode_filename'    => null, 
                    'filament'          => null,
                    'duration'          => null,
                    'create_at'        => Carbon::parse('2026-03-01 10:00:00'), 
                    'slice_at'          => null,  
                    'print_at'          => null,  
                    'finish_at'         => null,  
                    'id_printer'        => 1, 
                    
                    'id_slicer_profile' => 1,    
                    'id_user'           => 1,    
                ],
                [
                    'name'              => 'Moving_flower',
                    'path'              => '/uploads/models/flower/',
                    'name_state'        => 'sliced',
                    'stl_filename'      => 'flower_full.stl',
                    'gcode_filename'    => 'flower_04noz_pla.gcode',
                    'filament'          => 60.7,
                    'duration'          => 5000, 
                    'create_at'         => Carbon::parse('2026-03-01 11:00:00'), 
                    'slice_at'          => Carbon::parse('2026-03-01 12:00:00'), 
                    'print_at'          => null,
                    'finish_at'         => null,
                    'id_printer'        => 1,

                    'id_slicer_profile' => 2,
                    'id_user'           => 1,
                ],
                [
                    'name'              => 'Stress_toy',
                    'path'              => '/uploads/models/stressToy/',
                    'name_state'        => 'printing',
                    'stl_filename'      => 'stressToy_full.stl',
                    'gcode_filename'    => 'stressToy_04noz_pla.gcode',
                    'filament'          => 70.7,
                    'duration'          => 7000, 
                    'create_at'         => Carbon::parse('2026-03-01 13:00:00'), 
                    'slice_at'          => Carbon::parse('2026-03-01 14:00:00'), 
                    'print_at'          => Carbon::parse('2026-03-01 15:00:00'),
                    'finish_at'         => null,
                    'id_printer'        => 1,

                    'id_slicer_profile' => 2,
                    'id_user'           => 1,
                ],
                [
                    'name'              => 'Articulated_Dragon',
                    'path'              => '/uploads/models/dragon/',                    
                    'name_state'        => 'finished',
                    'stl_filename'      => 'dragon_full.stl',
                    'gcode_filename'    => 'dragon_04noz_pla.gcode',
                    'filament'          => 150.2,
                    'duration'          => 90000, 
                    'create_at'         => Carbon::parse('2026-03-01 16:00:00'), 
                    'slice_at'          => Carbon::parse('2026-03-01 17:00:00'), 
                    'print_at'          => Carbon::parse('2026-03-01 18:00:00'), 
                    'finish_at'         => Carbon::parse('2026-03-01 19:00:00'), 
                    'id_printer'        => 1,

                    'id_slicer_profile' => 2,
                    'id_user'           => 1,
                ],
            ]
        );

        
    }
}