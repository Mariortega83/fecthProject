<!doctype html>
<html lang="es" class="h-100" data-bs-theme="auto">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#712cf9">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="url-base" content="{{ url('') }}">

    <title>Canciones</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="{{ url('assets/css/style.css') }}" rel="stylesheet">

    <script>
        window.isAuthenticated = @json(auth() -> check());
    </script>
    <style>
        .alert {
            display: none;
            opacity: 1;
            transition: opacity 0.5s ease;
        }
    </style>
</head>

<body class="d-flex flex-column h-100">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Spotify') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto"></ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto" id="userContent">
                    <!-- User content will be dynamically loaded here -->
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="flex-shrink-0">
        <div class="container">
            <h1 class="mt-5">Canciones</h1>
            <p class="lead">Spotify, sube tu canción ya de ya</p>

            @auth
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal" data-url="/song">
                Agregar Canción
            </button>
            @endauth

            <!-- Elemento para mostrar mensajes -->
            <div id="message">
                <div class="alert alert-success" role="alert" id="songSuccess">Todo ha salido como se esperaba.</div>
                <div class="alert alert-danger" role="alert" id="songError">A ocurrido un error.</div>
            </div>

            <div id="content" class="mt-5 mb-5 d-flex flex-wrap gap-3 justify-content-space-evenly">
                <!-- Songs content will be dynamically loaded here -->
            </div>

            <nav>
                <ul class="pagination" id="paginationContent">
                    <!-- Pagination content will be dynamically loaded here -->
                </ul>
            </nav>
        </div>
    </main>

    <!-- Modals -->
    @include('modal')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="{{ url('src/js/script.js?random=' . rand(1,1000)) }}" type="module"></script>

</body>

</html>