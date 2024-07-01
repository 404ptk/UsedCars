@include('shared.html')

@include('shared.head', ['pageTitle' => 'Profil użytkownika | UsedCarsPL'])

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
                <div class="form-group mb-4">
                    <input type="file" name="avatar" class="btn btn-dark w-25" accept="image/*">
                    <button type="submit" class="btn btn-dark">Zapisz avatar</button>
                </div>
            </form>
            <div class="bg-dark text-white p-2 mt-3 rounded">
                <p><b>Nazwa użytkownika:</b> {{ $user->username }}</p>
                <p><b>Imię:</b> {{ $user->name }}</p>
                <p><b>Nazwisko:</b> {{ $user->surname }}</p>
                <p><b>Adres email:</b> {{ $user->mail }}</p>
                <p><b>Data utworzenia konta:</b> {{ $user->created_at}}</p>
                <div class="bg-light text-dark pt-3 p-1 mt-3 rounded d-flex row align-items-center">
                    <p><b>Ilość aktywnych aukcji:</b> <span class="text-success fs-3 fw-bold">{{ $totalUserAuctions }}</span></p>
                    <p><b>Ilość samochodów do opłacenia:</b> <span class="text-success fs-3 fw-bold">{{ $totalUserCars - $totalUserAuctions }}</span></p>
                    <blockquote class="blockquote text-right">
                        <p class="mb-1">Kwota do zapłacenia:<s> {{ $count }}PLN</s> (1 posiadany samochód = 1% zniżki!)</p>
                        <footer class="blockquote-footer"><cite title="Source Title">Zniżka! {{ $discount }}</cite></footer>
                    </blockquote></p>
                </div>
                <div class="mt-2">
                    <a href="{{ route('profile.auctions', $user->id) }}" class="btn btn-light">Pokaż moje aukcje</a>
                </div>
            </div>
            <div class="d-flex justify-content-around mt-4">
                <button class="btn btn-dark">
                    <a class="active link-underline link-underline-opacity-0 text-white" href="{{ route('profile.edit') }}">
                        Edytuj dane
                    </a>
                </button>
                <button class="btn btn-dark">
                    <a class="active link-underline link-underline-opacity-0 text-white" href="{{ route('logout') }}">
                        Wyloguj
                    </a>
                </button>
            </div>
        </div>
        <!-- <a href="{{ route('logout') }}">Wyloguj</a> -->
    </div>
    @include('shared.footer')
</body>
