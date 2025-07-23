<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

       

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Vite (Tailwind + JS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-cover bg-no-repeat bg-center min-h-screen" style=" background: url('https://static.vecteezy.com/system/resources/thumbnails/003/144/506/small/dark-purple-pink-gradient-blur-texture-vector.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center; overflow:hidden">

    <div class="min-h-screen">
        
    @if(View::hasSection('show_navigation'))
    @include('layouts.navigation')
@endif

        {{-- Page Heading --}}
        @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset

        {{-- Main Content --}}
        <main class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
              
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
