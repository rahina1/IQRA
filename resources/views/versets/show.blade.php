@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h3 class="text-center text-secondary fw-bold">📖 Verset #{{ $verset->numero }}</h3>

        <div class="card p-4 mt-3 shadow-lg bg-white rounded-lg">
            <p class="text-end text-primary" dir="rtl" style="font-size: 2rem; font-family: 'Amiri', serif;">
                {{ $verset->texte_arabe }}
            </p>
        </div>

        <div class="text-center mt-4">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-pill px-4">⬅ Retour</a>
        </div>
    </div>
@endsection
