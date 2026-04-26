<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile — {{ config('app.name', 'Higa') }}</title>
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
            <span class="brand-text">HIGA<span style="color:#d8ba4a">GROUP</span></span>
        </div>
        <nav class="menu">
            @foreach($menuItems as $item)
                <a href="{{ $item['href'] }}" class="{{ $navActive === $item['slug'] ? 'active' : '' }}">{{ $item['label'] }}</a>
            @endforeach
        </nav>
        <div class="user-box profile-user-box">
            <div class="avatar" title="{{ $user->name }}">
                @php
                    $label = trim((string) ($user->name ?? $user->email ?? ''));
                    $initial = $label !== '' ? \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($label, 0, 1)) : '?';
                @endphp
                {{ $initial }}
            </div>
            <div>
                <div class="user-name">{{ $user->name }}</div>
                <div class="user-role">Profile</div>
            </div>
        </div>
        <div class="spacer"></div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout-btn" type="submit">Log out</button>
        </form>
    </aside>

    <main class="main">
        <div class="topbar topbar-ims">
            <span class="topbar-ims-title">Account</span>
            <div class="topbar-account">
                <a href="{{ route('profile.edit') }}" class="topbar-link active">Profile</a>
                <form method="POST" action="{{ route('logout') }}" class="logout-inline">
                    @csrf
                    <button type="submit" class="topbar-link-btn">Log out</button>
                </form>
            </div>
        </div>

        <section class="card">
            <h1 class="title">Profile</h1>
            <p class="sub">Update your name, email, and password used to sign in.</p>

            @if (session('success'))
                <p class="success">{{ session('success') }}</p>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" class="form-grid profile-form">
                @csrf
                @method('PUT')

                <div>
                    <label for="name">Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autocomplete="name">
                </div>
                <div>
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
                </div>
                <div class="full">
                    <h3 class="form-section-title">Change password <span class="optional-hint">(optional)</span></h3>
                </div>
                <div>
                    <label for="current_password">Current password</label>
                    <input id="current_password" name="current_password" type="password" autocomplete="current-password" placeholder="Required only to set a new password">
                </div>
                <div>
                    <label for="password">New password</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" placeholder="Leave blank to keep current">
                </div>
                <div>
                    <label for="password_confirmation">Confirm new password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" placeholder="Repeat new password">
                </div>
                <div class="full form-actions">
                    <button type="submit" class="primary">Save changes</button>
                </div>
            </form>

            @if ($errors->any())
                <ul class="error error-list" style="margin-top:0.5rem; padding-left:1.1rem;">
                    @foreach ($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            @endif
        </section>
    </main>
</div>
</body>
</html>
