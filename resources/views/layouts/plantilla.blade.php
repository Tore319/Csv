<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('titulo_head')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('inicio') }}">CSV</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if (auth()->guest())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                    @endif
                    @if (auth()->check())
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link">Logout</button>
                        </form>
                        @if (auth()->user()->rol == 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('csv.create') }}">Subir</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('csv.index') }}">Gestión</a>
                            </li>
                        @endif
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    
    @yield('contenido')

    <footer>
        <div class="container py-6">
            <div class="lc-block d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
                <div class="col-md-4">
                    <div editable="rich">
                        <p class="text-muted"> © 2025 Juanjo Torres</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>