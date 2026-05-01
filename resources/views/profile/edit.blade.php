file<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile — {{ config('app.name', 'Higa') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @if (file_exists(public_path('hot')) || file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/modules.css', 'resources/js/modules.js'])
    @else
        <style>{!! file_get_contents(resource_path('css/modules.css')) !!}</style>
    @endif
</head>
<body>
<div class="shell">
    <aside class="sidebar">
<div class="brand">
            <img src="{{ asset('higalog.jpg') }}" alt="HigaGroup Logo" style="max-height:32px;width:auto;border-radius:6px;">
        </div>
<nav class="menu">
            @foreach($menuItems as $item)
                <a href="{{ $item['endpoint'] ?? $item['href'] ?? '#' }}" class="{{ $navActive === $item['slug'] ? 'active' : '' }}">
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
        </div>

        <section class="card" style="padding:0;overflow:hidden;">
            <!-- Profile Header -->
            <div class="profile-header">
                <div class="profile-avatar">{{ $initial }}</div>
                <div class="profile-info">
                    <h2>{{ $user->name }}</h2>
                    <p>{{ $user->email }}</p>
                </div>
            </div>

            <!-- Alert Messages -->
            @if (session('success'))
                <div style="padding: 12px 18px;">
                    <p class="success" style="margin:0;"><i class="fas fa-check-circle"></i> {{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div style="padding: 0 18px 12px;">
                    <ul class="error" style="margin:0;flex-direction:column;align-items:flex-start;">
                        @foreach ($errors->all() as $message)
                            <li style="margin-bottom:4px;"><i class="fas fa-exclamation-triangle" style="margin-right:6px"></i>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Profile Form -->
            <form method="POST" action="{{ route('profile.update') }}" autocomplete="off">
                @csrf
                @method('PUT')

                <!-- Personal Info Section -->
                <div class="form-section" style="border-radius:0;margin-bottom:0;border-left:0;border-right:0;border-top:0;">
                    <h3 class="form-section-title">
                        <i class="fas fa-user" style="color:var(--brand-green-dark)"></i>
                        Personal Information
                    </h3>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 14px;">
                        <div>
                            <label for="name"><i class="fas fa-user" style="margin-right:4px"></i> Full Name</label>
                            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autocomplete="name" placeholder="Enter your full name" style="width:100%;">
                        </div>
                        <div>
                            <label for="email"><i class="fas fa-envelope" style="margin-right:4px"></i> Email Address</label>
                            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="email" placeholder="Enter your email" style="width:100%;">
                        </div>
                    </div>
                </div>

                <!-- Password Section -->
                <div class="form-section" style="border-radius:0;margin-bottom:0;border-left:0;border-right:0;">
                    <h3 class="form-section-title">
                        <i class="fas fa-lock" style="color:var(--brand-green-dark)"></i>
                        Change Password <span style="font-weight:500;color:var(--muted);font-size:0.85rem;">(optional)</span>
                    </h3>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 14px;">
                        <div>
                            <label for="current_password"><i class="fas fa-key" style="margin-right:4px"></i> Current Password</label>
                            <input id="current_password" name="current_password" type="password" autocomplete="current-password" placeholder="Enter current password" style="width:100%;">
                        </div>
                        <div>
                            <label for="password"><i class="fas fa-lock" style="margin-right:4px"></i> New Password</label>
                            <input id="password" name="password" type="password" autocomplete="new-password" placeholder="Minimum 8 characters" style="width:100%;">
                        </div>
                        <div>
                            <label for="password_confirmation"><i class="fas fa-lock" style="margin-right:4px"></i> Confirm New Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" placeholder="Repeat new password" style="width:100%;">
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="form-actions">
                    <button type="submit" class="primary" style="min-width: 140px;">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </section>
    </main>
</div>
</body>
</html>
