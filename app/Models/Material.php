<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'material';

    protected $primaryKey = 'id_material';
    
    protected $fillable = [
        'name',
    ];

    public function profiles()
    {
        return $this->hasMany(SlicerProfile::class, 'id_material');
    }

    public function colors()
    {
        return $this->hasMany(Color::class, 'id_material');
    }
}
