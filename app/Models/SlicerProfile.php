<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class SlicerProfile extends Model
{
    use HasFactory;

    protected $table = 'slicer_profile';
    public $timestamps = false;
    protected $primaryKey = 'id_slicer_profile';

    protected $fillable = [
        'name',
        'path',
        'id_material',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class, 'id_material');
    }
}
