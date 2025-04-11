<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traduction extends Model
{
    use HasFactory;

    protected $fillable = ['verset_id', 'erudit_id', 'langue', 'texte_traduction', 'audio_path'];


    public function verset()
    {
        return $this->belongsTo(Verset::class);
    }

    public function erudit()
    {
        return $this->belongsTo(Erudit::class);
    }
}
