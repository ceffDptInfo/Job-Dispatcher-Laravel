<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;

     protected $fillable = [
        'name',
        'path',
        'stl_filename',
        'film_id',
        'state',
        'filament',
        'film_id',
        'sliced_time',
        'printing_time',
        'finished_time',
        'id_printer',
        'id_slicer_profile',
        'id_user',
    ];

     public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function slicerprofile()
    {
        return $this->belongsTo(SlicerProfile::class);
    }
}
