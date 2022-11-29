<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Root-911</title>
    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

</head>
<body>
    <header>
        @include('root.nav')
    </header>

    <div class="container">
        
        @yield('content')        

    </div>
</body>
</html>