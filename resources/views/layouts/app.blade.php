<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Application Islamique</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        /* Appliquer un dégradé vert-blanc au navbar */
        .navbar-custom {
            background: linear-gradient(90deg, #ffffff, #075319);
        }

        /* Style du menu */
        .navbar-nav .nav-link {
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
            /* Texte en gras */
            font-size: 18px;
            /* Taille du texte */
            color: #000000;
            /* Couleur par défaut */
            margin-right: 15px;
            /* Espacement entre les éléments */
            transition: color 0.3s ease-in-out;
            /* Animation fluide */
        }

        /* Effet au survol */
        .navbar-nav .nav-link:hover {
            color: #ffffff;
            /* Devient blanc au survol */
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <!-- Barre de navigation avec dégradé -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <!-- Logo et Nom -->
            <a class="navbar-brand d-flex align-items-center" href="">
                <img src="{{ asset('images/logo2.png') }}" alt="Logo" height="90" class="me-2">

            </a>

            <!-- Bouton pour mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Liens du menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('sourates.index') }}">Sourates</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('traductions.index') }}">Traductions</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('hadiths.index') }}">Hadiths du Jour</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('cours.index') }}">Cours Islamiques</a></li>

                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-4">
        @yield('content')
    </main>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
