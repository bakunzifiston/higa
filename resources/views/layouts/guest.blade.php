<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind (CDN) for login-only pages -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- React placeholder (for future login enhancements) -->
    <script crossorigin src="https://unpkg.com/react@18/umd/react.production.min.js"></script>
    <script crossorigin src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js"></script>

    {{-- Guest/login pages should only load auth-login.css (no dashboard.css). --}}
    @php
        $authCssPath = resource_path('css/auth-login.css');
        $authCss = is_file($authCssPath) ? file_get_contents($authCssPath) : '';
    @endphp
    @if(empty($authCss))
        <!-- auth-login.css missing; no inline CSS injected -->
    @else
        <style>{!! $authCss !!}</style>
    @endif
</head>
<body>

<div class="login-card" style="max-width:420px;margin:24px auto 0 auto;padding:28px;">
    <div class="text-center mb-5">
        <div class="flex flex-col items-center">
            <div class="relative">
                <img src="{{ asset('higalog.jpg') }}" alt="Higa" class="h-14 w-auto object-contain drop-shadow" />
                <div class="absolute -bottom-2 left-1/2 -translate-x-1/2 w-20 h-1 rounded-full bg-emerald-600/20"></div>
            </div>

            <div class="mt-3 flex items-center gap-2">
                <i class="fa-solid fa-shield-halved text-emerald-700"></i>
                <h1 class="text-lg font-semibold">Higa IMS Dashboard</h1>
            </div>

            <p class="text-sm text-gray-600 mt-1">Secure access for administrators and operational teams.</p>
        </div>
    </div>

    {{ $slot }}
</div>
</body>
</html>


