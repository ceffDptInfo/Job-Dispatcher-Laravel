<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;

    protected $table = 'job';
    public $timestamps = false; 

     protected $fillable = [
        'name',
        'path',
        'state',
        'stl_filename',
        'gcode_filename',
        'filament',
        'duration',
        'create_at',
        'slice_at',
        'print_at',
        'finish_at',
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
