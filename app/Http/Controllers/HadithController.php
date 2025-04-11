<?php

namespace App\Http\Controllers;

use App\Models\Hadith;
use Illuminate\Http\Request;

class HadithController extends Controller
{
    // Affiche la liste des Hadith
    public function index()
    {
        $sourates = Hadith::all();
        return view('hadiths.index', compact('sourates'));
    }
}
