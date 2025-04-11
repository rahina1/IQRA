@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h1 class="text-center text-primary fw-bold"> Le Noble Coran </h1>

        <!-- Barre de recherche -->
        <div class="container py-3">
            <input type="text" id="searchSourate" class="form-control" placeholder="🔍 Rechercher une sourate..." />
        </div>

        <div id="sourateList">
            <div class="row">
                @foreach ($sourates as $sourate)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-lg rounded-lg border-0 hover:scale-105 transition-all duration-300">
                            <div class="card-body text-center">
                                <h5 class="card-title text-success fw-bold">
                                    Sourate {{ $sourate->id }} - {{ convertToArabicNumerals($sourate->id) }}
                                </h5>
                                <p class="text-dark" style="font-size: 1.3rem;">{{ $sourate->nom_arabe }}
                                    ({{ $sourate->nom_transliteration }})
                                </p>
                                <a href="{{ route('sourates.show', $sourate->id) }}"
                                    class="btn btn-outline-primary btn-lg rounded-pill"> Lire</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>


    </div>

    <script>
        document.getElementById("searchSourate").addEventListener("input", function() {
            let query = this.value;

            fetch("{{ route('sourates.search') }}?query=" + query)
                .then(response => response.json())
                .then(data => {
                    let resultHTML = '<div class="row">';

                    data.forEach(sourate => {
                        resultHTML += `
                            <div class="col-md-4 mb-4">
                                <div class="card shadow-lg rounded-lg border-0 hover:scale-105 transition-all duration-300">
                                    <div class="card-body text-center">
                                        <h5 class="card-title text-success fw-bold">
                                            📜 Sourate ${sourate.id} - ${convertToArabicNumerals(sourate.id)}
                                        </h5>
                                        <p class="text-dark" style="font-size: 1.3rem;">${sourate.nom_arabe} (${sourate.nom_transliteration})</p>
                                        <a href="/sourates/${sourate.id}" class="btn btn-outline-primary btn-lg rounded-pill">📖 Lire</a>
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    resultHTML += '</div>';
                    document.getElementById("sourateList").innerHTML = resultHTML;
                });
        });

        function convertToArabicNumerals(number) {
            const western = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            const arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

            return number.toString().replace(/[0123456789]/g, d => arabic[d]);
        }
    </script>
@endsection
