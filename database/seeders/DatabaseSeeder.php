<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\SlicerProfile;
use App\Models\State;
use App\Models\User;
use App\Models\Color;
use App\Models\Material;
use App\Models\Tag;
use App\Models\TagJob;
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
                    'code' => 'w',
                    'name' => 'waiting',
                    'color' => '#f1c40f', 
                ],
                [
                    'code' => 's',
                    'name' => 'sliced',
                    'color' => '#3498db', 
                ],
                [
                    'code' => 'es',
                    'name' => 'error_slicing',
                    'color' => '#e67e22', 
                ],
                [
                    'code' => 'p',
                    'name' => 'printing',
                    'color' => '#9b59b6', 
                ],
                [
                    'code' => 'ep',
                    'name' => 'error_printing',
                    'color' => '#e74c3c', 
                ],
                [
                    'code' => 'f',
                    'name' => 'finished',
                    'color' => '#2ecc71', 
                ],
            ]
        );

         Job::factory()->createMany(
            [
                [
                    'name'              => 'Benchy_Stress_Test',
                    'path'              => '/uploads/models/benchy/',
                    'code_state'        => 'w', //code
                    'stl_filename'      => '3dbenchy_v2.stl',
                    'gcode_filename'    => null, 
                    'filament'          => null,
                    'duration'          => null,
                    'create_at'         => Carbon::parse('2026-03-01 10:00:00'), 
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
                    'code_state'        => 's',
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
                    'code_state'        => 'p',
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
                    'code_state'        => 'f',
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

        Material::factory()->createMany(
            [
                [
                    'name' => 'PLA'
                ],

                [
                    'name' => 'PETG'
                ],
            ] 
        );

        Color::factory()->createMany(
            [
                [
                    'name'  => 'Red',
                    'id_material'  => '1',
                ],

                [
                    'name'  => 'Red',
                    'id_material'  => '1',
                ],

                [
                    'name'  => 'blue',
                    'id_material'  => '2',
                ]
            ]
        );
        
        Tag::factory()->createMany(
            [
                [
                    'name'  => 'Favorites',
                    'id_user'  => '1',
                ],
                [
                    'name'  => 'dragon',
                    'id_user'  => '1',
                ],
                [
                    'name'  => 'prototype',
                    'id_user'  => '1',
                ],
            ]          
        );
        TagJob::factory()->createMany(
            [
                [
                    'id_tag'  => '1',
                    'id_job'  => '1',
                ],
                
                [
                    'id_tag'  => '2',
                    'id_job'  => '2',
                ],
                
                [
                    'id_tag'  => '3',
                    'id_job'  => '3',
                ],
            ]  
        );
    }
}