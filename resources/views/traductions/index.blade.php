@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column min-vh-100">
        <div class="container flex-grow-1 py-4">

            <!-- EN-TÊTE -->
            <div class="text-center mb-5">
                <h1 class="text-success fw-bold mb-3">Traductions du Coran</h1>
                <p class="lead text-muted">Explorez les différentes traductions disponibles</p>
            </div>

            <!-- BARRE D'ACTIONS -->
            <div class="d-flex justify-content-between align-items-center mb-5">
                <button class="btn btn-success btn-lg px-4" data-bs-toggle="modal" data-bs-target="#addTraductionModal">
                    <i class="fas fa-plus-circle me-2"></i>Ajouter une traduction
                </button>
                <a href="{{ route('param.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                    <i class="fas fa-cog me-2"></i>Paramètres
                </a>
            </div>

            <!-- MODAL AJOUT TRADUCTION -->
            <div class="modal fade" id="addTraductionModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <form method="GET" action="{{ route('traductions.versets.select') }}" class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title">Nouvelle Traduction</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="erudit_id" class="form-label">Érudit</label>
                                    <select name="erudit_id" id="erudit_id" class="form-select" required>
                                        <option value="" disabled selected>Choisissez un érudit</option>
                                        @foreach ($erudits as $erudit)
                                            <option value="{{ $erudit->id }}" data-photo="{{ $erudit->photo_url ?? '' }}">
                                                {{ $erudit->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row g-3">
                                    <label for="langue" class="form-label">Langue</label>
                                    <select name="langue" id="langue" class="form-select" required>
                                        <option value="" disabled selected>Choisissez une langue</option>
                                        <option value="haoussa">Haoussa</option>
                                        <option value="zarma">Zarma</option>
                                        <option value="francais">Français</option>
                                    </select>
                                </div>

                                <div class="row g-3">
                                    <label for="sourate_id" class="form-label">Sourate</label>
                                    <select name="sourate_id" id="sourate_id" class="form-select" required>
                                        <option value="" disabled selected>Choisissez une sourate</option>
                                        @foreach ($sourates as $sourate)
                                            <option value="{{ $sourate->id }}"> {{ $sourate->id }}
                                                {{ $sourate->nom_arabe }} {{ $sourate->nom_transliteration }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Suivant</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- LISTE DES TRADUCTIONS PAR LANGUE -->
            <div class="mt-5">
                <h2 class="h4 mb-4">Liste des Traductions</h2>

                @if ($traductions->isEmpty())
                    <p class="text-muted">Aucune traduction trouvée.</p>
                @else
                    <!-- Zarma -->
                    @if ($traductions->where('langue', 'zarma')->count() > 0)
                        <div class="mb-5">
                            <h3 class="h5 mb-3 text-success border-bottom pb-2">Traductions en Zarma</h3>
                            <div class="row g-4">
                                @foreach ($traductions->where('langue', 'zarma') as $traduction)
                                    @include('traductions.traduction-card', ['traduction' => $traduction])
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Haoussa -->
                    @if ($traductions->where('langue', 'haoussa')->count() > 0)
                        <div class="mb-5">
                            <h3 class="h5 mb-3 text-success border-bottom pb-2">Traductions en Haoussa</h3>
                            <div class="row g-4">
                                @foreach ($traductions->where('langue', 'haoussa') as $traduction)
                                    @include('traductions.traduction-card', ['traduction' => $traduction])
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Français -->
                    @if ($traductions->where('langue', 'francais')->count() > 0)
                        <div class="mb-5">
                            <h3 class="h5 mb-3 text-success border-bottom pb-2">Traductions en Français</h3>
                            <div class="row g-4">
                                @foreach ($traductions->where('langue', 'francais') as $traduction)
                                    @include('traductions.traduction-card', ['traduction' => $traduction])
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection
