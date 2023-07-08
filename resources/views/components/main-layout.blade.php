<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{ asset('images/sksu1.png') }}" />
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->

           @wireUiScripts
           @vite(['resources/css/app.css', 'resources/js/app.js'])

           @livewireStyles
           @stack('scripts')
    </head>
    <body class="antialiased">
        <div class="bg-white p-4 rounded-lg">
            {{ $slot }}
          </div>
        <x-dialog z-index="z-50" blur="md" align="center" />
        @livewireScripts
        @yield('scripts')
        @livewire('notifications')
    </body>

</html>
