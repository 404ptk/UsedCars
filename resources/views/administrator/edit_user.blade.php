@include('shared.html')

@include('shared.head', ['pageTitle' => 'Edycja użytkownika'])

<body>
    @include('shared.navbar')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="container mt-5">
    <h1 class="text-center">Edycja użytkownika</h1>
    <h2 class="text-center">{{ $user->username }}</h2>
    <form action="{{ route('update_user', ['id' => $user->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="bg-dark rounded p-5 pt-3 d-flex row justify-content-center text-white">
            <div class="form-group mt-1">
                <label for="name">Imię:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
            </div>
            <div class="form-group mt-1">
                <label for="surname">Nazwisko:</label>
                <input type="text" class="form-control" id="surname" name="surname" value="{{ $user->surname }}">
            </div>
            <div class="form-group mt-1">
                <label for="mail">Adres email:</label>
                <input type="email" class="form-control" id="mail" name="mail" value="{{ $user->mail }}">
            </div>
            <div class="form-group mt-1">
                <label for="username">Nazwa użytkownika:</label>
                <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}" readonly>
            </div>
            <button type="submit" class="btn btn-light mt-4 w-25"><i class="fa-solid fa-floppy-disk"></i> Zapisz zmiany</button>
        </div>
    </form>

    <div class="mt-5">
        <h3 class="text-center">Aukcje użytkownika</h3>
        <div class="row justify-content-center">
            @foreach ($user->cars as $car)
            <div class="col-md-4 mb-4 bg-dark p-2 rounded m-2">
                <div class="card position-relative">
                    <div class="card-body">
                        <h5 class="card-title bg-dark text-white p-1 text-center">{{ $car->name }}</h5>
                        <img class="card-img-top" src="{{ $car->image ? asset('images/' . $car->image) : asset('images/auto2.png') }}" alt="Zdjęcie samochodu" style="">
                        <span class="card-text"><b>Cena wywoławcza:</b> {{ $car->price }} zł</span><br>
                        <span class="card-text"><b>Marka:</b> {{ $car->brand }}</span><br>
                        <span class="card-text"><b>Silnik:</b> {{ $car->engine }}</span><br>
                        <span class="card-text"><b>Pojemność:</b> {{ $car->capacity }}</span><br>
                        <span class="card-text"><b>Moc:</b> {{ $car->hp }} KM</span><br>
                        <span class="card-text"><b>Przebieg:</b> {{ $car->mileage }} km</span><br>
                        <span class="card-text"><b>Stan:</b> {{ $car->condition }}</span><br>
                        <span class="card-text"><b>Skrzynia:</b> {{ $car->gearbox }}</span><br>
                        <span class="card-text"><b>Kolor:</b> {{ $car->color }}</span><br>
                        <span class="card-text"><b>Napęd:</b> {{ $car->drive }}</span><br>
                        <span class="card-text"><b>Nadwozie:</b> {{ $car->body }}</span><br>
                        <span class="card-text"><b>VIN:</b> {{ $car->vin }}</span><br>
                        <span class="card-text"><b>Lokalizacja:</b> {{ $car->localization }}</span><br>
                        <span class="card-text"><b>Kraj pochodzenia:</b> {{ $car->country_of_origin }}</span><br>
                        <span class="card-text"><b>Data produkcji:</b> {{ $car->production_date }}</span><br>
                        <span class="card-text"><b>Data pierwszej rejestracji:</b> {{ $car->first_registration }}</span><br>
                        <span class="card-text"><b>Opis:</b><br></span> 
                        <span class="card-text">{{ $car->description }}</span>
                    </div>
                    <div class="card-footer bg-dark text-center d-flex column justify-content-around">
                        <form action="{{ route('profile.auction-delete', ['id' => $car->id]) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fa-solid fa-trash"></i> Usuń aukcję
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@include('shared.footer')
<script>
        document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var alert = document.querySelector('.alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
                setTimeout(function() {
                    alert.remove();
                }, 150);
            }
        }, 5000);
    });
    </script>
</body>