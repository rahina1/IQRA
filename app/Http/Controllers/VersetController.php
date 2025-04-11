<?php

namespace App\Http\Controllers;

use App\Models\Verset;
use Illuminate\Http\Request;

class VersetController extends Controller
{
    // Affiche un verset spécifique
    public function show($id)
    {
        $verset = Verset::findOrFail($id);
        return view('versets.show', compact('verset'));
    }
}
