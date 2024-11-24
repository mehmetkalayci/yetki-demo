<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yönetim Paneli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Uygulama Adı</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('roles.index') }}">Roller</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('permissions.index') }}">İzinler</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">Kullanıcılar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('devices.index') }}">Cihazlar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reports.index') }}">Raporlar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('hospitals.index') }}">Hastaneler</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    @auth
                        @if(auth()->user()->can('view', Device::class))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('devices.index') }}">Cihazlar</a>
                            </li>
                        @endif
                        @if(auth()->user()->can('view', Hospital::class))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('hospitals.index') }}">Hastaneler</a>
                            </li>
                        @endif
                        @if(auth()->user()->can('view', Report::class))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('reports.index') }}">Raporlar</a>
                            </li>
                        @endif
                        @if(auth()->user()->can('manage', Role::class))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('roles.index') }}">Roller</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <span class="navbar-text text-white">
                                {{ auth()->user()->name }}
                            </span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile') }}">Profil</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link">Çıkış</button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="container">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>