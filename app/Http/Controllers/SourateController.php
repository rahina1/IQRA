<?php

namespace App\Http\Controllers;

use App\Models\Sourate;
use App\Models\Verset;
use Illuminate\Http\Request;

class SourateController extends Controller
{
    // Affiche la liste des sourates
    public function index()
    {
        $sourates = Sourate::all(); //  sourates
        return view('sourates.index', compact('sourates'));
    }

    // Affiche une sourate spécifique avec ses versets
    public function show($id)
    {
        $sourate = Sourate::findOrFail($id);
        $versets = $sourate->versets()->get(); 
        return view('sourates.show', compact('sourate', 'versets'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $sourates = Sourate::where('nom_arabe', 'LIKE', "%$query%")
            ->orWhere('nom_transliteration', 'LIKE', "%$query%")
            ->get();

        return response()->json($sourates);
    }

    public function searchVersets(Request $request, $sourateId)
    {
        $query = $request->input('query');

        $versets = Verset::where('sourate_id', $sourateId)
            ->where(function ($q) use ($query) {
                $q->where('texte_arabe', 'LIKE', "%$query%")
                    ->orWhere('transliteration', 'LIKE', "%$query%");
            })
            ->get();

        return response()->json($versets);
    }
}
