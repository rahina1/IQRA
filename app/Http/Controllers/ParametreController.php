<?php

namespace App\Http\Controllers;

use App\Models\Erudit;
use App\Models\eruditt;
use Illuminate\Http\Request;

class ParametreController extends Controller
{
    public function index()
    {
        $erudits = Erudit::all();

        return view('traductions.parametre', compact('erudits'));
    }

    public function storeErudit(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:erudits,nom',
            'nationalite' => 'nullable|string|max:255',
            'biographie' => 'nullable|string',
        ]);

        Erudit::create([
            'nom' => $request->name,
            'nationalite' => $request->nationalite,
            'biographie' => $request->biographie,
        ]);

        return redirect()->route('param.index')->with('success', 'Érudit ajouté avec succès.');
    }

    public function updateErudit(Request $request, $id)
    {
        $erudit = Erudit::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:erudits,nom,' . $erudit->id,
            'nationalite' => 'nullable|string|max:255',
            'biographie' => 'nullable|string',
        ]);

        $erudit->update([
            'nom' => $request->name,
            'nationalite' => $request->nationalite,
            'biographie' => $request->biographie,
        ]);

        return redirect()->route('param.index')->with('success', 'Érudit modifié avec succès.');
    }
}
