@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h2 class="text-center mb-4">Choisissez les Versets à Traduire</h2>

        <form action="{{ route('traductions.storeVersets') }}" method="POST" enctype="multipart/form-data" id="traductionForm">
            @csrf

            <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Érudit</label>
                    <div class="px-4 py-2 bg-gray-200 rounded-md text-gray-900">{{ $erudit->nom }}</div>
                    <input type="hidden" name="erudit_id" value="{{ $erudit->id }}">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Langue</label>
                    <div class="px-4 py-2 bg-gray-100 rounded-md text-gray-900">{{ $langue }}</div>
                    <input type="hidden" name="langue" value="{{ $langue }}">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Sourate</label>
                    <div class="px-4 py-2 bg-gray-100 rounded-md text-gray-900">{{ $sourate->id }}
                        {{ $sourate->nom_arabe }} {{ $sourate->nom_transliteration }}</div>
                    <input type="hidden" name="sourate_id" value="{{ $sourate->id }}">
                </div>

                <div class="block text-gray-700 font-medium mb-1">
                    <button type="submit" class="btn btn-success">Soumettre la traduction</button>
                </div>

                <button type="button" class="btn btn-outline-primary" id="selectAllBtn">Tout sélectionner /
                    désélectionner</button>

                @if ($langue !== 'francais')
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <label class="form-label mb-0">Audio global pour tous :</label>
                        <input type="checkbox" class="form-check-input" id="applyGroupAudio">
                        <input type="file" class="form-control" name="audio_group" accept="audio/*" id="groupAudioFile">
                    </div>
                @endif
            </div>

            <div class="row" id="versetsContainer">
                @foreach ($versets as $verset)
                    <div class="col-md-6 col-lg-4 mb-4 verset-wrapper">
                        <div class="card shadow-sm h-100 verset-block">
                            <div class="card-body">
                                <div class="form-check mb-3">
                                    <input class="form-check-input verset-checkbox" type="checkbox"
                                        name="versets[{{ $verset->id }}][selected]" value="1"
                                        id="versetCheck{{ $verset->id }}" data-verset="{{ $verset->id }}">
                                    <label class="form-check-label fw-bold" for="versetCheck{{ $verset->id }}">
                                        {{ $verset->texte_arabe }}
                                        <span
                                            class="d-inline-flex align-items-center justify-content-center border border-primary rounded-circle text-primary"
                                            style="width: 40px; height: 40px; font-size: 1.2rem; font-family: 'Amiri', serif; font-weight: bold;">
                                            {{ convertToArabicNumerals($verset->numero) }}
                                        </span>
                                        <span class="badge bg-success">Verset {{ $verset->numero }}</span>
                                    </label>
                                </div>

                                <div class="verset-inputs d-none">
                                    @if ($langue === 'francais')
                                        <div class="mb-2">
                                            <label>Traduction écrite (optionnel)</label>
                                            <textarea class="form-control" name="versets[{{ $verset->id }}][texte]" rows="3"></textarea>
                                        </div>
                                    @endif

                                    <div class="mb-2">
                                        <label>Audio </label>
                                        <input type="file" class="form-control"
                                            name="versets[{{ $verset->id }}][audio]" accept="audio/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success">Soumettre la traduction</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllBtn = document.getElementById('selectAllBtn');
            const checkboxes = document.querySelectorAll('.verset-checkbox');
            const applyGroupAudio = document.getElementById('applyGroupAudio');
            const form = document.getElementById('traductionForm');
            let allSelected = false;

            // Toggle All Select/Deselect
            selectAllBtn.addEventListener('click', function() {
                if (applyGroupAudio && applyGroupAudio.checked) return;
                allSelected = !allSelected;

                checkboxes.forEach(cb => {
                    cb.checked = allSelected;
                    const inputs = cb.closest('.card-body').querySelector('.verset-inputs');
                    inputs.classList.toggle('d-none', !cb.checked);
                });
            });

            // Toggle input display per checkbox
            checkboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    const inputs = cb.closest('.card-body').querySelector('.verset-inputs');
                    inputs.classList.toggle('d-none', !cb.checked);
                });
            });

            // Disable individual selection if group audio is applied
            if (applyGroupAudio) {
                applyGroupAudio.addEventListener('change', function() {
                    const disable = this.checked;
                    checkboxes.forEach(cb => {
                        cb.disabled = disable;
                        const inputs = cb.closest('.card-body').querySelector('.verset-inputs');
                        if (disable) {
                            cb.checked = false;
                            inputs.classList.add('d-none');
                        }
                    });
                });
            }

            // Vérification avant soumission
            form.addEventListener('submit', function(e) {
                if (!applyGroupAudio?.checked) {
                    const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
                    if (checkedCount === 0) {
                        e.preventDefault();
                        alert("Veuillez sélectionner au moins un verset à traduire avant de soumettre.");
                    }
                }
            });
        });
    </script>
@endsection
