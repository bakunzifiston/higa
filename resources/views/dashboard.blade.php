<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Higa AgriBusiness Group Ltd — Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
:root {
    --brand: #5f9e3d;
    --brand-dark: #3f7f2d;
    --brand-green: #5f9e3d;
    --brand-green-dark: #3f7f2d;
    --brand-orange: #e08b2d;
    --bg: #f5f7fb;
    --card: #ffffff;
    --text: #1e293b;
    --muted: #64748b;
    --line: #e2e8f0;
    --danger: #dc2626;
}

* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    font-family: Arial, Helvetica, sans-serif;
    background: var(--bg);
    color: var(--text);
}

.shell { display: flex; min-height: 100vh; }

/* ── SIDEBAR ── */
.sidebar {
    width: 260px;
    background: #fff;
    border-right: 1px solid var(--line);
    padding: 20px;
    display: flex;
    flex-direction: column;
    position: sticky;
    top: 0;
    height: 100vh;
    overflow-y: auto;
}

.brand {
    font-size: 1.6rem;
    font-weight: 700;
    color: var(--brand-dark);
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.menu { display: flex; flex-direction: column; gap: 8px; }

.menu a {
    text-decoration: none;
    color: var(--text);
    padding: 12px 14px;
    border-radius: 12px;
    transition: .3s;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: .93rem;
}

.menu a:hover,
.menu a.active { background: var(--brand); color: #fff; }

.spacer { flex: 1; }

.user-box-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 0;
    border-top: 1px solid var(--line);
    margin-top: 12px;
    margin-bottom: 12px;
    text-decoration: none;
    color: inherit;
    transition: opacity .2s;
}

.user-box-link:hover { opacity: .75; }

.avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: var(--brand);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1rem;
    flex-shrink: 0;
}

.user-name { font-weight: 600; font-size: .9rem; }
.user-role { font-size: .75rem; color: var(--muted); }

.logout-btn {
    width: 100%;
    border: none;
    background: var(--danger);
    color: #fff;
    padding: 12px;
    border-radius: 12px;
    cursor: pointer;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: opacity .2s;
}

.logout-btn:hover { opacity: .88; }

/* ── MAIN ── */
.main { flex: 1; padding: 24px; overflow-x: hidden; }

/* ── TOPBAR ── */
.topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    gap: 15px;
    flex-wrap: wrap;
}

.search {
    padding: 10px 14px 10px 36px;
    border: 1px solid var(--line);
    border-radius: 10px;
    font-size: .9rem;
    background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' fill='%2364748b' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398l3.85 3.85a1 1 0 0 0 1.415-1.415l-3.868-3.833zm-5.242 1.156a5 5 0 1 1 0-10 5 5 0 0 1 0 10z'/%3E%3C/svg%3E") no-repeat 12px center;
    width: 260px;
    transition: border-color .2s;
}

.search:focus { outline: none; border-color: var(--brand); }

.topbar-right {
    display: flex;
    align-items: center;
    gap: 18px;
}

.top-icons { display: flex; gap: 12px; }

.icon-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--muted);
    cursor: pointer;
    transition: background .2s;
}

.icon-btn:hover { background: var(--line); color: var(--text); }

.topbar-account {
    display: flex;
    align-items: center;
    gap: 14px;
}

.topbar-text-link {
    text-decoration: none;
    color: var(--muted);
    font-size: .9rem;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: color .2s;
}

.topbar-text-link:hover { color: var(--brand); }

.topbar-text-btn {
    border: none;
    background: none;
    color: var(--muted);
    font-size: .9rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 0;
    transition: color .2s;
}

.topbar-text-btn:hover { color: var(--danger); }

/* ── WELCOME BANNER ── */
.welcome {
    background: #fff;
    border-radius: 20px;
    padding: 24px 28px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,.05);
    border-left: 4px solid var(--brand);
}

.welcome h1 {
    font-size: 1.35rem;
    font-weight: 700;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.welcome p { color: var(--muted); font-size: .93rem; }

/* ── DB ERROR CARD ── */
.card-error {
    background: #fff;
    border-radius: 20px;
    padding: 24px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,.05);
    border-left: 4px solid var(--danger);
}

.card-error h3 { color: var(--danger); margin-bottom: 8px; }

/* ── KPI CARDS GRID ── */
.kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 18px;
    margin-bottom: 24px;
}

.kpi-card {
    background: #fff;
    border-radius: 20px;
    padding: 22px 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,.05);
    border-top: 3px solid var(--brand);
}

.kpi-card h4 {
    font-size: .8rem;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: var(--muted);
    font-weight: 600;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 7px;
}

.kpi-card p {
    font-size: 1.9rem;
    font-weight: 700;
    color: var(--brand-dark);
    line-height: 1;
    margin-bottom: 8px;
}

.kpi-sub {
    font-size: .78rem;
    color: var(--muted);
    display: flex;
    align-items: center;
    gap: 5px;
}

/* ── CONTENT GRID ── */
.content-grid {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 20px;
    align-items: start;
}

.left-stack, .right-stack {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* ── CARD ── */
.card {
    background: #fff;
    border-radius: 20px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,.05);
}

.panel-title {
    font-size: 1rem;
    font-weight: 700;
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--text);
}

.panel-title i { color: var(--brand-green-dark); }

/* ── TABLE ── */
.table-card { overflow: hidden; }

table { width: 100%; border-collapse: collapse; }

th {
    background: #f8fafc;
    padding: 12px 14px;
    text-align: left;
    font-size: .8rem;
    text-transform: uppercase;
    letter-spacing: .04em;
    color: var(--muted);
    font-weight: 600;
}

td {
    padding: 13px 14px;
    border-top: 1px solid var(--line);
    font-size: .88rem;
}

/* ── DONUT CHART ── */
.status {
    display: flex;
    align-items: center;
    gap: 24px;
    flex-wrap: wrap;
}

.donut-wrap { display: flex; justify-content: center; }

.donut {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.donut-inner {
    width: 78px;
    height: 78px;
    border-radius: 50%;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.1rem;
    color: var(--brand-dark);
}

.legend {
    display: flex;
    flex-direction: column;
    gap: 10px;
    font-size: .85rem;
    color: var(--text);
}

.legend span { display: flex; align-items: center; gap: 8px; }

.dot {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    font-style: normal;
}

/* ── SHIPMENT / LIST ITEMS ── */
.shipment-list { display: flex; flex-direction: column; gap: 14px; }

.shipment {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 12px 14px;
    background: #f8fafc;
    border-radius: 12px;
    font-size: .88rem;
}

.shipment .thumb {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: var(--brand);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}

.shipment > div:nth-child(2) { flex: 1; line-height: 1.5; }

.shipment b { font-weight: 600; }

.shipment small { color: var(--muted); font-size: .78rem; }

.gain {
    font-weight: 700;
    color: var(--brand-dark);
    white-space: nowrap;
    font-size: .85rem;
}

.sub { font-size: .82rem; color: var(--muted); margin-top: 2px; }

code {
    background: #f1f5f9;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: .82rem;
}

@media (max-width: 1100px) {
    .content-grid { grid-template-columns: 1fr; }
}

@media (max-width: 900px) {
    .sidebar { display: none; }
    .main { padding: 15px; }
    .search { width: 180px; }
}
    </style>
</head>
<body>
<div class="shell">

    {{-- ── SIDEBAR ── --}}
    <aside class="sidebar">
        <div class="brand">
            <img src="{{ asset('higalog.jpg') }}" alt="HigaGroup Logo"
                 style="max-height:32px;width:auto;border-radius:6px;">
        </div>

        <nav class="menu">
            @foreach ($menuItems as $item)
                <a href="{{ $item['endpoint'] ?? $item['href'] ?? '#' }}"
                   class="{{ $activeModule === $item['slug'] ? 'active' : '' }}">
                    <i class="fas {{ $item['icon'] ?? 'fa-circle' }}"></i>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="spacer"></div>

        <a href="{{ route('profile.edit') }}" class="user-box-link" title="Open profile">
            <div class="avatar" title="{{ auth()->user()->name }}">
                @php
                    $label   = trim((string) (auth()->user()->name ?? auth()->user()->email ?? ''));
                    $initial = $label !== '' ? \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($label, 0, 1)) : '?';
                @endphp
                {{ $initial }}
            </div>
            <div>
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role"><i class="fas fa-pen" style="font-size:.65rem;margin-right:3px"></i> Edit profile</div>
            </div>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout-btn" type="submit">
                <i class="fas fa-sign-out-alt"></i> Log out
            </button>
        </form>
    </aside>

    {{-- ── MAIN ── --}}
    <main class="main">

        {{-- TOPBAR --}}
        <div class="topbar">
            <input class="search" type="search" placeholder="Search...">
            <div class="topbar-right">
                <div class="top-icons">
                    <span class="icon-btn" title="Notifications" aria-label="Notifications">
                        <i class="fas fa-bell"></i>
                    </span>
                </div>
                <div class="topbar-account">
                    <a href="{{ route('profile.edit') }}" class="topbar-text-link">
                        <i class="fas fa-user-circle"></i> Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="topbar-text-btn">
                            <i class="fas fa-power-off"></i> Log out
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- WELCOME BANNER --}}
        <section class="welcome">
            @php
                $welcomeMessages = [
                    'admin'              => 'Real-time overview of maize processing operations across all modules.',
                    'collection-officer' => 'Manage farmers, warehouses, and maize collections from suppliers.',
                    'production-manager' => 'Track production batches, inventory, and processing efficiency.',
                    'sales-team'         => 'Monitor sales, payments, and customer orders.',
                ];
                $welcome = $welcomeMessages[$roleSlug] ?? $welcomeMessages['admin'];
            @endphp
            <h1>
                <i class="fas fa-wave-square" style="color:var(--brand-green)"></i>
                Welcome, {{ auth()->user()->name }}
            </h1>
            <p><i class="fas fa-chart-pie" style="margin-right:6px;color:var(--muted)"></i>{{ $welcome }}</p>
        </section>

        {{-- DB ERROR --}}
        @if($dbError)
        <div class="card-error">
            <h3><i class="fas fa-exclamation-triangle"></i> Database Connection Error</h3>
            <p>{{ $dbError }}</p>
            <p class="sub" style="margin-top:8px;">
                Please check your <code>.env</code> file and ensure your database server is reachable.
                If using SQLite, run <code>php artisan migrate</code>.
            </p>
        </div>
        @endif

        {{-- KPI CARDS --}}
        <div class="kpi-grid">
            @foreach($kpis as $kpi)
                <div class="kpi-card">
                    <h4><i class="fas fa-chart-bar"></i> {{ $kpi['label'] }}</h4>
                    <p>{{ $kpi['value'] }}</p>
                    <div class="kpi-sub"><i class="fas fa-info-circle"></i> {{ $kpi['sub'] }}</div>
                </div>
            @endforeach
        </div>

        {{-- CONTENT GRID --}}
        <div class="content-grid">

            {{-- LEFT: tables --}}
            <div class="left-stack">

                @if(in_array($roleSlug, ['collection-officer', 'admin']))
                <div class="card table-card">
                    <h3 class="panel-title">
                        <i class="fas fa-seedling"></i> Recent Maize Collections
                    </h3>
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
                            <tr>
                                <td colspan="5" style="text-align:center;color:var(--muted);padding:28px;">
                                    <i class="fas fa-folder-open" style="font-size:1.6rem;display:block;margin-bottom:8px;color:#cbd5e1"></i>
                                    No collections yet.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @endif

                @if(in_array($roleSlug, ['sales-team', 'admin']))
                <div class="card table-card">
                    <h3 class="panel-title">
                        <i class="fas fa-receipt"></i> Recent Sales
                    </h3>
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
                            <tr>
                                <td colspan="4" style="text-align:center;color:var(--muted);padding:28px;">
                                    <i class="fas fa-folder-open" style="font-size:1.6rem;display:block;margin-bottom:8px;color:#cbd5e1"></i>
                                    No sales yet.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @endif

            </div>

            {{-- RIGHT: charts & lists --}}
            <div class="right-stack">

                @if(in_array($roleSlug, ['production-manager', 'admin']))

                @php
                    $yield    = min($report['production_efficiency_percentage'] ?? 0, 100);
                    $wastage  = min($report['wastage_percentage'] ?? 0, max(0, 100 - $yield));
                    $emptyPct = max(0, 100 - $yield - $wastage);
                    $grad     = "conic-gradient(var(--brand-green-dark) 0% {$yield}%, var(--brand-orange) {$yield}% " . ($yield + $wastage) . "%, #e5e7eb " . ($yield + $wastage) . "% 100%)";
                @endphp

                <div class="card">
                    <h3 class="panel-title">
                        <i class="fas fa-chart-pie"></i> Production Efficiency
                    </h3>
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
                </div>

                <div class="card">
                    <h3 class="panel-title">
                        <i class="fas fa-warehouse"></i> Raw Stock by Location
                    </h3>
                    <div class="shipment-list">
                        @forelse($report['stock_levels']['raw'] ?? [] as $stock)
                        <div class="shipment">
                            <div class="thumb"><i class="fas fa-warehouse"></i></div>
                            <div>
                                <b>Location #{{ $stock->location_id }}</b>
                                <div><small>Raw Maize</small></div>
                            </div>
                            <div class="gain">{{ number_format($stock->quantity ?? 0, 3) }} kg</div>
                        </div>
                        @empty
                        <div style="text-align:center;color:var(--muted);padding:16px;">No raw stock data.</div>
                        @endforelse
                    </div>
                </div>

                <div class="card">
                    <h3 class="panel-title">
                        <i class="fas fa-tractor"></i> Top Supplier Performance
                    </h3>
                    <div class="shipment-list">
                        @forelse($report['supplier_performance'] ?? [] as $sp)
                        <div class="shipment">
                            <div class="thumb"><i class="fas fa-user"></i></div>
                            <div>
                                <b>Farmer #{{ $sp->farmer_id }}</b>
                                <div><small>Accepted: {{ number_format($sp->total_accepted ?? 0, 3) }} kg</small></div>
                            </div>
                            <div class="gain">{{ number_format($sp->total_rejected ?? 0, 3) }} rejected</div>
                        </div>
                        @empty
                        <div style="text-align:center;color:var(--muted);padding:16px;">No supplier data.</div>
                        @endforelse
                    </div>
                </div>

                @endif

            </div>
        </div>

    </main>
</div>
</body>
</html>