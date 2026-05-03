<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Higa IMS')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f8f9fa; }
        .navbar { background: #2c5f2d; }
        .navbar-brand { color: #ffc107 !important; font-weight: bold; }
        .sidebar { min-height: 100vh; background: #343a40; }
        .sidebar a { color: #fff; text-decoration: none; padding: 10px 15px; display: block; }
        .sidebar a:hover { background: #495057; }
        .card { border: none; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    @auth
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <img src="{{ asset('higalog.jpg') }}" height="30" class="d-inline-block align-top me-2" style="height:30px">
                Higa AgriBusiness IMS
            </a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3">{{ auth()->user()->name }}</span>
                <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-light me-2">
                    <i class="fas fa-user"></i> Profile
                </a>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('users.index') }}" class="btn btn-sm btn-warning me-2">
                    <i class="fas fa-users"></i> Users
                </a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-light">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>
    @endauth
    
    <div class="container-fluid">
        @yield('content')
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
