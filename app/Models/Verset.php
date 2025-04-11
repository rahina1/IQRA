<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verset extends Model
{
    use HasFactory;
    protected $fillable = ['sourate_id', 'numero', 'texte_arabe'];

    public function sourate()
    {
        return $this->belongsTo(Sourate::class);
    }

    public function traductions()
    {
        return $this->hasMany(Traduction::class);
    }
}
