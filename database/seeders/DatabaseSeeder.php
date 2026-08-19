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
                    'password' => bcrypt('1234'),
                    'role' => 'admin',
                ],

                [
                    'name' => 'Simon',
                    'email' => 'simon@ceff.ch',
                    'password' => bcrypt('1234'),
                    'role' => 'user',
                ],
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

        SlicerProfile::factory()->createMany(
            [
                [
                    'name' => 'PLA-fast',
                    'path' => '\\\\PC-BD12-11\\printer-nfs\\SlicerProfiles',
                    'id_material' => 1,
                ],

                [
                    'name' => 'PLA-medium',
                    'path' => '\\\\PC-BD12-11\\printer-nfs\\SlicerProfiles',
                    'id_material' => 1,
                ],

                [
                    'name' => 'PLA-slow',
                    'path' => '\\\\PC-BD12-11\\printer-nfs\\SlicerProfiles',
                    'id_material' => 1,
                ],

                [
                    'name' => 'PETG-fast',
                    'path' => '\\\\PC-BD12-11\\printer-nfs\\SlicerProfiles',
                    'id_material' => 2,
                ],

                [
                    'name' => 'PETG-medium',
                    'path' => '\\\\PC-BD12-11\\printer-nfs\\SlicerProfiles',
                    'id_material' => 2,
                ],

                [
                    'name' => 'PETG-slow',
                    'path' => '\\\\PC-BD12-11\\printer-nfs\\SlicerProfiles',
                    'id_material' => 2,
                ]
            ]
        );

        Color::factory()->createMany(
            [
                [
                    'name'  => 'Red',
                    'id_material'  => '1',
                ],

                [
                    'name'  => 'Black',
                    'id_material'  => '1',
                ],

                [
                    'name'  => 'Red',
                    'id_material'  => '2',
                ],

                [
                    'name'  => 'Blue',
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
                    'id_user'  => '2',
                ],
                [
                    'name'  => 'prototype',
                    'id_user'  => '2',
                ],
            ]
        );
    }
}
