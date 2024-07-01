@include('shared.html')

@include('shared.head', ['pageTitle' => 'Zaloguj się | UsedCarsPL'])

<body>
    @include('shared.navbar')

    <div class="container mt-5 mb-5">
        @include('shared.session-error')
        <div class="row mt-4 mb-4 text-center">
            <h1>Zaloguj się</h1>
        </div>
        @include('shared.validation-error')
        <div class="row d-flex justify-content-center">
            <div class="col-10 col-sm-10 col-md-6 col-lg-4">
                <form method="POST" action="{{ route('login.authenticate') }}" class="needs-validation" novalidate>
                    <div class="p-3 mb-2 bg-light border border-4 rounded">
                        @csrf
                        <div class="form-group mb-2">
                            <label for="username" class="form-label">Nazwa użytkownika</label>
                            <input id="username" name="username" type="text" class="form-control @if ($errors->first('username')) is-invalid @endif" value="{{ old('username') }}"
                            placeholder="Nazwa użytkownika">
                            <div class="invalid-feedback">Nieprawidłowa nazwa użytkownika!</div>
                        </div>
                        <div class="form-group mb-2">
                            <label for="continent" class="form-label">Hasło</label>
                            <input id="password" name="password" type="password" class="form-control @if ($errors->first('password')) is-invalid @endif"
                            placeholder="Hasło">
                            <div class="invalid-feedback">Nieprawidłowe hasło!</div>
                        </div>
                        <div class="form-group form-check mb-2">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Zapamiętaj logowanie</label>
                        </div>
                        <div class="text-center mt-4">
                            <input class="btn btn-dark" id="loginButton" type="submit" value="Zaloguj" disabled>
                        </div>
                    </div>
                </form>
                <span>
                    Nie masz konta?<br>
                    <a href="{{ route('register.authenticate') }}" class="text-dark">Kliknij tutaj aby się zarejestrować!</a>
                </span>
            </div>
        </div>
    </div>
    @include('shared.footer')
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const usernameInput = document.getElementById('username');
            const passwordInput = document.getElementById('password');
            const loginButton = document.getElementById('loginButton');

            function validateForm() {
                const usernameValid = usernameInput.value.length >= 4;
                const passwordValid = passwordInput.value.length >= 4;

                if (usernameValid && passwordValid) {
                    loginButton.disabled = false;
                } else {
                    loginButton.disabled = true;
                }
            }

            usernameInput.addEventListener('input', validateForm);
            passwordInput.addEventListener('input', validateForm);
        });
    </script>
</body>

