<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Higa AgriBusiness Group Ltd IMS Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @if (file_exists(public_path('hot')) || file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="min-h-screen bg-slate-100 text-slate-900 antialiased">
@php
    $label = trim((string) (auth()->user()->name ?? auth()->user()->email ?? ''));
    $initial = $label !== '' ? \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($label, 0, 1)) : '?';
    $welcomeMessages = [
        'admin' => 'Real-time overview of maize processing operations across all modules.',
        'collection-officer' => 'Manage farmers, warehouses, and maize collections from suppliers.',
        'production-manager' => 'Track production batches, inventory, and processing efficiency.',
        'sales-team' => 'Monitor sales, payments, and customer orders.',
    ];
    $welcome = $welcomeMessages[$roleSlug] ?? $welcomeMessages['admin'];
    $kpiIcons = [
        'Farmers' => 'fa-users', 'Warehouses' => 'fa-warehouse', 'Collections' => 'fa-seedling', 'Maize Accepted' => 'fa-wheat-awn',
        'Raw Stock' => 'fa-boxes-stacked', 'Finished Stock' => 'fa-box-open', 'Production Batches' => 'fa-gears',
        'Production Efficiency' => 'fa-gauge-high', 'Wastage' => 'fa-trash-can', 'Products' => 'fa-cubes', 'Sales' => 'fa-receipt',
        'Sales Revenue' => 'fa-sack-dollar', 'Revenue' => 'fa-sack-dollar', 'Outstanding Balance' => 'fa-file-invoice-dollar',
        'Outstanding' => 'fa-file-invoice-dollar', 'Returns Quantity' => 'fa-rotate-left', 'Returns' => 'fa-rotate-left',
        'Payments Collected' => 'fa-wallet', 'Collected' => 'fa-wallet',
    ];
    $priorityLabels = ['Sales Revenue', 'Revenue', 'Payments Collected', 'Collected', 'Production Efficiency', 'Raw Stock', 'Outstanding Balance', 'Outstanding'];
    $heroKpis = [];
    foreach ($priorityLabels as $kpiLabel) {
        $found = collect($kpis)->firstWhere('label', $kpiLabel);
        if ($found && count($heroKpis) < 4) {
            $heroKpis[] = $found;
        }
    }
    if (count($heroKpis) < 4) {
        foreach ($kpis as $kpi) {
            if (count($heroKpis) >= 4) break;
            if (! in_array($kpi, $heroKpis, true)) $heroKpis[] = $kpi;
        }
    }
    $boardKpis = array_values(array_filter($kpis, fn ($kpi) => ! in_array($kpi, $heroKpis, true)));
    $yield = min($report['production_efficiency_percentage'] ?? 0, 100);
    $wastage = min($report['wastage_percentage'] ?? 0, max(0, 100 - $yield));
    $emptyPct = max(0, 100 - $yield - $wastage);
    $grad = "conic-gradient(#25633b 0% {$yield}%, #c97329 {$yield}% " . ($yield + $wastage) . "%, #e2e8f0 " . ($yield + $wastage) . "% 100%)";
@endphp
<div class="grid min-h-screen lg:grid-cols-[290px_1fr]">
    <aside class="hidden lg:flex lg:flex-col border-r border-slate-800 bg-slate-950 text-slate-100 p-5">
        <div class="rounded-xl border border-slate-800 bg-slate-900/60 p-3 mb-4">
            <img src="{{ asset('higalog.jpg') }}" alt="HigaGroup Logo" class="h-8 w-auto rounded-md">
        </div>
        <nav class="space-y-1">
            @foreach ($menuItems as $item)
                <a href="{{ $item['endpoint'] ?? $item['href'] ?? '#' }}"
                   class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ $activeModule === $item['slug'] ? 'bg-emerald-600/20 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fas {{ $item['icon'] ?? 'fa-circle' }} w-4 text-center {{ $activeModule === $item['slug'] ? 'text-amber-300' : 'text-slate-500 group-hover:text-amber-200' }}"></i>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>
        <a href="{{ route('profile.edit') }}" class="mt-5 rounded-xl border border-slate-800 bg-slate-900/60 p-3 flex items-center gap-3 hover:bg-slate-800 transition">
            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-amber-400 to-emerald-700 text-white grid place-items-center font-bold">{{ $initial }}</div>
            <div>
                <div class="text-sm font-semibold">{{ auth()->user()->name }}</div>
                <div class="text-xs text-slate-400">Edit profile</div>
            </div>
        </a>
        <div class="mt-auto pt-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full rounded-lg border border-rose-400/30 bg-rose-500/10 px-3 py-2.5 text-sm font-semibold text-rose-200 hover:bg-rose-500/20 transition">
                    <i class="fas fa-sign-out-alt mr-2"></i>Log out
                </button>
            </form>
        </div>
    </aside>

    <main class="p-4 sm:p-6 lg:p-8">
        <div class="mx-auto max-w-7xl space-y-5">
            <header class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-500">{{ \Illuminate\Support\Str::headline($roleSlug) }}</p>
                        <h1 class="mt-1 text-2xl font-bold text-slate-900">Welcome, {{ auth()->user()->name }}</h1>
                        <p class="mt-2 text-sm text-slate-600">{{ $welcome }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-600">
                            <i class="fas fa-calendar-day mr-1.5"></i>{{ now()->format('M d, Y') }}
                        </span>
                        <a href="{{ route('profile.edit') }}" class="rounded-full bg-emerald-600 px-4 py-2 text-xs font-semibold text-white hover:bg-emerald-700 transition">Profile</a>
                    </div>
                </div>
            </header>

            @if($dbError)
                <section class="rounded-xl border-l-4 border-rose-600 border border-rose-200 bg-rose-50 p-4">
                    <h3 class="text-rose-700 font-semibold"><i class="fas fa-exclamation-triangle mr-2"></i>Database Connection Error</h3>
                    <p class="mt-1 text-sm text-rose-700">{{ $dbError }}</p>
                    <p class="mt-2 text-xs text-rose-600">Check your <code>.env</code> and database reachability. For SQLite, run <code>php artisan migrate</code>.</p>
                </section>
            @endif

            <section class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                @foreach($heroKpis as $kpi)
                    <article class="rounded-2xl border border-slate-200 bg-gradient-to-br from-white to-slate-50 p-4 shadow-sm">
                        <p class="text-[11px] uppercase tracking-[0.14em] text-slate-500">
                            <i class="fas {{ $kpiIcons[$kpi['label']] ?? 'fa-chart-bar' }} mr-1.5 text-emerald-600"></i>{{ $kpi['label'] }}
                        </p>
                        <p class="mt-2 text-2xl font-bold text-slate-900">{{ $kpi['value'] }}</p>
                        <p class="mt-1 text-xs text-slate-500">{{ $kpi['sub'] }}</p>
                    </article>
                @endforeach
            </section>

            @if(count($boardKpis))
                <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="mb-3 flex items-center justify-between">
                        <h2 class="text-sm font-semibold text-slate-800">Operational Metrics</h2>
                        <span class="text-xs uppercase tracking-[0.12em] text-slate-500">{{ count($boardKpis) }} items</span>
                    </div>
                    <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                        @foreach($boardKpis as $kpi)
                            <article class="rounded-xl border border-slate-200 bg-slate-50/70 p-3">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-slate-500">
                                    <i class="fas {{ $kpiIcons[$kpi['label']] ?? 'fa-chart-bar' }} mr-1.5 text-emerald-600"></i>{{ $kpi['label'] }}
                                </p>
                                <p class="mt-1.5 text-lg font-bold text-slate-900">{{ $kpi['value'] }}</p>
                                <p class="mt-1 text-xs text-slate-500">{{ $kpi['sub'] }}</p>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

            @includeIf('dashboard.partials.' . match ($roleSlug) {
                'collection-officer' => 'collection-officer',
                'sales-team' => 'sales-team',
                'production-manager' => 'production-manager',
                default => 'admin',
            }, [
                'roleSlug' => $roleSlug,
                'recentCollections' => $recentCollections,
                'recentSales' => $recentSales,
                'report' => $report,
                'yield' => $yield,
                'wastage' => $wastage,
                'emptyPct' => $emptyPct,
                'grad' => $grad,
            ])
        </div>
    </main>
</div>
</body>
</html>

