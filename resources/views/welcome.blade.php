<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light">

    <title>{{ config('app.name', 'Higa AgriBusiness Group Ltd IMS') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/welcome.css'])
    @else
        <style>
            :root{--brand-green:#5f9e3d;--brand-green-dark:#3f7f2d;--brand-gold:#d8ba4a;--brand-orange:#e08b2d;--dark:#171322;--line:#ececf1;--text:#1f2937;--muted:#6b7280;--surface:#fff;--page-bg:#f8f9fc}
            *,*::before,*::after{box-sizing:border-box}
            .welcome-skip{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}
            body.welcome-page{margin:0;min-height:100vh;font-family:Inter,system-ui,sans-serif;color:var(--text);background:var(--page-bg);-webkit-font-smoothing:antialiased}
            .welcome-header{max-width:72rem;margin:0 auto;padding:1rem 1.5rem;display:flex;align-items:center;justify-content:space-between;gap:1rem}
            .welcome-brand{display:flex;align-items:center;gap:0.65rem;text-decoration:none;color:var(--text);font-weight:700;font-size:1.05rem}
            .welcome-mark{width:2.25rem;height:2.25rem;border-radius:10px;background:linear-gradient(145deg,var(--brand-gold) 0%,var(--brand-green) 55%,var(--brand-green-dark) 100%);flex-shrink:0}
            .welcome-nav{display:flex;flex-wrap:wrap;gap:0.5rem;justify-content:flex-end}
            .welcome-nav a{display:inline-flex;padding:0.45rem 1rem;font-size:0.9rem;font-weight:500;text-decoration:none;border-radius:8px;color:var(--text);border:1px solid transparent}
            .welcome-nav a:hover{border-color:var(--line);background:rgba(255,255,255,0.8)}
            .welcome-nav a.welcome-btn--primary{background:var(--brand-green);color:#fff;border-color:var(--brand-green-dark)}
            .welcome-nav a.welcome-btn--primary:hover{background:var(--brand-green-dark);color:#fff}
            .welcome-band{max-width:56rem;height:4px;margin:0 auto 2rem;border-radius:999px;background:linear-gradient(90deg,var(--brand-gold),var(--brand-orange),var(--brand-green),var(--brand-green-dark));opacity:0.9}
            .welcome-hero{max-width:40rem;margin:0 auto;padding:2.5rem 1.5rem 3rem;text-align:center}
            .welcome-hero h1{margin:0 0 0.75rem;font-size:clamp(1.75rem,4vw,2.25rem);font-weight:800;letter-spacing:-0.02em;color:var(--dark)}
            .welcome-hero p{margin:0 0 1.75rem;font-size:1.05rem;line-height:1.6;color:var(--muted)}
            .welcome-cta{display:inline-flex;padding:0.65rem 1.35rem;font-size:1rem;font-weight:600;text-decoration:none;color:#fff;background:var(--brand-green);border:1px solid var(--brand-green-dark);border-radius:10px}
            .welcome-cta:hover{background:var(--brand-green-dark)}
            .welcome-panel{max-width:40rem;margin:0 auto 2.5rem;padding:1.5rem 1.25rem;background:var(--surface);border:1px solid var(--line);border-radius:14px;box-shadow:0 1px 3px rgba(23,19,34,0.06)}
            .welcome-panel h2{margin:0 0 0.75rem;font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--brand-green-dark)}
            .welcome-panel ul{margin:0;padding:0;list-style:none;text-align:left;font-size:0.95rem;line-height:1.5}
            .welcome-panel li{position:relative;padding-left:1.35rem;margin-bottom:0.6rem}
            .welcome-panel li::before{content:'';position:absolute;left:0;top:0.55em;width:0.4rem;height:0.4rem;border-radius:50%;background:var(--brand-green);box-shadow:0 0 0 2px rgba(95,158,61,0.25)}
            .welcome-foot{padding:1.25rem 1.5rem 2rem;text-align:center;font-size:0.8rem;color:var(--muted)}
        </style>
    @endif
</head>
<body class="welcome-page">
    <a href="#main" class="welcome-skip">Skip to content</a>

    <header class="welcome-header">
        <a href="{{ url('/') }}" class="welcome-brand" aria-label="{{ config('app.name') }} home">
            <img src="{{ asset('higalog.jpg') }}" alt="HigaGroup Logo" style="width:2.25rem;height:2.25rem;border-radius:10px;object-fit:cover;flex-shrink:0;">
            <span>{{ config('app.name', 'Higa') }}</span>
        </a>
        @if (Route::has('login'))
            <nav class="welcome-nav" aria-label="Account">
                @auth
                    <a href="{{ url('/dashboard') }}" class="welcome-btn--primary"><i class="fas fa-th-large" style="margin-right:4px"></i> Open dashboard</a>
                @else
                    <a href="{{ route('login') }}"><i class="fas fa-sign-in-alt" style="margin-right:4px"></i> Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"><i class="fas fa-user-plus" style="margin-right:4px"></i> Register</a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <div class="welcome-band" role="presentation"></div>

    <main id="main" class="welcome-hero">
        <h1><i class="fas fa-leaf" style="color:var(--brand-green);margin-right:8px;"></i>Higa AgriBusiness Group Ltd — Maize Processing IMS</h1>
        <p>
            Manage maize collections, production batches, finished goods inventory, sales, and payments
            for Kawunga flour, Blanda, and animal feed operations.
        </p>
        @guest
            @if (Route::has('login'))
                <a href="{{ route('login') }}" class="welcome-cta"><i class="fas fa-sign-in-alt" style="margin-right:6px"></i> Sign in to continue</a>
            @endif
        @else
            <a href="{{ url('/dashboard') }}" class="welcome-cta"><i class="fas fa-th-large" style="margin-right:6px"></i> Go to dashboard</a>
        @endguest
    </main>

    <section class="welcome-panel" aria-labelledby="welcome-capabilities">
        <h2 id="welcome-capabilities"><i class="fas fa-bolt" style="margin-right:6px"></i>At a glance</h2>
        <ul>
            <li><i class="fas fa-tractor" style="margin-right:6px;color:var(--brand-green)"></i>Maize collection from farmers with quality checks and rejection tracking</li>
            <li><i class="fas fa-industry" style="margin-right:6px;color:var(--brand-green)"></i>Production batches for Kawunga, Blanda, and Animal Feed with wastage recording</li>
            <li><i class="fas fa-warehouse" style="margin-right:6px;color:var(--brand-green)"></i>Finished goods inventory across multiple locations with expiry tracking</li>
            <li><i class="fas fa-chart-line" style="margin-right:6px;color:var(--brand-green)"></i>Sales, returns, payments, and real-time dashboards</li>
        </ul>
    </section>

    <footer class="welcome-foot">
        <i class="fas fa-code" style="margin-right:4px"></i>Laravel {{ app()->version() }}
    </footer>
</body>
</html>
