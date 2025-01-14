<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Recuérdame</title>
    <link rel="icon" type="image/x-icon" href="/img/logo_recuerdame.png">
    <!-- <title>{{ config('app.name', 'Laravel') }}</title> -->

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=Nunito">

    <!-- Custom Stylesheets -->
    <link rel="stylesheet" href="/css/login.css">
    <link rel="stylesheet" href="/css/dropzone.css">
    <link rel="stylesheet" href="/css/registro.css">
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/css/dropzone.css">
    <link rel="stylesheet" href="/css/imagen.css">
    <style type ="text/css">
        .modal{
            backdrop-filter: blur(1px) saturate(120%);
        }
    </style>
    @stack('styles')

</head>
<body class="lightbluebg">
    <div id="app">
        @include('layouts.header')
        @include('layouts.navbar')
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @include('layouts.footer')
</body>
@stack('scripts')
</html>
