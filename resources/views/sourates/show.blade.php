@extends('layouts.app')

@section('content')
    <div class="container py-5">

        <h2 class="text-center text-dark fw-bold">Sourate {{ $sourate->id }} - {{ convertToArabicNumerals($sourate->id) }} :
            {{ $sourate->nom_arabe }} ({{ $sourate->nom_transliteration }})</h2>

        <!-- Affichage de Bismillah sauf pour la Sourate 9 (At-Tawba) -->
        @if ($sourate->id != 9)
            <p class="text-center text-success mt-3" style="font-size: 1.8rem; font-family: 'Amiri', serif;">
                ﷽
            </p>
        @endif

        <!-- Barre de recherche -->
        <div class="container py-3">
            <input type="text" id="searchVerset" class="form-control" placeholder="🔍 Rechercher un verset..." />
        </div>

        <div class="list-group mt-4">
            @foreach ($versets as $verset)
                <div class="list-group-item bg-light shadow-sm rounded-lg d-flex align-items-center">
                    <p class="text-end text-primary flex-grow-1" dir="rtl"
                        style="font-size: 2rem; font-family: 'Amiri', serif;">
                        {{ $verset->texte_arabe }}
                        <span
                            class="d-inline-flex align-items-center justify-content-center border border-success rounded-circle text-success"
                            style="width: 40px; height: 40px; font-size: 1.2rem; font-family: 'Amiri', serif; font-weight: bold;">
                            {{ convertToArabicNumerals($verset->numero) }}
                        </span>
                    </p>
                </div>
            @endforeach
        </div>


    </div>
    <script>
        document.getElementById("searchVerset").addEventListener("input", function() {
            let query = this.value;
            let sourateId = {{ $sourate->id }};

            fetch(`/sourates/${sourateId}/search?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    let resultHTML = '<div class="list-group mt-4">';

                    data.forEach(verset => {
                        resultHTML += `
                            <div class="list-group-item bg-light shadow-sm rounded-lg d-flex align-items-center">
                                <p class="text-end text-primary flex-grow-1" dir="rtl" style="font-size: 2rem; font-family: 'Amiri', serif;">
                                    ${verset.texte_arabe}
                                    <span class="d-inline-flex align-items-center justify-content-center border border-warning rounded-circle text-warning"
                                          style="width: 40px; height: 40px; font-size: 1.2rem; font-family: 'Amiri', serif; font-weight: bold;">
                                        ${convertToArabicNumerals(verset.numero)}
                                    </span>
                                </p>
                            </div>
                        `;
                    });

                    resultHTML += '</div>';
                    document.getElementById("versetList").innerHTML = resultHTML;
                });
        });

        function convertToArabicNumerals(number) {
            const western = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            const arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

            return number.toString().replace(/[0123456789]/g, d => arabic[d]);
        }
    </script>
@endsection
