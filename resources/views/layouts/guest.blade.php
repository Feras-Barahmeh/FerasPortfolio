<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{ asset('guest/images/my-avatar.png') }}">
        <title>{{ config('app.name', 'FerasBarahmeh') }}</title>

        {{-- Fonts --}}
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        {{-- css --}}
        @include('layouts.guest.css-links')
        @stack('style')

        {{-- Scripts --}}
        <script src="{{ asset('guest/js/main.js') }}" defer></script>
        <script src="{{ assert('guest/js/all.min.js') }}" defer></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>
    </head>

    <body >
    {{ $slot }}
    </body>
</html>
