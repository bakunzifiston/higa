<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @if (file_exists(public_path('hot')) || file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/dashboard.css'])
    @else
        <style>{!! file_get_contents(resource_path('css/dashboard.css')) !!}</style>
    @endif

    @if (file_exists(resource_path('css/auth-login.css')))
        <style>{!! file_get_contents(resource_path('css/auth-login.css')) !!}</style>
    @endif
</head>
<body>
<div class="shell" style="grid-template-columns: 1fr;">
    <main class="main" style="display:grid; place-items:center;">
        <div class="login-page-wrap">
            {{ $slot }}
        </div>
    </main>
</div>
</body>
</html>

