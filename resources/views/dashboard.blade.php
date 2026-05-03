<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Higa AgriBusiness Group Ltd IMS Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @if (file_exists(public_path('hot')) || file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/dashboard.css'])
    @else
        <style>{!! file_get_contents(resource_path('css/dashboard.css')) !!}</style>
    @endif
</head>
<body>
<div class="shell">
    <aside class="sidebar">
        <div class="brand">
            <img src="{{ asset('higalog.jpg') }}" alt="HigaGroup Logo" style="max-height:32px;width:auto;border-radius:6px;">
        </div>

<nav class="menu">
            @foreach ($menuItems as $item)
                <a href="{{ $item['endpoint'] ?? $item['href'] ?? '#' }}" class="{{ $activeModule === $item['slug'] ? 'active' : '' }}">
                    <i class="fas {{ $item['icon'] ?? 'fa-circle' }}"></i>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <a href="{{ route('profile.edit') }}" class="user-box-link" title="Open profile">
            <div class="avatar" title="{{ auth()->user()->name }}">
                @php
                    $label = trim((string) (auth()->user()->name ?? auth()->user()->email ?? ''));
                    $initial = $label !== '' ? \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($label, 0, 1)) : '?';
                @endphp
                {{ $initial }}
            </div>
            <div>
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role"><i class="fas fa-pen" style="font-size:0.65rem;margin-right:3px"></i>Edit profile</div>
            </div>
        </a>

        <div class="spacer"></div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout-btn" type="submit">
                <i class="fas fa-sign-out-alt"></i> Log out
            </button>
        </form>
    </aside>

    <main class="main">
        <div class="topbar">
            <input class="search" type="search" placeholder="Search...">
            <div class="topbar-right">
                <div class="top-icons" aria-label="Quick actions">
                    <span class="icon-btn" title="Notifications" role="img" aria-label="Notifications">
                        <i class="fas fa-bell"></i>
                    </span>
                </div>
                <div class="topbar-account">
                    <a href="{{ route('profile.edit') }}" class="topbar-text-link">
                        <i class="fas fa-user-circle"></i> Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="logout-inline-dash">
                        @csrf
                        <button type="submit" class="topbar-text-btn">
                            <i class="fas fa-power-off"></i> Log out
                        </button>
                    </form>
                </div>
            </div>
        </div>

<section class="welcome">
            @php
                $welcomeMessages = [
                    'admin' => 'Real-time overview of maize processing operations across all modules.',
                    'collection-officer' => 'Manage farmers, warehouses, and maize collections from suppliers.',
                    'production-manager' => 'Track production batches, inventory, and processing efficiency.',
                    'sales-team' => 'Monitor sales, payments, and customer orders.',
                ];
                $welcome = $welcomeMessages[$roleSlug] ?? $welcomeMessages['admin'];
            @endphp
            <h1><i class="fas fa-wave-square" style="color:var(--brand-green)"></i> Welcome, {{ auth()->user()->name }}</h1>
            <p><i class="fas fa-chart-pie" style="margin-right:6px;color:var(--muted)"></i>{{ $welcome }}</p>
        </section>

        @if($dbError)
        <section class="card" style="border-left:4px solid #dc2626;">
            <h3 style="color:#dc2626;margin-top:0;"><i class="fas fa-exclamation-triangle"></i> Database Connection Error</h3>
            <p>{{ $dbError }}</p>
            <p class="sub">Please check your <code>.env</code> file and ensure your database server is reachable. If using SQLite, run <code>php artisan migrate</code>.</p>
        </section>
        @endif

        <section class="cards">
            @foreach($kpis as $kpi)
                <article class="card">
                    <h4><i class="fas fa-chart-bar"></i> {{ $kpi['label'] }}</h4>
                    <p>{{ $kpi['value'] }}</p>
                    <div class="kpi-sub"><i class="fas fa-info-circle"></i> {{ $kpi['sub'] }}</div>
                </article>
            @endforeach
        </section>

<section class="content-grid">
            <div class="left-stack">
                {{-- Collections panel: show for collection-officer and admin --}}
                @if(in_array($roleSlug, ['collection-officer', 'admin']))
                <section class="card table-card">
                    <h3 class="panel-title"><i class="fas fa-seedling"></i> Recent Maize Collections</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Farmer</th>
                                <th>Location</th>
                                <th>Date</th>
                                <th>Accepted (kg)</th>
                                <th>Rejected (kg)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentCollections as $c)
                            <tr>
                                <td>{{ optional($c->farmer)->name ?? '-' }}</td>
                                <td>{{ optional($c->location)->name ?? '-' }}</td>
                                <td>{{ $c->collection_date?->format('Y-m-d') ?? '-' }}</td>
                                <td>{{ number_format($c->accepted_quantity ?? 0, 3) }}</td>
                                <td>{{ number_format($c->quantity_rejected ?? 0, 3) }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="5" style="text-align:center;color:var(--muted);padding:20px;">No collections yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </section>
                @endif

                {{-- Sales panel: show for sales-team and admin --}}
                @if(in_array($roleSlug, ['sales-team', 'admin']))
                <section class="card table-card">
                    <h3 class="panel-title"><i class="fas fa-receipt"></i> Recent Sales</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Amount (RWF)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentSales as $s)
                            <tr>
                                <td>{{ $s->invoice_number }}</td>
                                <td>{{ $s->customer_name }}</td>
                                <td>{{ $s->sale_date?->format('Y-m-d') ?? '-' }}</td>
                                <td>{{ number_format($s->total_amount ?? 0, 2) }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" style="text-align:center;color:var(--muted);padding:20px;">No sales yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </section>
                @endif
            </div>

            <div class="right-stack">
                @php
                    $yield = min($report['production_efficiency_percentage'] ?? 0, 100);
                    $wastage = min($report['wastage_percentage'] ?? 0, max(0, 100 - $yield));
                    $emptyPct = max(0, 100 - $yield - $wastage);
                    $grad = "conic-gradient(var(--brand-green-dark) 0% {$yield}%, var(--brand-orange) {$yield}% " . ($yield + $wastage) . "%, #e5e7eb " . ($yield + $wastage) . "% 100%)";
                @endphp

                {{-- Production panel: show for production-manager and admin --}}
                @if(in_array($roleSlug, ['production-manager', 'admin']))
                <article class="card">
                    <h3 class="panel-title"><i class="fas fa-chart-pie"></i> Production Efficiency</h3>
                    <div class="status">
                        <div class="donut-wrap">
                            <div class="donut" style="background: {{ $grad }};" aria-hidden="true">
                                <div class="donut-inner">{{ number_format($yield, 0) }}%</div>
                            </div>
                        </div>
                        <div class="legend">
                            <span><i class="dot" style="background:#3f7f2d"></i> Yield: {{ number_format($yield, 1) }}%</span>
                            <span><i class="dot" style="background:#e08b2d"></i> Wastage: {{ number_format($wastage, 1) }}%</span>
                            @if($emptyPct > 0)
                            <span><i class="dot" style="background:#e5e7eb"></i> Other: {{ number_format($emptyPct, 1) }}%</span>
                            @endif
                        </div>
                    </div>
                </article>

                <article class="card">
                    <h3 class="panel-title"><i class="fas fa-warehouse"></i> Raw Stock by Location</h3>
                    <div class="shipment-list">
                        @forelse($report['stock_levels']['raw'] ?? [] as $stock)
                        <div class="shipment">
                            <div class="thumb"><i class="fas fa-warehouse"></i></div>
                            <div>
                                <b>Location #{{ $stock->location_id }}</b><br>
                                <small>Raw Maize</small>
                            </div>
                            <div class="gain">{{ number_format($stock->quantity ?? 0, 3) }} kg</div>
                        </div>
                        @empty
                        <div style="text-align:center;color:var(--muted);padding:16px;">No raw stock data.</div>
                        @endforelse
                    </div>
                </article>

                <article class="card">
                    <h3 class="panel-title"><i class="fas fa-tractor"></i> Top Supplier Performance</h3>
                    <div class="shipment-list">
                        @forelse($report['supplier_performance'] ?? [] as $sp)
                        <div class="shipment">
                            <div class="thumb"><i class="fas fa-user"></i></div>
                            <div>
                                <b>Farmer #{{ $sp->farmer_id }}</b><br>
                                <small>Accepted: {{ number_format($sp->total_accepted ?? 0, 3) }} kg</small>
                            </div>
                            <div class="gain">{{ number_format($sp->total_rejected ?? 0, 3) }} rejected</div>
                        </div>
                        @empty
                        <div style="text-align:center;color:var(--muted);padding:16px;">No supplier data.</div>
                        @endforelse
                    </div>
                </article>
                @endif
            </div>
        </section>
    </main>
</div>
</body>
</html>

