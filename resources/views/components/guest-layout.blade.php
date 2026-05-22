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
<div class="layout">
    <section class="left-panel">
        <div class="illustration">
            <div class="user-figure">
                <div class="avatar" aria-hidden="true">
                    <img src="{{ asset('higalog.jpg') }}" alt="Higa" class="h-8 w-auto object-contain" />
                </div>
                <div class="text-bars">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <div class="desk"></div>
            <div class="desk-row">
                <div class="desk-box"></div>
                <div class="desk-box" style="background:linear-gradient(180deg,#e8f3e6,#d6ecd1)"></div>
            </div>
            <p class="subtitle" style="margin-top:1.25rem;font-size:0.95rem;">
                Higa IMS Dashboard Login
            </p>
            <p class="subtitle" style="margin-top:0.25rem;opacity:0.95;">
                Secure access for administrators and operational teams.
            </p>
        </div>
    </section>

    <section class="right-panel">
        <div class="login-card">
            {{ $slot }}
        </div>
    </section>
</div>
</body>
</html>

