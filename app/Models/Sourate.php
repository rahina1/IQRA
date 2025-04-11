<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sourate extends Model
{
    use HasFactory;
    protected $fillable = ['numero', 'nom_arabe', 'nom_transliteration', 'nombre_versets'];

    public function versets()
    {
        return $this->hasMany(Verset::class);
    }
}
