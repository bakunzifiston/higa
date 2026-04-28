<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile — {{ config('app.name', 'Higa') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @if (file_exists(public_path('hot')) || file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/modules.css'])
    @else
        <style>{!! file_get_contents(resource_path('css/modules.css')) !!}</style>
    @endif
</head>
<body>
<div class="shell">
    <aside class="sidebar">
        <div class="brand">
            <span class="brand-mark" aria-hidden="true"></span>
            <span class="brand-text">HIGA<span style="color:#d8ba4a">GROUP</span>
        </div>
        <nav class="menu">
            @foreach($menuItems as $item)
                <a href="{{ $item['href'] }}" class="{{ $navActive === $item['slug'] ? 'active' : '' }}">
                    <i class="fas {{ $item['icon'] ?? 'fa-circle' }}"></i>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>
        <div class="user-box">
            <div class="avatar" title="{{ $user->name }}">
                @php
                    $label = trim((string) ($user->name ?? $user->email ?? ''));
                    $initial = $label !== '' ? \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($label, 0, 1)) : '?';
                @endphp
                {{ $initial }}
            </div>
            <div>
                <div class="user-name">{{ $user->name }}</div>
                <div class="user-role"><i class="fas fa-user" style="font-size:0.65rem;margin-right:3px"></i>Profile</div>
        </div>
        <div class="spacer"></div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout-btn" type="submit">
                <i class="fas fa-sign-out-alt"></i> Log out
            </button>
        </form>
    </aside>

    <main class="main">
        <div class="topbar-ims">
            <div class="topbar-ims-title">
                <i class="fas fa-user-circle"></i>
                Account Settings
            </div>
            <div class="topbar-account">
                <a href="{{ route('profile.edit') }}" class="topbar-link active">
                    <i class="fas fa-user"></i> Profile
                </a>
                <form method="POST" action="{{ route('logout') }}" class="logout-inline">
                    @csrf
                    <button type="submit" class="topbar-link-btn">
                        <i class="fas fa-power-off"></i> Log out
                    </button>
                </form>
            </div>

        <section class="card">
            <h1 class="title">
                <i class="fas fa-id-card"></i>
                Profile
            </h1>
            <p class="sub"><i class="fas fa-info-circle" style="margin-right:4px"></i>Update your name, email, and password used to sign in.</p>

            @if (session('success'))
                <p class="success"><i class="fas fa-check-circle"></i> {{ session('success') }}</p>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" class="form-grid profile-form">
                @csrf
                @method('PUT')

                <div>
                    <label for="name"><i class="fas fa-user" style="margin-right:4px"></i> Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autocomplete="name">
                </div>
                <div>
                    <label for="email"><i class="fas fa-envelope" style="margin-right:4px"></i> Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
                </div>
                <div class="full">
                    <h3 class="form-section-title" style="margin:0.5rem 0 0;font-size:0.95rem;font-weight:700;">
                        <i class="fas fa-lock" style="margin-right:6px;color:var(--brand-green-dark)"></i>
                        Change password <span style="font-weight:500;color:var(--muted);font-size:0.85rem;">(optional)</span>
                    </h3>
                </div>
                <div>
                    <label for="current_password"><i class="fas fa-key" style="margin-right:4px"></i> Current password</label>
                    <input id="current_password" name="current_password" type="password" autocomplete="current-password" placeholder="Required only to set a new password">
                </div>
                <div>
                    <label for="password"><i class="fas fa-lock" style="margin-right:4px"></i> New password</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" placeholder="Leave blank to keep current">
                </div>
                <div>
                    <label for="password_confirmation"><i class="fas fa-lock" style="margin-right:4px"></i> Confirm new password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" placeholder="Repeat new password">
                </div>
                <div class="full" style="margin-top:0.25rem;">
                    <button type="submit" class="primary"><i class="fas fa-save"></i> Save changes</button>
                </div>
            </form>

            @if ($errors->any())
                <ul class="error" style="margin-top:0.5rem; padding-left:1.1rem;flex-direction:column;align-items:flex-start;">
                    @foreach ($errors->all() as $message)
                        <li style="margin-bottom:4px;"><i class="fas fa-exclamation-triangle" style="margin-right:6px"></i>{{ $message }}</li>
                    @endforeach
                </ul>
            @endif
        </section>
    </main>
</div>
</body>
</html>
