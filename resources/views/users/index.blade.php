<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - HigaGroup</title>
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
                <i class="fas fa-users"></i>
                User Management
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

        @if (session('status'))
        <p class="success"><i class="fas fa-check-circle"></i> {{ session('status') }}</p>
        @endif

        <section class="card">
            <div class="form-toolbar">
                <h3><i class="fas fa-users" style="margin-right:6px;color:var(--brand-green-dark)"></i>All Users</h3>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('users.create') }}" class="primary"><i class="fas fa-plus"></i> Add User</a>
                @endif
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        @if(auth()->user()->isAdmin())
                        <th>Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td><i class="fas fa-user" style="margin-right:4px;color:var(--brand-green-dark)"></i> {{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge {{ $user->role?->slug === 'admin' ? 'badge-danger' : ($user->role?->slug === 'production-manager' ? 'badge-warning' : 'badge-info') }}">
                                {{ $user->role?->name ?? 'No Role' }}
                            </span>
                        </td>
                        @if(auth()->user()->isAdmin())
                        <td class="actions">
                            <a href="{{ route('users.edit', $user) }}" class="secondary"><i class="fas fa-pen"></i> Edit</a>
                            @if ($user->id !== auth()->id())
                            <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Delete this user?')" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="danger"><i class="fas fa-trash"></i></button>
                            </form>
                            @endif
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination">{{ $users->links() }}</div>
        </section>
    </main>
</div>
@if (! (file_exists(public_path('hot')) || file_exists(public_path('build/manifest.json'))))
    <script>{!! file_get_contents(resource_path('js/modules.js')) !!}</script>
@endif
</body>
</html>
