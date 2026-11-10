<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'QR Attendance System') }}</title>
        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="min-vh-100 bg-light">
            @include('layouts.navigation')
            <!-- Page Heading -->
            @hasSection('header')
            <header class="bg-white shadow-sm mb-4">
                <div class="container py-4">
                    @yield('header')
                </div>
            </header>
            @endif
            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>
        <!-- Bootstrap 5 JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>