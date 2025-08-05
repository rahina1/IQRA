<div class="col-md-6">
    <div class="card shadow-sm border-0 h-100">
        <div class="card-body">
            <h5 class="card-title text-success">
                Sourate {{ $traduction->verset->sourate->numero }} –
                {{ $traduction->verset->sourate->nom_transliteration }}
            </h5>
            <p class="mb-2 text-muted">Verset {{ $traduction->verset->numero }}</p>

            <p class="mb-3 fs-4 text-arabic">{{ $traduction->verset->texte_arabe }}</p>

            <p>{{ $traduction->texte_traduction ?? 'Non disponible' }}</p>

            @if ($traduction->audio_path)
                <audio controls src="" preload="auto">
                    Votre navigateur ne supporte pas l'audio.
                </audio>
            @else
                <p class="text-warning mt-3">Aucun audio disponible</p>
            @endif

            <hr>

            <p class="text-muted small">
                Traduit par : {{ $traduction->erudit->nom }}
                ({{ $traduction->erudit->nationalite }})
            </p>
        </div>
    </div>
</div>
