<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoga IMS Dashboard</title>
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
            <span class="brand-mark" aria-hidden="true"></span>
            <span class="brand-text">HIGA<span style="color:#d8ba4a">GROUP</span></span>
        </div>

        <nav class="menu">
            @foreach ($menuItems as $item)
                <a
                    href="{{ $item['endpoint'] }}"
                    class="{{ $activeModule === $item['slug'] ? 'active' : '' }}"
                >
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <a href="{{ route('profile.edit') }}" class="user-box user-box-link" title="Open profile">
            <div class="avatar" title="{{ auth()->user()->name }}">
                @php
                    $label = trim((string) (auth()->user()->name ?? auth()->user()->email ?? ''));
                    $initial = $label !== '' ? \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($label, 0, 1)) : '?';
                @endphp
                {{ $initial }}
            </div>
            <div>
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">Edit profile</div>
            </div>
        </a>

        <div class="spacer"></div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout-btn" type="submit">Log out</button>
        </form>
    </aside>

    <main class="main">
        <div class="topbar">
            <input class="search" type="search" placeholder="Search">
            <div class="topbar-right">
                <div class="top-icons" aria-label="Quick actions">
                    <span class="icon-btn" title="Notifications" role="img" aria-label="Notifications">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                        </svg>
                    </span>
                </div>
                <div class="topbar-account" aria-label="Account">
                    <a href="{{ route('profile.edit') }}" class="topbar-text-link">Profile</a>
                    <form method="POST" action="{{ route('logout') }}" class="logout-inline-dash">
                        @csrf
                        <button type="submit" class="topbar-text-btn">Log out</button>
                    </form>
                </div>
            </div>
        </div>

        <section class="welcome">
            <h1>Welcome, {{ auth()->user()->name }}</h1>
            <p>
                Active module: <strong>{{ $currentModule['label'] }}</strong>
                &middot;
                <a href="{{ $currentModule['endpoint'] }}">{{ $currentModule['endpoint'] }}</a>
            </p>
        </section>

        <section class="cards">
            @foreach($kpis as $kpi)
                <article class="card">
                    <h4>{{ $kpi['label'] }}</h4>
                    <p>{{ $kpi['value'] }}</p>
                    <div class="kpi-sub">{{ $kpi['sub'] }}</div>
                </article>
            @endforeach
        </section>

        <section class="content-grid">
            <div class="left-stack">
                <article class="card">
                    <h3 class="panel-title">Overview</h3>
                    <div class="map-mock">
                        <span class="pin p1"></span>
                        <span class="pin p2"></span>
                        <span class="pin p3"></span>
                        <span class="pin p4"></span>
                    </div>
                </article>

                <article class="card">
                    <h3 class="panel-title">Traceability</h3>
                    <div class="trace-box">
                        <div class="trace-photo"></div>
                        <div class="meta">
                            <strong>BP-4692</strong>
                            Shipment in transit<br>
                            Origin: Kigali Slaughterhouse<br>
                            Transit: Butare Junction<br>
                            Delivery Temp: +2.0°C
                        </div>
                    </div>
                </article>

                <section class="card table-card">
                    <h3 class="panel-title">Inventory Overview</h3>
                    <table>
                        <thead>
                        <tr>
                            <th>Item</th>
                            <th>Stock</th>
                            <th>Temp</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr><td>Maize Grade A</td><td>497 kg</td><td>+3.7°C</td><td>In Compliance</td></tr>
                        <tr><td>Kawunga 25kg</td><td>436 kg</td><td>+3.1°C</td><td>Near Threshold</td></tr>
                        <tr><td>Blanda 10kg</td><td>188 kg</td><td>+2.8°C</td><td>In Compliance</td></tr>
                        </tbody>
                    </table>
                </section>
            </div>

            <div class="right-stack">
                <article class="card">
                    <h3 class="panel-title">Shipment Status</h3>
                    <div class="status">
                        <div class="donut-wrap">
                            <div class="donut" aria-hidden="true"></div>
                        </div>
                        <div class="legend">
                            <span><i class="dot" style="background:#3f7f2d"></i> In Transit</span>
                            <span><i class="dot" style="background:#e08b2d"></i> Delivered</span>
                            <span><i class="dot" style="background:#e5e7eb"></i> Processing</span>
                        </div>
                    </div>
                </article>

                <article class="card">
                    <h3 class="panel-title">Compliance Alerts</h3>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <div>
                            <div style="font-size:1.85rem;font-weight:800;color:#3f7f2d;">A+</div>
                            <div style="font-size:0.86rem;color:#6b7280;">Valid until Dec 2026</div>
                        </div>
                        <div style="width:72px;height:72px;border-radius:50%;border:7px solid #e5e7eb;border-top-color:#3f7f2d;display:grid;place-items:center;font-weight:800;">94</div>
                    </div>
                </article>

                <article class="card">
                    <h3 class="panel-title">Shipments</h3>
                    <div class="shipment-list">
                        <div class="shipment">
                            <div class="thumb"></div>
                            <div><b>BP-4692</b><br><small>Butare Queue</small></div>
                            <div class="gain">+2°C</div>
                        </div>
                        <div class="shipment">
                            <div class="thumb"></div>
                            <div><b>BP-4629</b><br><small>Kigali Dispatch</small></div>
                            <div class="gain">+5.3°</div>
                        </div>
                        <div class="shipment">
                            <div class="thumb"></div>
                            <div><b>BP-4598</b><br><small>Musanze Inbound</small></div>
                            <div class="gain">+3.4°</div>
                        </div>
                    </div>
                </article>

                <article class="card table-card">
                    <h3 class="panel-title">Module Endpoints</h3>
                    <table>
                        <tbody>
                        <tr><td><strong>Current Module</strong></td><td><a href="{{ $currentModule['endpoint'] }}">{{ $currentModule['endpoint'] }}</a></td></tr>
                        <tr><td><a href="/api/v1/farmers">Suppliers</a></td><td><a href="/api/v1/farmers">/api/v1/farmers</a></td></tr>
                        <tr><td><a href="/api/v1/maize-collections">Collections</a></td><td><a href="/api/v1/maize-collections">/api/v1/maize-collections</a></td></tr>
                        <tr><td><a href="/api/v1/production-batches">Production</a></td><td><a href="/api/v1/production-batches">/api/v1/production-batches</a></td></tr>
                        <tr><td><a href="/api/v1/sales">Sales</a></td><td><a href="/api/v1/sales">/api/v1/sales</a></td></tr>
                        </tbody>
                    </table>
                </article>
            </div>
        </section>

        <section class="card table-card">
            <h3 class="panel-title">All IMS APIs</h3>
            <table>
                <thead>
                    <tr>
                        <th>Module</th>
                        <th>Endpoint</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Suppliers</td><td><a href="/api/v1/farmers">/api/v1/farmers</a></td></tr>
                    <tr><td>Collections</td><td><a href="/api/v1/maize-collections">/api/v1/maize-collections</a></td></tr>
                    <tr><td>Raw Inventory</td><td><a href="/api/v1/raw-inventory/movements">/api/v1/raw-inventory/movements</a></td></tr>
                    <tr><td>Production</td><td><a href="/api/v1/production-batches">/api/v1/production-batches</a></td></tr>
                    <tr><td>Products</td><td><a href="/api/v1/products">/api/v1/products</a></td></tr>
                    <tr><td>Finished Inventory</td><td><a href="/api/v1/finished-inventory/movements">/api/v1/finished-inventory/movements</a></td></tr>
                    <tr><td>Sales</td><td><a href="/api/v1/sales">/api/v1/sales</a></td></tr>
                    <tr><td>Returns</td><td><a href="/api/v1/sales-returns">/api/v1/sales-returns</a></td></tr>
                    <tr><td>Expenses</td><td><a href="/api/v1/batch-expenses">/api/v1/batch-expenses</a></td></tr>
                    <tr><td>Payments</td><td><a href="/api/v1/payments">/api/v1/payments</a></td></tr>
                </tbody>
            </table>
        </section>
    </main>
</div>
</body>
</html>
