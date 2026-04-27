<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'job';
    public $timestamps = false;
    protected $primaryKey = 'id_job';

    protected $fillable = [
        'name',
        'path',
        'code_state',
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
        return $this->belongsTo(User::class, 'id_user');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'code_state', 'code');
    }

    public function slicerprofile()
    {
        return $this->belongsTo(SlicerProfile::class, 'id_slicer_profile');
    }


    protected function statusColor(): Attribute
    {
        return Attribute::make(
            get: fn() => match ($this->code_state) {
                'Finished' => 'green',
                'Printing' => 'orange',
                'Sliced' => 'blue',
                'Waiting' => 'gray',
                'Error Printing' => 'red1',
                'Error Slicing' => 'red2',
                default => 'gray',
            },
        );
    }
}
