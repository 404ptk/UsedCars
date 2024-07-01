<body>
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<div class="container text-center">
    <h1>Aktualna aukcja</h1>
    @if($auctions->isEmpty())
        <p>Brak dostępnych aukcji.</p>
    @else
        <div class="d-flex row justify-content-center">
            @foreach($auctions as $auction)
                <div class="col-md-4">
                    <div class="card mb-4">
                        @if($auction->car)
                            <img src="{{ asset('images/' . $auction->car->image) }}" class="card-img-top object-fit-cover" alt="{{ $auction->car->name }}">
                        @else
                            <img src="{{ asset('images/default-car.png') }}" class="card-img-top object-fit-cover" alt="Brak obrazka">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $auction->car->name }}</h5>
                            <p class="card-text">Cena: <span id="current-price-{{ $auction->id }}">{{ $auction->current_price }} zł</span></p>
                            <p class="card-text">Lokalizacja: {{ $auction->car->localization }}</p>
                            <p class="card-text">Aukcja użytkownika: {{ App\Models\User::find($auction->car->owner_id)->username }}</p>
                            <p class="card-text">Koniec aukcji o: <b>{{ $currentTimeString }}</b></p>
                            <a href="{{ route('auction.show', $auction->id) }}" class="btn btn-primary">Więcej informacji</a>
                            @if ($nextAuction)
                                <a href="{{ route('auction.show', $nextAuction->id) }}" class="btn btn-dark">Pokaż następną aukcję</a>
                                <div class="d-flex row">
                                    <a>Następne auto:</a>
                                    <a href="{{ route('auction.show', $nextAuction->id) }}"><img src="{{ asset('images/' . $nextAuction->car->image) }}" alt="" class="object-fit-cover rounded border border-3" style="height:60px;width:90px"></a>
                                </div>
                            @else
                                <button class="btn btn-dark" disabled>Brak następnej aukcji</button>
                            @endif
                            <p class="text-danger mt-2">Aby wyświetlić aktualne ceny odśwież stronę!</p>
                            @if (Auth::check())
                                @if (Auth::id() !== $auction->car->owner_id && Auth::user()->role_id !== 1)
                                    <form action="{{ route('auction.bid', $auction->id) }}" method="POST" class="">
                                        @csrf
                                        <div class="form-group">
                                            <label for="amount-{{ $auction->id }}">Kwota licytacji:</label>
                                            <input type="number" name="amount" id="amount-{{ $auction->id }}" class="form-control" required min="{{ $auction->current_price + 100 }}" placeholder="{{ $auction->current_price }} | Minimalna kwota licytacji to +100PLN!" value="{{ $auction->current_price + 100 }}" step="100">
                                        </div>
                                        <button type="submit" class="btn btn-success mt-2">Złóż ofertę</button>
                                    </form>
                                @else
                                    <p class="text-muted">{{ Auth::id() === $auction->car->owner_id ? 'Nie możesz licytować własnego samochodu.' : 'Administratorzy nie mogą licytować aukcji.' }}</p>
                                @endif
                            @else
                                <form action="{{ route('auction.bid', $auction->id) }}" method="POST" class="">
                                    @csrf
                                    <div class="form-group">
                                        <label for="amount-{{ $auction->id }}">Kwota licytacji:</label>
                                        <input type="number" name="amount" id="amount-{{ $auction->id }}" class="form-control" disabled placeholder="Nie jesteś zalogowany.">
                                    </div>
                                    <a href="{{ route('login.authenticate', $auction->id) }}" class="btn btn-success mt-2">Złóż ofertę</a>
                                </form>
                            @endif
                            @if(Auth::user() && Auth::user()->role_id === 1)
                            <div class="card mt-2">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <div class="card-header">
                                            Panel Administratora
                                        </div>
                                        <form action="{{ route('auction.delete-auction', $auction->id) }}" method="POST" class="mt-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Czy na pewno chcesz usunąć tą aukcje?')">Usuń aukcję</button>
                                        </form>
                                        <form action="{{ route('auction.end', $auction->id) }}" method="POST" class="mt-2">
                                            @csrf
                                            <button type="submit" class="btn btn-warning" onclick="return confirm('Czy na pewno chcesz zakończyć tą aukcje?')">Zakończ aukcję</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                            @endif
                            <div>
                                <h6 class="mt-2">Historia:</h6>
                                <ul class="list-group" id="latest-bids-{{ $auction->id }}">
                                    @foreach($auction->bids()->orderBy('created_at', 'desc')->take(3)->get() as $index => $bid)
                                        @if ($bid->user)
                                            <li class="list-group-item {{ $index === 0 ? 'active' : '' }}">
                                                <img src="{{ asset('storage/' . $bid->user->avatar) }}" alt="avatar" style="width:25px; height:25px" class="rounded-circle object-fit-cover"> 
                                                {{ $bid->user->username }} | {{ $bid->amount }} zł
                                            </li>
                                        @else
                                            <li class="list-group-item {{ $index === 0 ? 'active' : '' }}">
                                                <img src="{{ asset('storage/default-avatar.png') }}" alt="default avatar" style="width:25px; height:25px" class="rounded-circle object-fit-cover">
                                                Nieznany użytkownik | {{ $bid->amount }} zł
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@include ('shared.footer')
<!--
<script src="{{ mix('js/app.js') }}"></script>
-->
<script type="module" src="{{ mix('resources/js/app.js') }}"></script>
<script>

    function updateAuctions() {
        @foreach($auctions as $auction)
            const source = new EventSource("/auction/{{ $auction->id }}/events");

            source.addEventListener('AuctionPriceUpdated', (event) => {
                const data = JSON.parse(event.data);

                document.getElementById('current-price-{{ $auction->id }}').innerText = data.current_price + ' zł';

                const latestBidsList = document.getElementById('latest-bids-{{ $auction->id }}');
                latestBidsList.innerHTML = '';
                data.latest_bids.forEach((bid, index) => {
                    const listItem = document.createElement('li');
                    listItem.innerHTML = `
                        <img src="{{ asset('storage/') }}/${bid.user ? bid.user.avatar : 'default-avatar.png'}" alt="avatar" style="width:25px; height:25px" class="rounded-circle">
                        ${bid.user ? bid.user.username : 'Nieznany użytkownik'} | ${bid.amount} zł
                    `;
                    listItem.className = 'list-group-item ' + (index === 0 ? 'active' : '');
                    latestBidsList.appendChild(listItem);
                });
            });
            
        @endforeach
    }
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
