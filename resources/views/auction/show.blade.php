@include('shared.html')

@include('shared.head', ['pageTitle' => 'Aukcja | UsedCarsPL'])

<body>
    @include('shared.navbar')
    <div class="container mt-4">
        <div class="d-flex justify-content-center row">
            <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="{{ asset('images/' . $auction->car->image) }}" class="card-img-top object-fit-cover" alt="{{ $auction->car->name }}">
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item text-center bg-dark text-white"><b>{{ $auction->car->name }}</b></li>
                                <li class="list-group-item">Numer auta w kolejce:<b> {{ $auction->queue }}</b></li>
                                <li class="list-group-item">Cena wyjściowa: <b><span class="text-danger">{{ $car->price }} zł</span></b></li>
                                <li class="list-group-item">Aktualna cena: <b><span class="text-success" id="current-price-{{ $auction->id }}">{{ $auction->current_price }} zł</span></b></li>
                                <li class="list-group-item">Marka: <b>{{ $auction->car->brand }}</b></li>
                                <li class="list-group-item">Silnik: <b>{{ $auction->car->engine }}</b></li>
                                <li class="list-group-item">Pojemność: <b>{{ $auction->car->capacity }} cm3</b></li>
                                <li class="list-group-item">Moc: <b>{{ $auction->car->hp }} KM</b></li>
                                <li class="list-group-item">Przebieg: <b>{{ $auction->car->mileage }} km</b></li>
                                <li class="list-group-item">Stan: <b>{{ $auction->car->condition }}</b></li>
                                <li class="list-group-item">Skrzynia: <b>{{ $auction->car->gearbox }}</b></li>
                                <li class="list-group-item">Kolor: <b>{{ $auction->car->color }}</b></li>
                                <li class="list-group-item">Napęd: <b>{{ $auction->car->drive }}</b></li>
                                <li class="list-group-item">Nadwozie: <b>{{ $auction->car->body }}</b></li>
                                <li class="list-group-item">VIN: <b>{{ $auction->car->vin }}</b></li>
                                <li class="list-group-item">Lokalizacja: <b>{{ $auction->car->localization }}</b></li>
                                <li class="list-group-item">Kraj pochodzenia: <b>{{ $auction->car->country_of_origin }}</b></li>
                                <li class="list-group-item">Data produkcji: <b>{{ $auction->car->production_date }}</b></li>
                                <li class="list-group-item">Data pierwszej rejestracji: <b>{{ $auction->car->first_registration }}</b></li>
                                <li class="list-group-item">Opis: {{ $auction->car->description }}</li>
                            </ul>
                        </div>
                        <a href="{{ route('mainpage') }}" class="btn btn-dark"><i class="fa-solid fa-house"></i></a>
                        @if ($nextAuction)
                            <a href="{{ route('auction.show', $nextAuction->id) }}" class="btn btn-dark">Następna aukcja <i class="fa-solid fa-arrow-right"></i></a>
                        @else
                            <button class="btn btn-dark" disabled>Brak następnej aukcji <i class="fa-regular fa-circle-xmark"></i></button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @include('shared.footer')
    <script>
        Echo.channel('auction.{{ $auction->id }}')
            .listen('AuctionPriceUpdated', (e) => {
                document.getElementById('current-price').innerText = e.current_price;
            });
    </script>
</body>
