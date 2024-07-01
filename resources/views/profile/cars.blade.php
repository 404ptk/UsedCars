@include('shared.html')

@include('shared.head', ['pageTitle' => 'Moje samochody | UsedCarsPL'])

<body>
    @include('shared.navbar')
    <div class="mt-3" style="width:98%">
        <h3 class="text-center">Twoje samochody</h3>
        <div class="row justify-content-center">
            @foreach ($user->cars as $car)
            <div class="col-md-4 mb-4 bg-dark p-2 rounded m-2 object-fit-cover">
                <div class="card position-relative">
                    <img src="{{ asset('images/' . $car->image) }}" class="card-img-top" alt="{{ $car->name }}">
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item text-center bg-dark text-white"><b>{{ $car->name }}</b></li>
                                <li class="list-group-item">Marka: <b>{{ $car->brand }}</b></li>
                                <li class="list-group-item">Silnik: <b>{{ $car->engine }}</b></li>
                                <li class="list-group-item">Pojemność: <b>{{ $car->capacity }} cm3</b></li>
                                <li class="list-group-item">Moc: <b>{{ $car->hp }} KM</b></li>
                                <li class="list-group-item">Przebieg: <b>{{ $car->mileage }} km</b></li>
                                <li class="list-group-item">Stan: <b>{{ $car->condition }}</b></li>
                                <li class="list-group-item">Skrzynia: <b>{{ $car->gearbox }}</b></li>
                                <li class="list-group-item">Kolor: <b>{{ $car->color }}</b></li>
                                <li class="list-group-item">Napęd: <b>{{ $car->drive }}</b></li>
                                <li class="list-group-item">Nadwozie: <b>{{ $car->body }}</b></li>
                                <li class="list-group-item">VIN: <b>{{ $car->vin }}</b></li>
                                <li class="list-group-item">Lokalizacja: <b>{{ $car->localization }}</b></li>
                                <li class="list-group-item">Kraj pochodzenia: <b>{{ $car->country_of_origin }}</b></li>
                                <li class="list-group-item">Data produkcji: <b>{{ $car->production_date }}</b></li>
                                <li class="list-group-item">Data pierwszej rejestracji: <b>{{ $car->first_registration }}</b></li>
                            </ul>
                        </div>
                        <!--<a href="{{ route('mainpage') }}" class="btn btn-dark">Edytuj</a>-->
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @include('shared.footer')
</body>
