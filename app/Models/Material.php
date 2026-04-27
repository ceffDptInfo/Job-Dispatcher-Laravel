<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'material';


    protected $fillable = [
        'name',
    ];
}
