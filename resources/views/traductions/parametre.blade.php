@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h1 class="text-center text-primary fw-bold">Paramètres des Érudits</h1>

        <!-- Bouton pour ouvrir le modal d'ajout -->
        <div class="text-end mb-3">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addEruditModal">
                + Ajouter un érudit
            </button>
        </div>

        <!-- Liste des érudits -->
        <div class="card p-4">
            <h3 class="text-success">Liste des Érudits</h3>
            <ul class="list-group mt-3">
                @foreach ($erudits as $erudit)
                    <li class="list-group-item d-flex justify-content-between align-items-start flex-wrap">
                        <div>
                            <strong>{{ $erudit->nom }}</strong>
                            @if ($erudit->nationalite)
                                <span class="text-muted"> — {{ $erudit->nationalite }}</span>
                            @endif
                            @if ($erudit->biographie)
                                <p class="mb-0 small">{{ $erudit->biographie }}</p>
                            @endif
                        </div>

                        <!-- Bouton Modifier -->
                        <button type="button" class="btn btn-warning btn-sm mt-1 mt-md-0" data-bs-toggle="modal"
                            data-bs-target="#editEruditModal{{ $erudit->id }}">
                            Modifier
                        </button>

                        <!-- Modal de modification -->
                        <div class="modal fade" id="editEruditModal{{ $erudit->id }}" tabindex="-1"
                            aria-labelledby="editEruditModalLabel{{ $erudit->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('erudit.update', $erudit->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editEruditModalLabel{{ $erudit->id }}">
                                                Modifier l'Érudit
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="name{{ $erudit->id }}" class="form-label">Nom</label>
                                                <input type="text" class="form-control" name="name"
                                                    id="name{{ $erudit->id }}" value="{{ $erudit->nom }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nationalite{{ $erudit->id }}"
                                                    class="form-label">Nationalité</label>
                                                <input type="text" class="form-control" name="nationalite"
                                                    id="nationalite{{ $erudit->id }}"
                                                    value="{{ $erudit->nationalite }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="biographie{{ $erudit->id }}"
                                                    class="form-label">Biographie</label>
                                                <textarea class="form-control" name="biographie" id="biographie{{ $erudit->id }}">{{ $erudit->biographie }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Annuler</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Modal d'ajout -->
    <div class="modal fade" id="addEruditModal" tabindex="-1" aria-labelledby="addEruditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('erudit.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addEruditModalLabel">Ajouter un Érudit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" name="name" id="nom" required>
                        </div>
                        <div class="mb-3">
                            <label for="nationalite" class="form-label">Nationalité</label>
                            <input type="text" class="form-control" name="nationalite" id="nationalite">
                        </div>
                        <div class="mb-3">
                            <label for="biographie" class="form-label">Biographie</label>
                            <textarea class="form-control" name="biographie" id="biographie"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Ajouter</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
