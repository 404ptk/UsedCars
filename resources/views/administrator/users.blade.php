@include('shared.html')

@include('shared.head', ['pageTitle' => 'Panel administratora - Użytkownicy | UsedCarsPL'])

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
        <h1 class="text-center">Lista użytkowników</h1>
        <form action="{{ route('administrator.users') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Szukaj użytkowników" value="{{ request('search') }}">
                <button class="btn btn-dark" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </form>
        <div class="rounded table-responsive pt-3 pe-3 ps-3 bg-dark">
            <table class="table table-sm table-striped table-dark table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nazwa użytkownika</th>
                        <th scope="col">Imię</th>
                        <th scope="col">Nazwisko</th>
                        <th scope="col">Adres email</th>
                        <th scope="col">Utworzono</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <th scope="row">{{ $user->id }}</th>
                            <td><img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar użytkownika" class="rounded-circle me-2 object-fit-cover" style="width:30px; height:30px">{{ $user->username }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->surname }}</td>
                            <td>{{ $user->mail }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>
                                <div class="d-flex justify-content-evenly column">
                                    <a href="{{ route('edit_user', ['id' => $user->id]) }}" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <form action="{{ route('delete_user', ['id' => $user->id]) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Czy na pewno chcesz usunąć tego użytkownika?')"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex column justify-content-center mt-3">
                {{ $users->links() }}
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
