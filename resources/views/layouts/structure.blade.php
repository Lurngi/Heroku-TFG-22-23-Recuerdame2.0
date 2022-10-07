<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Recuérdame</title>
    <!-- <title>{{ config('app.name', 'Laravel') }}</title> -->

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!--Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Custom Stylesheets -->
    <link rel="stylesheet" href="/css/login.css">
    <link rel="stylesheet" href="/css/registro.css">
    <link rel="stylesheet" href="/css/styles.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm yellowbg">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <!-- TODO Cambiar el logo -->
                    <img class="logotipoMarca" src="img/Marca_recuerdame.png">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item btn">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar sesión') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item btn">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Registro') }}</a>
                                </li>
                            @endif
                            @else
                            <div class="container-fluid">
                            <!-- TODO 
                            <?php //if (Session::esCuidador() && Session::getIdPaciente() != null) { ?>
                                <a class="navbar-brand" href="verDatosPaciente.php?idPaciente=<?php //echo Session::getIdPaciente() ?>"><img class="logotipoMarca" src="public/img/Marca_recuerdame.png" /></a>
                            <?php //} ?>
                            -->
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <?php
                                        /* TODO
                                        if (isset($_SESSION['usuario'])) {
                                        $usuario = unserialize($_SESSION['usuario']);
                                        if ($usuario->getIniciales() != '') {
                                        ?>
                                            <div data-letters="<?php echo (isset($usuario) ? $usuario->getIniciales() : '') ?>"></div>
                                        <?php
                                        }
                                        }
                                        */
                                        ?>
                                    </div>
                                </div>
                                @if (Auth::user()->rol_id == 1)
                                <div class="btn">
                                    <a class="nav-link" href="{{ route('pacientes.index') }}"><i class="fa-solid fa-users"></i></a>
                                </div>
                                @endif
                                <div class="btn">
                                {{ Auth::user()->usuario }}
                                </div>
                                <li class="nav-item dropdown btn btn-outline-danger">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                        <i class="fa-solid fa-right-from-bracket"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            </div>
                           
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <footer class="mt-auto text-lg-start text-muted">
        <div class="p-2">
            <a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/"><img alt="Licencia Creative Commons" style="border-width:0" src="https://i.creativecommons.org/l/by-nc/4.0/88x31.png" /></a>
            <?php echo date('Y'); ?> Recuérdame2.0
        </div>
    </footer>
</body>
</html>
