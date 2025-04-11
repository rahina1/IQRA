<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hadith extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'texte_arabe',
        'traduction_haoussa',
        'traduction_zarma',
        'image',
        'audio_haoussa',
        'audio_zarma'
    ];

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
