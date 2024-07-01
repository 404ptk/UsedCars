@include('shared.html')

@include('shared.head', ['pageTitle' => 'Panel administratora - Aukcje | UsedCarsPL'])

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
    <div class="container mt-5 mb-5">
        <h1 class="text-center">Lista aukcji</h1>
        <form action="{{ route('administrator.auctions') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Szukaj aukcji" value="{{ request('search') }}">
                <button class="btn btn-dark" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </form>
        <div class="rounded table-responsive pt-3 pe-3 ps-3 bg-dark">
            <table class="table table-sm table-striped table-dark table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col"></th>
                        <th scope="col">Nazwa samochodu</th>
                        <th scope="col">Marka</th>
                        <th scope="col">Cena początkowa</th>
                        <th scope="col">Cena aktualna</th>
                        <th scope="col">Nazwa właściciela</th>
                        <th scope="col">Data utworzenia</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($auctions as $auction)
                        <tr>
                            <th scope="row">{{ $auction->id }}</th>
                            <td><img src="{{ asset('images/' . $auction->car->image) }}" alt="" class="card-img-top object-fit-cover rounded" style="height:35px;width:65px"></td>
                            <td>{{ $auction->car->name }}</td>
                            <td>{{ $auction->car->brand }}</td>
                            <td class="text-danger">{{ $auction->car->price }} PLN</td>
                            <td class="text-success">{{ $auction->current_price }} PLN</td>
                            <td>{{ App\Models\User::find($auction->car->owner_id)->username }}</td>
                            <td>{{ $auction->created_at }}</td>
                            <td>
                                <div class="d-flex justify-content-evenly column">
                                    <form action="{{ route('administrator_delete_auctions', ['id' => $auction->id]) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Czy na pewno chcesz usunąć tę aukcję?')"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex column justify-content-center mt-3">
                {{ $auctions->links() }}
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
