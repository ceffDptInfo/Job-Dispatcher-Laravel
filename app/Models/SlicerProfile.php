<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlicerProfile extends Model
{
    protected $fillable = [
        'name',
        'path',
        'color',
        'material',
    ];
}
