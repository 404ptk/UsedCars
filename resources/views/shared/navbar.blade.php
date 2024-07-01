<style>
    .nav-link:hover {
        color: #888888 !important;
        transition: color 0.2s ease-in-out;
    }
</style>

<body class="bg-secondary">
    <nav class="navbar sticky-top navbar-expand-lg bg-dark mb-2">
        <div class="container-fluid">
            <a class="navbar-brand text-primary" href="{{ route('mainpage') }}"><i class="fa-solid fa-car"></i> UsedCarsPL</a>
            <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                @if (Auth::check())
                    @if(Auth::user()->role_id === 1)
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-white">
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('mainpage') ? 'disabled' : 'text-white' }}" aria-current="page" href="{{ Request::routeIs('mainpage') ? '#' : route('mainpage') }}"><i class="fa-solid fa-house"></i> Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('profile.show') ? 'disabled' : 'text-white' }}" href="{{ Request::routeIs('profile.show') ? '#' : route('profile.show') }}"><i class="fa-solid fa-user"></i> Profil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('auctions.create') ? 'disabled' : 'text-white' }}" href="{{ Request::routeIs('auctions.create') ? '#' : route('auctions.create') }}"><i class="fa-solid fa-plus"></i> Dodaj aukcje</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('profile.cars') ? 'disabled' : 'text-white' }}" href="{{ Request::routeIs('profile.cars') ? '#' : route('profile.cars', ['id' => Auth::user()->id]) }}"><i class="fa-solid fa-car-side"></i> Moje samochody</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('administrator.users') ? 'disabled' : 'text-white' }}" href="{{ Request::routeIs('administrator.users') ? '#' : route('administrator.users') }}"><i class="fa-solid fa-users"></i> Zobacz użytkowników</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('administrator.auctions') ? 'disabled' : 'text-white' }}" href="{{ Request::routeIs('administrator.auctions') ? '#' : route('administrator.auctions') }}"><i class="fa-solid fa-wallet"></i> Zobacz aukcję</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('administrator.stats') ? 'disabled' : 'text-white' }}" href="{{ Request::routeIs('administrator.stats') ? '#' : route('administrator.stats') }}"><i class="fa-solid fa-wallet"></i> Statystyki</a>
                            </li>
                        </ul>
                        <a class="nav-item nav-link active text-white" href="{{ route('profile.show') }}">
                            <span class="me-1 text-danger lead">
                                {{ Auth::user()->username }}
                            </span>
                            @if (Auth::user()->is_default_avatar)
                                <img src="{{ url('images/default-avatar.jpg') }}" alt="Default Avatar" class="rounded-circle me-2 object-fit-cover" style="width:30px; height:30px">
                            @else
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar użytkownika" class="rounded-circle me-2 object-fit-cover" style="width:30px; height:30px">
                            @endif
                        </a>
                        <button class="btn btn-primary ms-2">
                            <a class="nav-item nav-link active text-white" href="{{ route('logout') }}">
                                <i class="fa-solid fa-right-from-bracket"></i> Wyloguj
                            </a>
                        </button>
                    @else
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-white">
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('mainpage') ? 'disabled' : 'text-white' }}" aria-current="page" href="{{ Request::routeIs('mainpage') ? '#' : route('mainpage') }}"><i class="fa-solid fa-house"></i> Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('profile.show') ? 'disabled' : 'text-white' }}" href="{{ Request::routeIs('profile.show') ? '#' : route('profile.show') }}"><i class="fa-solid fa-user"></i> Profil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('auctions.create') ? 'disabled' : 'text-white' }}" href="{{ Request::routeIs('auctions.create') ? '#' : route('auctions.create') }}"><i class="fa-solid fa-plus"></i> Dodaj aukcje</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('profile.cars') ? 'disabled' : 'text-white' }}" href="{{ Request::routeIs('profile.cars') ? '#' : route('profile.cars', ['id' => Auth::user()->id]) }}"><i class="fa-solid fa-car-side"></i> Moje samochody</a>
                            </li>
                        </ul>
                        <a class="nav-item nav-link active text-white" href="{{ route('profile.show') }}">
                            <span class="me-1 text-primary lead">
                                {{ Auth::user()->username }}
                            </span>
                            @if (Auth::user()->is_default_avatar)
                                <img src="{{ url('images/default-avatar.jpg') }}" alt="Default Avatar" class="rounded-circle me-2 object-fit-cover" style="width:30px; height:30px">
                            @else
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar użytkownika" class="rounded-circle me-2 object-fit-cover" style="width:30px; height:30px">
                            @endif
                        </a>
                        <button class="btn btn-primary ms-2">
                            <a class="nav-item nav-link active text-white" href="{{ route('logout') }}">
                                <i class="fa-solid fa-right-from-bracket"></i> Wyloguj
                            </a>
                        </button>
                    @endif
                @else
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('mainpage') ? 'disabled' : 'text-white' }}" aria-current="page" href="{{ Request::routeIs('mainpage') ? '#' : route('mainpage') }}"><i class="fa-solid fa-house"></i> Home</a>
                        </li>
                    </ul>
                    <button class="btn btn-primary">
                        <a class="nav-item nav-link active text-white" href="{{ route('login.authenticate') }}">
                            <i class="fa-solid fa-right-to-bracket"></i> Zaloguj
                        </a>
                    </button>
                    <button class="btn btn-primary ms-2">
                        <a class="nav-item nav-link active text-white" href="{{ route('register.authenticate') }}">
                            <i class="fa-solid fa-user-plus"></i> Zarejestruj
                        </a>
                    </button>
                @endif
            </div>
        </div>
    </nav>
</body>
