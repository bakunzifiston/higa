<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in — {{ config('app.name', 'Higa AgriBusiness Group Ltd IMS') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @if (file_exists(public_path('hot')) || file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/auth-login.css'])
    @else
        <style>{!! file_get_contents(resource_path('css/auth-login.css')) !!}</style>
    @endif
</head>
<body>
<main class="layout">
    <section class="left-panel">
        <div class="illustration" aria-hidden="true">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:1.5rem;">
                <img src="{{ asset('higalog.jpg') }}" alt="HigaGroup Logo" style="max-height:32px;width:auto;border-radius:6px;flex-shrink:0;">
                <div>
                    <div style="font-weight:800;font-size:1.1rem;color:var(--brand-green-dark);">HigaGroup IMS</div>
                    <div style="font-size:0.8rem;color:var(--muted);">Maize Processing Operations</div>
                </div>
            </div>
            <div class="desk"></div>
            <div class="desk-row">
                <div class="desk-box"></div>
                <div class="desk-box"></div>
            </div>
            <div class="user-figure">
                <div class="avatar"></div>
                <div class="text-bars">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <div style="margin-top:1.5rem;display:flex;gap:0.5rem;flex-wrap:wrap;">
                <span style="padding:4px 10px;border-radius:999px;background:rgba(95,158,61,0.12);color:var(--brand-green-dark);font-size:0.75rem;font-weight:600;"><i class="fas fa-tractor" style="margin-right:4px"></i>Farmers</span>
                <span style="padding:4px 10px;border-radius:999px;background:rgba(95,158,61,0.12);color:var(--brand-green-dark);font-size:0.75rem;font-weight:600;"><i class="fas fa-industry" style="margin-right:4px"></i>Production</span>
                <span style="padding:4px 10px;border-radius:999px;background:rgba(95,158,61,0.12);color:var(--brand-green-dark);font-size:0.75rem;font-weight:600;"><i class="fas fa-box" style="margin-right:4px"></i>Inventory</span>
                <span style="padding:4px 10px;border-radius:999px;background:rgba(95,158,61,0.12);color:var(--brand-green-dark);font-size:0.75rem;font-weight:600;"><i class="fas fa-chart-line" style="margin-right:4px"></i>Sales</span>
            </div>
        </div>
    </section>

    <section class="right-panel">
        <article class="login-card">
            <div style="margin-bottom:1.2rem;">
                <img src="{{ asset('higalog.jpg') }}" alt="HigaGroup Logo" style="max-height:32px;width:auto;border-radius:6px;margin-bottom:0.8rem;display:block;">
                <h1 style="margin:0;font-size:1.8rem;">Sign in</h1>
                <p class="subtitle">Use your account to open the operations dashboard.</p>
            </div>

            <form action="{{ route('login.attempt') }}" method="POST">
                @csrf
                @if ($errors->any())
                    <div style="margin-bottom:12px;color:#b91c1c;font-size:0.9rem;display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
                    </div>
                @endif
                <div class="field" style="position:relative;">
                    <i class="fas fa-envelope" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#9ca3af;"></i>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required style="padding-left:38px;">
                </div>
                <div class="field" style="position:relative;">
                    <i class="fas fa-lock" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#9ca3af;"></i>
                    <input type="password" name="password" placeholder="Password" required style="padding-left:38px;">
                </div>
                <div style="margin:0.45rem 0 0.7rem;font-size:0.9rem;color:#4b5563;">
                    <label style="display:inline-flex;align-items:center;gap:0.45rem;">
                        <input type="checkbox" name="remember" value="1"> Remember me
                    </label>
                </div>
                <button class="login-btn" type="submit">
                    <i class="fas fa-sign-in-alt" style="margin-right:6px"></i> Login
                </button>
            </form>

            <a class="forgot-link" href="#"><i class="fas fa-key" style="margin-right:4px"></i> Forgot password</a>
            <p class="login-home-link">
                <a class="forgot-link" href="{{ url('/') }}"><i class="fas fa-arrow-left" style="margin-right:4px"></i> Back to home</a>
            </p>
        </article>
    </section>
</main>
</body>
</html>
