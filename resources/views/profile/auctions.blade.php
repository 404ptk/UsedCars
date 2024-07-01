@include('shared.html')

@include('shared.head', ['pageTitle' => 'Twoje aukcje | UsedCarsPL'])

<body>
    @include('shared.navbar')
    <div class="container mt-2 mb-5">
        <h1 class="text-center">Twoje aukcje</h1>
        <div class="row justify-content-center">
            @if ($user->cars->isNotEmpty())
                @foreach ($user->cars as $car)
                <div class="col-md-4 mb-4 bg-dark p-2 rounded m-2">
                    <div class="card position-relative">
                        <img src="{{ asset('images/' . $car->image) }}" class="card-img-top object-fit-cover" alt="{{ $car->name }}">
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item text-center bg-dark text-white"><b>{{ $car->name }}</b></li>
                                <li class="list-group-item">Cena wyjściowa: <b><span class="text-danger">{{ $car->price }} zł</span></b></li>
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
                                <li class="list-group-item">Opis: {{ $car->description }}</li>
                            </ul>
                        </div>
                        <div class="card-footer bg-dark text-center d-flex column justify-content-around">
                            <button class="btn btn-primary me-2 expand-btn"><i class="fa-solid fa-pen-to-square"></i></button>
                            <form action="{{ route('profile.auction-delete', ['id' => $car->id]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                        <!--
                        <i class="fas fa-times position-absolute bottom-0 end-0 m-3 me-2 fa-2xl" style="color: #e40707;"></i>
                        <i class="fa-solid fa-check position-absolute bottom-0 end-0 m-3 me-2 fa-2xl" style="color: #63E6BE;"></i>
                        <i class="fa-solid fa-hourglass-start position-absolute bottom-0 end-0 m-3 me-2 fa-2xl" style="color: #74C0FC;"></i>
                        -->
                    </div>
                </div>
                @endforeach
            @else

            @endif
        </div>
    </div>
    @include('shared.footer')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const expandButtons = document.querySelectorAll('.expand-btn');
            expandButtons.forEach(btn => {
                btn.addEventListener('click', function () {
                    const info = btn.parentElement.previousElementSibling.querySelector('.additional-info');
                    info.style.display = info.style.display === 'none' ? 'block' : 'none';
                });
            });
        });
    </script>
</body>
