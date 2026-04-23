<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_tag';

    protected $fillable = [
        'name',

        'id_user',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
