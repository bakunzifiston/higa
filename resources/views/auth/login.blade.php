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
<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('togglePasswordIcon');
        if (!input || !icon) return;
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        icon.classList.toggle('fa-eye', !isHidden);
        icon.classList.toggle('fa-eye-slash', isHidden);
    }
</script>
<main class="layout" style="grid-template-columns:1fr;">

<section class="right-panel" style="border-radius:14px;background:linear-gradient(160deg, #0b1220 0%, #111a2d 45%, #0f172a 100%);">
        <article class="login-card">
            <div style="margin-bottom:1.2rem;">
                <div style="width:48px;height:48px;border-radius:12px;background:linear-gradient(145deg,var(--brand-gold),var(--brand-green));display:grid;place-items:center;margin-bottom:0.8rem;">
                    <i class="fas fa-leaf" style="color:#fff;font-size:1.4rem;"></i>
                </div>
                <h1 style="margin:0;font-size:1.8rem;">Sign in</h1>
                <p class="subtitle" style="margin:0.45rem 0 0;">Access the operations dashboard</p>
            </div>

            <form action="{{ route('login.attempt') }}" method="POST">
                @csrf

                @if ($errors->any())
                    <div style="margin-bottom:12px;color:#b91c1c;font-size:0.9rem;display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
                    </div>
                @endif

                <div class="field" style="position:relative;">
                    <i class="fas fa-envelope" style="position:absolute;left:14px;top:14px;color:#9ca3af;"></i>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required style="padding-left:44px;">

                </div>

                <div class="field" style="position:relative;">
                    <i class="fas fa-lock" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#9ca3af;"></i>
                    <input id="password" type="password" name="password" placeholder="Password" required style="padding-right:44px;">
                    <button type="button" aria-label="Show password" onclick="togglePassword()" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);border:0;background:transparent;cursor:pointer;color:#64748b;width:32px;height:32px;display:flex;align-items:center;justify-content:center;">
                        <i id="togglePasswordIcon" class="fas fa-eye" style="position:static;"></i>
                    </button>

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
                <a class="forgot-link" style="margin-top:0;" href="{{ url('/') }}"><i class="fas fa-arrow-left" style="margin-right:4px"></i> Back to home</a>
            </p>
        </article>
    </section>
</main>
</body>
</html>
