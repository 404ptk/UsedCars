@include('shared.html')

@include('shared.head', ['pageTitle' => 'Edytuj profil | UsedCarsPL'])

<body>
    @include('shared.navbar')
    <div class="container mt-5 mb-5">
        @include('shared.session-error')
        @include('shared.validation-error')
        <div class="bg-light border border-4 rounded p-5 text-center">
            <h1 class="">Witamy cię <b>{{ $user->username }}</b></h1>
            @if (Auth::user()->is_default_avatar)
                <img src="{{ url('images/default-avatar.jpg') }}" alt="Default Avatar" class="rounded-circle mb-3 object-fit-cover" style="width:220px; height:220px">
            @else
                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar użytkownika" class="rounded-circle border border-5 mb-3 object-fit-cover" style="width:220px; height:220px">
            @endif
            <form method="POST" action="{{ route('profile.update-avatar') }}" enctype="multipart/form-data">
                @csrf
                <input type="file" name="avatar" class="btn btn-dark">
                <button type="submit" class="btn btn-dark">Zapisz avatar</button>
            </form>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')
                <div class="bg-dark text-white p-2 mt-3 rounded">
                    <p><b>Nazwa użytkownika:</b> {{ $user->username }}</p>
                    <div class="">
                        <div class="d-flex column align-items-center mb-2">
                            <label for="name"><b>Imię:</b> <i class="fa-solid fa-arrow-right"></i>&nbsp;</label>
                            <input type="text" class="form-control" id="name" name="name"  placeholder="{{ $user->name }}" style="width:15%">
                        </div>
                        <div class="d-flex column align-items-center mb-2">
                            <label for="surname"><b>Nazwisko:</b> <i class="fa-solid fa-arrow-right"></i>&nbsp;</label>
                            <input type="text" class="form-control" id="surname" name="surname"  placeholder="{{ $user->surname }}" style="width:15%">
                        </div>
                        <div class="d-flex column align-items-center mb-2">
                            <label for="mail"><b>Adres email:</b> <i class="fa-solid fa-arrow-right"></i>&nbsp;</label>
                            <input type="email" class="form-control" id="mail" name="mail"  placeholder="{{ $user->mail }}" style="width:15%">
                        </div>
                        <div class="d-flex column align-items-center mb-2">
                            <label for="password"><b>Nowe hasło:</b> <i class="fa-solid fa-arrow-right"></i>&nbsp;</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Nowe hasło" style="width:15%">
                        </div>
                        <div class="d-flex column align-items-center mb-2">
                            <label for="old_password"><b>Podaj stare hasło:</b> <i class="fa-solid fa-arrow-right"></i>&nbsp;</label>
                            <input type="password" class="form-control" id="old_password" name="old_password" required placeholder="Stare hasło" style="width:15%">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-light">Zapisz</button>
                </div>
            </form>
            <p><b>Data utworzenia konta:</b> {{ $user->created_at}}</p>
            <div class="d-flex justify-content-around mt-4">
                <button class="btn btn-dark">
                    <a class="active link-underline link-underline-opacity-0 text-white" href="{{ route('logout') }}">
                        Historia
                    </a>
                </button>
                <button class="btn btn-dark">
                    <a class="active link-underline link-underline-opacity-0 text-white" href="{{ route('profile.show') }}">
                        Powrót
                    </a>
                </button>
                <button class="btn btn-dark">
                    <a class="active link-underline link-underline-opacity-0 text-white" href="{{ route('logout') }}">
                        Wyloguj
                    </a>
                </button>
            </div>
        </div>
    </div>
    @include('shared.footer')
</body>
