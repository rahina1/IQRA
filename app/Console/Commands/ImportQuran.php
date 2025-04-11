<?php

namespace App\Console\Commands;

use App\Models\Sourate;
use App\Models\Verset;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ImportQuran extends Command
{
    protected $signature = 'import:quran';
    protected $description = 'Importer le Coran en arabe dans la base de données';

    public function handle()
    {
        $this->info("Début de l'importation du Coran...");

        // Charger le fichier JSON depuis l'URL
        $response = Http::get('https://cdn.jsdelivr.net/npm/quran-json@3.1.2/dist/quran.json');

        if ($response->failed()) {
            $this->error("Impossible de récupérer le fichier JSON !");
            return;
        }

        $data = $response->json();

        if (!$data) {
            $this->error("Erreur lors du décodage du JSON !");
            return;
        }

        foreach ($data as $sourateData) {
            // Insérer la sourate
            $sourate = Sourate::updateOrCreate([
                'numero' => $sourateData['id'],
                'nom_arabe' => $sourateData['name'],
                'nom_transliteration' => $sourateData['transliteration'],
                'nombre_versets' => $sourateData['total_verses'],
            ]);

            foreach ($sourateData['verses'] as $versetData) {
                // Insérer les versets
                Verset::updateOrCreate([
                    'sourate_id' => $sourate->id,
                    'numero' => $versetData['id'],
                    'texte_arabe' => $versetData['text'],
                ]);
            }
        }

        $this->info("Importation du Coran terminée avec succès !");
    }
}
