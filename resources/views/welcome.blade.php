<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Higa AgriBusiness Group Ltd IMS') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="min-h-screen bg-gradient-to-b from-slate-50 via-white to-emerald-50 text-slate-900 antialiased">
    <header class="sticky top-0 z-40 border-b border-slate-200/70 bg-white/70 backdrop-blur">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between gap-4">
                <a href="{{ url('/') }}" class="flex items-center gap-3 rounded-xl px-2 py-1 hover:bg-slate-50">
                    <img src="{{ asset('higalog.jpg') }}" alt="HigaGroup Logo" class="h-9 w-9 rounded-xl object-cover" />
                    <span class="text-sm font-extrabold tracking-tight">
                        HIGA<span class="text-amber-500">GROUP</span>
                    </span>
                </a>

                @auth
                    <nav class="flex items-center gap-2">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-emerald-700">
                            <i class="fas fa-th-large"></i>
                            Dashboard
                        </a>
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50">
                            <i class="fas fa-user-circle"></i>
                            Profile
                        </a>
                    </nav>
                @else
                    <nav class="flex items-center gap-2">
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-emerald-700">
                                <i class="fas fa-sign-in-alt"></i>
                                Sign in
                            </a>
                        @endif
                    </nav>
                @endauth
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <section class="py-12 sm:py-16">
            <div class="grid items-center gap-10 lg:grid-cols-2">
                <div>
                    <div class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-4 py-2 text-xs font-extrabold tracking-widest text-emerald-700">
                        <i class="fas fa-seedling"></i>
                        IMS • Integrated Maize Operations
                    </div>

                    <h1 class="mt-5 text-4xl font-black tracking-tight sm:text-5xl">
                        Higa IMS for collection, production & finance
                    </h1>
                    <p class="mt-4 max-w-xl text-base leading-relaxed text-slate-600">
                        A modern operational workspace built for traceability—keep maize flow clean and readable from farm deliveries to sales and payments.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        @guest
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-bold text-white shadow-sm hover:bg-emerald-700">
                                    <i class="fas fa-shield-alt"></i>
                                    Secure sign in
                                </a>
                            @endif
                        @endguest

                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-800 hover:bg-slate-50">
                            <i class="fas fa-chart-line"></i>
                            See operational overview
                        </a>
                    </div>

                    <div class="mt-8 grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <div class="rounded-2xl border border-slate-200 bg-white/70 p-4 shadow-sm">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                                    <i class="fas fa-wheat-awn"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-extrabold">Collections & quality</p>
                                    <p class="text-xs font-semibold text-slate-500">Accepted/rejected with traceability</p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-slate-200 bg-white/70 p-4 shadow-sm">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-700">
                                    <i class="fas fa-industry"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-extrabold">Production batches</p>
                                    <p class="text-xs font-semibold text-slate-500">Efficiency & wastage monitoring</p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-slate-200 bg-white/70 p-4 shadow-sm">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-50 text-sky-700">
                                    <i class="fas fa-warehouse"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-extrabold">Inventory visibility</p>
                                    <p class="text-xs font-semibold text-slate-500">Raw + finished stock across locations</p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-slate-200 bg-white/70 p-4 shadow-sm">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-50 text-violet-700">
                                    <i class="fas fa-receipt"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-extrabold">Sales & finance</p>
                                    <p class="text-xs font-semibold text-slate-500">Invoices, returns, payments</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </section>

        <footer class="pb-10 pt-2 text-center text-xs font-semibold text-slate-500">
            © 2026 Higa Agribusiness Group LTD IMS. All rights reserved.
        </footer>
    </main>
</body>
</html>

