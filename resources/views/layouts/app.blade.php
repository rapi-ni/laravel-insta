<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | @yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- fontawesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- CSS LINK --}}
    <link rel="stylesheet" href="{{asset('css/style.css')}}">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md gyaru-navbar">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <h1 class="h5">{{ config('app.name') }}</h1>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    {{-- [SOON] Search Bar Here --}}
                    @auth
                        {{-- this will not show up in admin pages --}}
                        @if (!request()->is('admin/*'))
                            <ul class="navbar-nav ms-auto">
                                <form action="{{ route('search') }}" style="width: 300px">
                                    <input type="search" name="search" id="search" class="form-control form-control-sm gyaru-search" placeholder="Search...">
                                </form>
                            </ul>
                        @endif
                    @endauth

                    <!-- Right Side Of Navbar -->
                    
                    <ul class="navbar-nav ms-auto align-items-center gap-2 gyaru-nav-actions">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else

                            {{-- Home --}}
                            <li class="nav-item" title="Home">
                                <a href="{{ route('index') }}" class="nav-link gyaru-nav-icon">
                                    <i class="fa-solid fa-house"></i>
                                </a>
                            </li>
                            
                            {{-- Create Post --}}
                            <li class="nav-item" title="Create Post">
                                <a href="{{ route('post.create') }}" class="nav-link gyaru-nav-icon">
                                    <i class="fa-solid fa-plus"></i>
                                </a>
                            </li>

                            {{-- Account --}}
                            <li class="nav-item dropdown">
                                <button id="account-dropdown" class="btn nav-link gyaru-account-button" data-bs-toggle="dropdown">
                                    @if (Auth::user()->avatar)
                                        <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="rounded-circle gyaru-nav-avatar">
                                    @else
                                        <i class="fa-solid fa-circle-user"></i>
                                    @endif
                                </button>
                                
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="account-dropdown">
                                    {{-- [SOON] Adimin Controllers --}}
                                    {{-- @can('admin') --}}
                                    @if (Gate::allows('admin'))  
                                        <a href="{{ route('admin.users')}}" class="dropdown-item">
                                            <i class="fa-solid fa-user-gear"></i> Admin
                                        </a>
                                        
                                        <hr class="dropdown-driver">
                                    @endif
                                    {{-- @endcan --}}

                                    {{-- Profile --}}
                                    <a href="{{ route('profile.show', Auth::user()->id) }}" class="dropdown-item">
                                        <i class="fa-solid fa-circle-user"></i>Profile
                                    </a>

                                    {{-- Logout --}}
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                        <i class="fa-solid fa-right-from-bracket"></i>{{ __('Logout') }}
                                    </a>
                                    
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-5">
            <div class="container">
                <div class="row justify-content-center">
                    {{-- [SOON] Admin Menu (col-3) --}}
                    @if (request()->is('admin/*'))
                        {{-- checks if the request() URL is() under admin/* --}}
                        <div class="col-3">
                            <div class="list-group">
                                <a href="{{ route('admin.users') }}" class="list-group-item {{request()->is('admin/users') ? 'active' : '' }}">
                                    <i class="fa-solid fa-users"></i> Users
                                </a>
                                <a href="{{ route('admin.posts') }}" class="list-group-item {{request()->is('admin/posts') ? 'active' : '' }}">
                                    <i class="fa-solid fa-newspaper"></i> Posts
                                </a>
                                <a href="{{ route('admin.categories') }}" class="list-group-item {{request()->is('admin/categories') ? 'active' : '' }}">
                                    <i class="fa-solid fa-tags"></i> Categories
                                </a>
                            </div>
                        </div>
                    @endif

                    <div class="col-9">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
