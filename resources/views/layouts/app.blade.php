<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Gestion Absences') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            color: white;
            transition: all 0.3s;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            margin: 0.2rem 1rem;
            transition: all 0.2s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.1);
            color: white;
        }
        .sidebar .nav-link i {
            width: 24px;
        }
        .main-content {
            width: 100%;
        }
        .navbar-top {
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="antialiased">
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar py-3 d-none d-md-block" style="width: 250px;">
            <div class="px-4 mb-4 text-center">
                <h4 class="fw-bold mb-0 text-white">OFPPT</h4>
                <small class="text-muted">Gestion Absences</small>
            </div>
            
            <ul class="nav flex-column">
                @role('admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="fa-solid fa-chart-pie"></i> Tableau de bord
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.poles.*') ? 'active' : '' }}" href="{{ route('admin.poles.index') }}">
                            <i class="fa-solid fa-building"></i> Pôles
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.formateurs.*') ? 'active' : '' }}" href="{{ route('admin.formateurs.index') }}">
                            <i class="fa-solid fa-chalkboard-user"></i> Formateurs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.groupes.*') ? 'active' : '' }}" href="{{ route('admin.groupes.index') }}">
                            <i class="fa-solid fa-users"></i> Groupes
                        </a>
                    </li>
                @endrole

                @role('gs')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('gs.dashboard') ? 'active' : '' }}" href="{{ route('gs.dashboard') }}">
                            <i class="fa-solid fa-chart-pie"></i> Tableau de bord
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('gs.groupes') ? 'active' : '' }}" href="{{ route('gs.groupes') }}">
                            <i class="fa-solid fa-users"></i> Mes Groupes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('gs.stagiaires') ? 'active' : '' }}" href="{{ route('gs.stagiaires') }}">
                            <i class="fa-solid fa-user-graduate"></i> Stagiaires
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('gs.alerts') ? 'active' : '' }}" href="{{ route('gs.alerts') }}">
                            <i class="fa-solid fa-bell"></i> Alertes
                        </a>
                    </li>
                @endrole

                @role('formateur')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('formateur.dashboard') ? 'active' : '' }}" href="{{ route('formateur.dashboard') }}">
                            <i class="fa-solid fa-chart-pie"></i> Tableau de bord
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('formateur.seances.*') ? 'active' : '' }}" href="{{ route('formateur.seances.index') }}">
                            <i class="fa-solid fa-calendar-days"></i> Mes Séances
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('formateur.historique') ? 'active' : '' }}" href="{{ route('formateur.historique') }}">
                            <i class="fa-solid fa-clock-rotate-left"></i> Historique
                        </a>
                    </li>
                @endrole
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light navbar-top px-4 py-3">
                <div class="container-fluid">
                    <button class="btn btn-light d-md-none me-3" type="button">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    
                    <div class="d-flex ms-auto align-items-center">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle d-flex align-items-center gap-2" type="button" id="userMenu" data-bs-toggle="dropdown">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span class="d-none d-md-block">{{ Auth::user()->name }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fa-solid fa-user me-2"></i> Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Déconnexion
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
