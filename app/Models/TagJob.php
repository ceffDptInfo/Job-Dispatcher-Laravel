<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TagJob extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'tag_job';

    protected $fillable = [
        'id_job',
        'id_tag',
    ];

    public function job()
    {
        return $this->belongsTo(Tag::class, 'id_job');
    }

    public function tag()
    {
        return $this->belongsTo(Job::class, 'id_tag');
    }
}
