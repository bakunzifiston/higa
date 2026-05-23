<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Higa Agribusiness Group IMS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
:root {
    --brand: #5f9e3d;
    --brand-dark: #3f7f2d;
    --brand-light: #edf7e6;
    --bg: #f5f7fb;
    --text: #0f1f0f;
    --muted: #64748b;
    --line: #e2e8f0;
    --gold: #c8900a;
    --gold-bg: #fef9ec;
    --brown: #7c4a1e;
}

* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    font-family: 'Inter', Arial, sans-serif;
    background: #fff;
    color: var(--text);
    -webkit-font-smoothing: antialiased;
}

a { text-decoration: none; }

/* ── HEADER ── */
header {
    position: sticky;
    top: 0;
    z-index: 100;
    background: rgba(255,255,255,.92);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid var(--line);
}

.header-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 14px 32px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo {
    display: flex;
    align-items: center;
    gap: 12px;
    color: var(--text);
}

.logo img {
    height: 38px;
    width: 38px;
    border-radius: 10px;
    object-fit: cover;
}

.logo-name {
    font-size: 1rem;
    font-weight: 800;
    letter-spacing: -.02em;
}

.logo-name em {
    font-style: normal;
    color: var(--brand-dark);
}

.logo-tag {
    font-size: .7rem;
    font-weight: 600;
    color: var(--muted);
    letter-spacing: .08em;
    text-transform: uppercase;
    display: block;
    margin-top: 1px;
}

.header-nav { display: flex; gap: 10px; align-items: center; }

/* ── BUTTONS ── */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 22px;
    border-radius: 12px;
    font-weight: 700;
    font-size: .88rem;
    border: none;
    cursor: pointer;
    transition: all .2s;
    letter-spacing: -.01em;
}

.btn-primary {
    background: var(--brand-dark);
    color: #fff;
    box-shadow: 0 2px 12px rgba(63,127,45,.35);
}

.btn-primary:hover {
    background: #2d6120;
    box-shadow: 0 4px 20px rgba(63,127,45,.45);
    transform: translateY(-1px);
}

.btn-ghost {
    background: transparent;
    color: var(--text);
    border: 1.5px solid var(--line);
}

.btn-ghost:hover {
    background: var(--bg);
    border-color: #c8d8c0;
}

/* ── HERO ── */
.hero-wrap {
    max-width: 1200px;
    margin: 0 auto;
    padding: 90px 32px 80px;
    display: grid;
    grid-template-columns: 1fr 420px;
    gap: 72px;
    align-items: center;
}

/* left */
.hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 7px 16px;
    border-radius: 999px;
    background: var(--gold-bg);
    border: 1px solid rgba(200,144,10,.25);
    font-size: .78rem;
    font-weight: 700;
    color: var(--gold);
    letter-spacing: .04em;
    text-transform: uppercase;
    margin-bottom: 22px;
}

.hero-eyebrow i { color: var(--brand); }

.hero-title {
    font-size: 3.4rem;
    font-weight: 900;
    line-height: 1.08;
    letter-spacing: -.04em;
    margin-bottom: 22px;
}

.hero-title .green { color: var(--brand-dark); }

.hero-desc {
    font-size: 1.05rem;
    line-height: 1.75;
    color: var(--muted);
    max-width: 460px;
    margin-bottom: 36px;
}

.hero-cta { display: flex; flex-wrap: wrap; gap: 12px; }

/* stats row */
.hero-stats {
    display: flex;
    gap: 32px;
    margin-top: 44px;
    padding-top: 32px;
    border-top: 1px solid var(--line);
}

.stat-item strong {
    display: block;
    font-size: 1.6rem;
    font-weight: 900;
    color: var(--brand-dark);
    letter-spacing: -.03em;
}

.stat-item span {
    font-size: .78rem;
    color: var(--muted);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .06em;
}

/* right cards */
.feature-stack { display: flex; flex-direction: column; gap: 14px; }

.feature-card {
    display: flex;
    align-items: center;
    gap: 18px;
    padding: 20px 22px;
    border-radius: 18px;
    border: 1px solid var(--line);
    background: #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,.04);
    transition: box-shadow .25s, transform .25s;
    position: relative;
    overflow: hidden;
}

.feature-card::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 4px;
    border-radius: 4px 0 0 4px;
}

.feature-card:hover {
    box-shadow: 0 8px 28px rgba(0,0,0,.09);
    transform: translateX(4px);
}

.feature-card.green::before  { background: var(--brand); }
.feature-card.yellow::before { background: #F9A825; }
.feature-card.brown::before  { background: #8B5E3C; }
.feature-card.dark::before   { background: var(--brand-dark); }

.feat-icon {
    width: 46px;
    height: 46px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.feat-icon.green  { background: #edf7e6; color: var(--brand-dark); }
.feat-icon.yellow { background: #fffbeb; color: #b07800; }
.feat-icon.brown  { background: #fdf3ec; color: #7c4a1e; }
.feat-icon.dark   { background: #edf7e6; color: var(--brand-dark); }

.feat-body { flex: 1; }
.feat-body strong { display: block; font-size: .95rem; font-weight: 700; margin-bottom: 2px; }
.feat-body span   { font-size: .8rem; color: var(--muted); }

.feat-arrow { color: #c8d8c0; font-size: .85rem; }

/* ── FOOTER ── */
footer {
    border-top: 1px solid var(--line);
    padding: 28px 32px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: .82rem;
    color: var(--muted);
    max-width: 1200px;
    margin: 0 auto;
}

footer strong { color: var(--brand-dark); }

/* ── RESPONSIVE ── */
@media (max-width: 960px) {
    .hero-wrap { grid-template-columns: 1fr; padding: 56px 24px 48px; gap: 48px; }
    .hero-title { font-size: 2.4rem; }
    .feature-stack { display: grid; grid-template-columns: 1fr 1fr; }
}

@media (max-width: 600px) {
    .header-inner { padding: 14px 20px; }
    .logo-name { font-size: .9rem; }
    .hero-title { font-size: 2rem; }
    .feature-stack { grid-template-columns: 1fr; }
    .hero-stats { gap: 20px; }
    footer { flex-direction: column; gap: 6px; text-align: center; }
}
    </style>
</head>
<body>

{{-- ── HEADER ── --}}
<header>
    <div class="header-inner">
        <div class="logo">
            <img src="{{ asset('higalog.jpg') }}" alt="HigaGroup Logo">
            <div>
                <div class="logo-name">HIGA Agribusiness Group <em>IMS</em></div>
                <span class="logo-tag">Inventory Management System</span>
            </div>
        </div>

        <nav class="header-nav">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
                <a href="{{ route('profile.edit') }}" class="btn btn-ghost">
                    <i class="fas fa-user"></i> Profile
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Sign in
                </a>
            @endauth
        </nav>
    </div>
</header>

{{-- ── HERO ── --}}
<section>
    <div class="hero-wrap">

        {{-- LEFT --}}
        <div>
            <div class="hero-eyebrow">
                <i class="fas fa-seedling"></i>
                Agribusiness Operations Platform
            </div>

            <h1 class="hero-title">
                Smarter Inventory<br>
                <span class="green">for Agribusiness</span>
            </h1>

            <p class="hero-desc">
                Manage maize collection, production, inventory, sales, and finance
                in one structured system designed for real operations.
            </p>

            <div class="hero-cta">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">
                        <i class="fas fa-chart-line"></i> Go to dashboard
                    </a>
                    <a href="{{ route('profile.edit') }}" class="btn btn-ghost">
                        <i class="fas fa-user"></i> Profile
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt"></i> Sign in
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-ghost">
                        <i class="fas fa-chart-line"></i> View dashboard
                    </a>
                @endauth
            </div>

            <div class="hero-stats">
                <div class="stat-item">
                    <strong>6+</strong>
                    <span>Modules</span>
                </div>
                <div class="stat-item">
                    <strong>Real-time</strong>
                    <span>Inventory</span>
                </div>
                <div class="stat-item">
                    <strong>End-to-end</strong>
                    <span>Traceability</span>
                </div>
            </div>
        </div>

        {{-- RIGHT --}}
        <div class="feature-stack">

            <div class="feature-card green">
                <div class="feat-icon green">
                    <i class="fas fa-tractor"></i>
                </div>
                <div class="feat-body">
                    <strong>Collections</strong>
                    <span>Quality intake tracking</span>
                </div>
                <i class="fas fa-chevron-right feat-arrow"></i>
            </div>

            <div class="feature-card yellow">
                <div class="feat-icon yellow">
                    <i class="fas fa-industry"></i>
                </div>
                <div class="feat-body">
                    <strong>Production</strong>
                    <span>Batch processing control</span>
                </div>
                <i class="fas fa-chevron-right feat-arrow"></i>
            </div>

            <div class="feature-card brown">
                <div class="feat-icon brown">
                    <i class="fas fa-warehouse"></i>
                </div>
                <div class="feat-body">
                    <strong>Inventory</strong>
                    <span>Real-time stock visibility</span>
                </div>
                <i class="fas fa-chevron-right feat-arrow"></i>
            </div>

            <div class="feature-card dark">
                <div class="feat-icon dark">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <div class="feat-body">
                    <strong>Finance</strong>
                    <span>Sales &amp; payment tracking</span>
                </div>
                <i class="fas fa-chevron-right feat-arrow"></i>
            </div>

        </div>

    </div>
</section>

{{-- ── FOOTER ── --}}
<footer>
    <span>&copy; 2026 <strong>Higa Agribusiness Group LTD</strong></span>
    <span>Inventory Management System</span>
</footer>

</body>
</html>