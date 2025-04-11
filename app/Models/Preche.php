<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preche extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'audio',
        'video',
        'langue'
    ];

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
