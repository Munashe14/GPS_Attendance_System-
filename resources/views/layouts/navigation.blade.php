<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container">
       <a class="navbar-brand fw-bold text-primary" href="{{ route(Auth::user()->dashboardRoute()) }}">
    QR Attendance System
</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                 <a class="nav-link {{ request()->routeIs(Auth::user()->dashboardRoute()) ? 'active' : '' }}" href="{{ route(Auth::user()->dashboardRoute()) }}">
    Dashboard
</a>
                </li>
            </ul>
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    {{ Auth::user()->username }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">Log Out</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
