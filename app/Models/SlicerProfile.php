<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class SlicerProfile extends Model
{
    use HasFactory;

    protected $table = 'slicer_profile';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'path',
        'color',
        'material',
    ];
}
