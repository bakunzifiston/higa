<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in — {{ config('app.name', 'Higa') }}</title>
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
        </div>
    </section>

    <section class="right-panel">
        <article class="login-card">
            <h1>Sign in</h1>
            <p class="subtitle">Use your account to open the operations dashboard.</p>

            <form action="{{ route('login.attempt') }}" method="POST">
                @csrf
                @if ($errors->any())
                    <div style="margin-bottom: 12px; color: #b91c1c; font-size: 0.9rem;">
                        {{ $errors->first() }}
                    </div>
                @endif
                <div class="field">
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required>
                </div>
                <div class="field">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div style="margin: 0.45rem 0 0.7rem; font-size: 0.9rem; color: #4b5563;">
                    <label style="display: inline-flex; align-items: center; gap: 0.45rem;">
                        <input type="checkbox" name="remember" value="1"> Remember me
                    </label>
                </div>
                <button class="login-btn" type="submit">Login</button>
            </form>

            <a class="forgot-link" href="#">Forgot password</a>
            <p class="login-home-link">
                <a class="forgot-link" href="{{ url('/') }}">Back to home</a>
            </p>
        </article>
    </section>
</main>
</body>
</html>
