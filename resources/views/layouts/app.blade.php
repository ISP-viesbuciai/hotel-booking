<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    @yield('styles')
</head>

<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">Viešbučių rezervacija</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">Pagrindinis</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/contact') }}">Susisiekite su mumis</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/email') }}">Parašykite laišką</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/chatList') }}">Pokalbių sąrašas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/reviews') }}">Atsiliepimai</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/my-reviews') }}">Jūsų atsiliepimai</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/rooms') }}">Kambariai</a>
                </li>
                @auth
                    @if (Auth::user()->is_admin)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.reservations.index') }}">Rezervacijos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.users.index') }}">Visų vartotojų atsiliepimai</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/profile/edit') }}">Profilio redagavimas</a>
                    </li>
                    <li class="nav-item">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Atsijungti
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Prisijungti</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Registruotis</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Main content -->
<div class="container mt-4">
    @yield('content')
</div>
@yield('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
