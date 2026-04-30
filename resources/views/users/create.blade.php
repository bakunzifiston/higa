<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User - HigaGroup</title>
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
            <span class="brand-mark" aria-hidden="true"></span>
            <span class="brand-text">HIGA<span style="color:#d8ba4a">GROUP</span>
        </div>
        <nav class="menu">
            <a href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="{{ route('modules.show', ['module' => 'farmers']) }}"><i class="fas fa-tractor"></i> Farmers</a>
            <a href="{{ route('modules.show', ['module' => 'locations']) }}"><i class="fas fa-warehouse"></i> Warehouses</a>
            <a href="{{ route('modules.show', ['module' => 'collections']) }}"><i class="fas fa-seedling"></i> Collections</a>
            <a href="{{ route('modules.show', ['module' => 'raw-inventory']) }}"><i class="fas fa-boxes-stacked"></i> Raw Inventory</a>
            <a href="{{ route('modules.show', ['module' => 'production']) }}"><i class="fas fa-industry"></i> Production</a>
            <a href="{{ route('modules.show', ['module' => 'products']) }}"><i class="fas fa-tags"></i> Products</a>
            <a href="{{ route('modules.show', ['module' => 'finished-inventory']) }}"><i class="fas fa-warehouse"></i> Finished Inv</a>
            <a href="{{ route('modules.show', ['module' => 'sales']) }}"><i class="fas fa-chart-line"></i> Sales</a>
            <a href="{{ route('modules.show', ['module' => 'returns']) }}"><i class="fas fa-undo"></i> Returns</a>
            <a href="{{ route('modules.show', ['module' => 'expenses']) }}"><i class="fas fa-file-invoice-dollar"></i> Expenses</a>
            <a href="{{ route('modules.show', ['module' => 'payments']) }}"><i class="fas fa-hand-holding-dollar"></i> Payments</a>
            <a href="{{ route('profile.edit') }}"><i class="fas fa-user"></i> Profile</a>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('users.index') }}" class="active"><i class="fas fa-users"></i> Users</a>
            @endif
        </nav>
        <div class="user-box">
            <div class="avatar" title="{{ auth()->user()->name }}">
                @php
                    $ulabel = trim((string) (auth()->user()->name ?? auth()->user()->email ?? ''));
                    $uinitial = $ulabel !== '' ? \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($ulabel, 0, 1)) : '?';
                @endphp
                {{ $uinitial }}
            </div>
            <div>
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">{{ auth()->user()->role?->name ?? 'No Role' }}</div>
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
                <i class="fas fa-user-plus"></i>
                Create User
            </div>
            <div class="topbar-account">
                <a href="{{ route('profile.edit') }}" class="topbar-link">
                    <i class="fas fa-user-circle"></i> Profile
                </a>
                <form method="POST" action="{{ route('logout') }}" class="logout-inline">
                    @csrf
                    <button type="submit" class="topbar-link-btn">
                        <i class="fas fa-power-off"></i> Log out
                    </button>
                </form>
            </div>
        </div>

        @if ($errors->any())
        <p class="error"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</p>
        @endif

        <section class="card">
            <div class="form-toolbar">
                <h3><i class="fas fa-user-plus" style="margin-right:6px;color:var(--brand-green-dark)"></i>Add New User</h3>
                <a href="{{ route('users.index') }}" class="secondary"><i class="fas fa-arrow-left"></i> Back to Users</a>
            </div>
            
            <form method="POST" action="{{ route('users.store') }}" class="form-grid">
                @csrf
                
                <div><label><i class="fas fa-user" style="margin-right:4px"></i> Full Name</label><input name="name" value="{{ old('name') }}" required></div>
                <div><label><i class="fas fa-envelope" style="margin-right:4px"></i> Email Address</label><input name="email" type="email" value="{{ old('email') }}" required></div>
                <div><label><i class="fas fa-lock" style="margin-right:4px"></i> Password</label><input name="password" type="password" required minlength="8"></div>
                <div><label><i class="fas fa-lock" style="margin-right:4px"></i> Confirm Password</label><input name="password_confirmation" type="password" required></div>
                <div class="full"><label><i class="fas fa-user-tag" style="margin-right:4px"></i> Role</label>
                    <select name="role_id" required>
                        <option value="">Select Role</option>
                        <option value="1">Admin</option>
                        <option value="2">Collection Officer</option>
                        <option value="3">Production Manager</option>
                        <option value="4">Sales Team</option>
                    </select>
                </div>
                
                <div class="full actions">
                    <button class="primary" type="submit"><i class="fas fa-check"></i> Create User</button>
                    <a href="{{ route('users.index') }}" class="secondary" style="text-decoration:none;"><i class="fas fa-times"></i> Cancel</a>
                </div>
            </form>
        </section>
    </main>
</div>
@if (! (file_exists(public_path('hot')) || file_exists(public_path('build/manifest.json'))))
    <script>{!! file_get_contents(resource_path('js/modules.js')) !!}</script>
@endif
</body>
</html>
