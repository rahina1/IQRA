<?php

namespace App\Http\Controllers;

use App\Models\Erudit;
use App\Models\eruditt;
use App\Models\Sourate;
use App\Models\traduction;
use App\Models\Verset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TraductionController extends Controller
{
    public function index()
    {
        $traductions = Traduction::with(['verset.sourate', 'erudit'])
            ->orderBy('created_at', 'desc')
            ->get();

        $erudits = Erudit::all();
        $sourates = Sourate::orderBy('numero')->get();

        return view('traductions.index', compact('traductions', 'erudits', 'sourates'));
    }


    public function versetSelects(Request $request)
    {
        $request->validate([
            'erudit_id' => 'required|exists:erudits,id',
            'langue' => 'required|in:francais,haoussa,zarma',
            'sourate_id' => 'required|exists:sourates,id',
        ]);

        $sourate = Sourate::findOrFail($request->sourate_id);
        $versets = Verset::where('sourate_id', $sourate->id)->orderBy('numero')->get();
        $erudit = Erudit::findOrFail($request->erudit_id);
        $langue = $request->langue;

        return view('traductions.verset', compact('versets', 'sourate', 'erudit', 'langue'));
    }


    // Affiche la liste des sourates
    public function sourate()
    {
        $sourates = Sourate::all(); //  sourates
        return view('traductions.sourate', compact('sourates'));
    }


    // Affiche la liste des versets

    public function verset($id)
    {
        $sourate = Sourate::findOrFail($id);
        $versets = $sourate->versets()->get();
        return view('traductions.verset', compact('sourate', 'versets'));
    }
    // Afficher le formulaire d'ajout
    public function create()
    {
        $versets = Verset::all();
        $erudits = Erudit::all();
        $sourates = Sourate::all(); //
        return view('traductions.create', compact('versets', 'erudits', 'sourates'));
    }

    // Sauvegarder une nouvelle traduction
    public function store(Request $request)
    {
        $request->validate([
            'verset_id' => 'required|exists:versets,id',
            'erudit_id' => 'required|exists:erudits,id',
            'langue' => 'required|string|max:50',
            'texte_traduction' => 'nullable|string',
            'audio_traduction' => 'nullable|file|mimes:mp3,wav'
        ]);

        // Création de la traduction
        $traduction = new Traduction();
        $traduction->verset_id = $request->verset_id;
        $traduction->eruditt_id = $request->erudit_id;
        $traduction->langue = $request->langue;
        $traduction->texte_traduction = $request->texte_traduction;

        // Gestion du fichier audio s'il y en a un
        if ($request->hasFile('audio_traduction')) {
            $audioPath = $request->file('audio_traduction')->store('audio_traductions', 'public');
            $traduction->audio_traduction = $audioPath;
        }

        $traduction->save();

        return redirect()->route('traductions.index')->with('success', 'Traduction ajoutée avec succès !');
    }

    public function show(Traduction $traduction)
    {
        return view('traductions.show', compact('traduction'));
    }

    public function edit(Traduction $traduction)
    {
        $versets = Verset::all();
        $erudits = Erudit::all();
        return view('traductions.edit', compact('traduction', 'versets', 'erudits'));
    }

    public function update(Request $request, Traduction $traduction)
    {
        $request->validate([
            'verset_id' => 'required|exists:versets,id',
            'erudit_id' => 'required|exists:erudits,id',
            'langue' => 'required|string',
            'texte_traduction' => 'nullable|string',
            'audio' => 'nullable|mimes:mp3,wav|max:10240',
        ]);

        if ($request->hasFile('audio')) {
            if ($traduction->audio_path) {
                Storage::disk('public')->delete($traduction->audio_path);
            }
            $traduction->audio_path = $request->file('audio')->store('traductions_audios', 'public');
        }

        $traduction->update($request->all());

        return redirect()->route('traductions.index')->with('success', 'Traduction mise à jour.');
    }


    public function storeVersets(Request $request)
    {
        // Validation des données de base
        $validator = Validator::make($request->all(), [
            'erudit_id' => 'required|integer|exists:erudits,id',
            'langue' => 'required|string|max:50',
            'sourate_id' => 'required|integer|exists:sourates,id',
            'versets' => 'sometimes|array',
            'versets.*.selected' => 'sometimes|boolean',
            'versets.*.texte' => 'nullable|string',
            'versets.*.audio' => 'nullable|file|mimes:mp3,wav,aac|max:2048',
            'audio_group' => 'nullable|file|mimes:mp3,wav,aac|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Traitement de l'audio global si fourni et appliqué
            $groupAudioPath = null;
            if ($request->hasFile('audio_group') && $request->has('applyGroupAudio')) {
                $groupAudioPath = $this->storeAudioFile($request->file('audio_group'), 'public/audios');
            }

            // Traitement des versets sélectionnés
            if ($request->has('versets')) {
                foreach ($request->versets as $versetId => $versetData) {
                    if (!empty($versetData['selected'])) {
                        $audioPath = $groupAudioPath;

                        // Si audio individuel fourni (et pas d'audio global)
                        if (!$groupAudioPath && isset($versetData['audio']) && $versetData['audio']->isValid()) {
                            $audioPath = $this->storeAudioFile($versetData['audio'], 'public/audios');
                        }

                        // Création de la traduction
                        Traduction::updateOrCreate(
                            [
                                'verset_id' => $versetId,
                                'erudit_id' => $request->erudit_id,
                                'langue' => $request->langue,
                            ],
                            [
                                'texte_traduction' => $versetData['texte'] ?? null,
                                'audio_path' => $audioPath,
                            ]
                        );
                    }
                }
            }

            return redirect()->back()
                ->with('success', 'Traductions enregistrées avec succès!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Une erreur est survenue: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Stocke un fichier audio et retourne le chemin
     */
    private function storeAudioFile($file, $directory)
    {
        $fileName = 'audio_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($directory, $fileName);
    }
}
