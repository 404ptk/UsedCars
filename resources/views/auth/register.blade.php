@include('shared.html')

@include('shared.head', ['pageTitle' => 'Zarejestruj się | UsedCarsPL'])

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const formFields = document.querySelectorAll('input[type="text"], input[type="password"], input[type="mail"], textarea');
        const progressBar = document.querySelector('.progress-bar');
        const submitButton = document.querySelector('input[type="submit"]');
        const emailField = document.getElementById('mail');

        formFields.forEach(field => {
            field.addEventListener('input', updateProgressBar);
        });

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(String(email).toLowerCase());
        }

        function updateProgressBar() {
            const filledFields = Array.from(formFields).filter(field => field.value.trim() !== '').length;
            const totalFields = formFields.length;
            const progressPercentage = Math.floor((filledFields / totalFields) * 100); 

            progressBar.style.width = progressPercentage + '%';
            progressBar.textContent = progressPercentage + '%';

            const emailValid = validateEmail(emailField.value);
            if (!emailValid) {
                emailField.classList.add('is-invalid');
                emailField.nextElementSibling.textContent = 'Nieprawidłowy email!';
            } else {
                emailField.classList.remove('is-invalid');
                emailField.nextElementSibling.textContent = '';
            }

            if (progressPercentage === 100 && emailValid) {
                submitButton.removeAttribute('disabled');
            } else {
                submitButton.setAttribute('disabled', 'disabled');
            }
        }

        const form = document.querySelector('form');
        form.addEventListener('reset', function() {
            progressBar.style.width = '0%';
            progressBar.textContent = '0%';
            submitButton.setAttribute('disabled', 'disabled');
        });
    });
</script>
<body>
    @include('shared.navbar')

    <div class="container mt-5 mb-5">

        @include('shared.session-error')

        <div class="row mt-4 mb-4 text-center">
            <h1>Zarejestruj się</h1>
        </div>

        @include('shared.validation-error')

        <div class="row d-flex justify-content-center">
            <div class="col-10 col-sm-10 col-md-6 col-lg-4">
                <form method="POST" action="{{ route('register.authenticate') }}" class="needs-validation" novalidate>
                    <div class="p-3 mb-2 bg-light border border-4 rounded">
                        @csrf
                        <div class="form-group mb-2">
                            <label for="name" class="form-label">Imię</label>
                            <input id="name" name="name" type="text"
                                class="form-control @if ($errors->first('name')) is-invalid @endif"
                                value="{{ old('name') }}"
                                placeholder="Imię">
                            <div class="invalid-feedback">Nieprawidłowe imię!</div>
                        </div>
                        <div class="form-group mb-2">
                            <label for="surname" class="form-label">Nazwisko</label>
                            <input id="surname" name="surname" type="text"
                                class="form-control @if ($errors->first('surname')) is-invalid @endif"
                                value="{{ old('surname') }}"
                                placeholder="Nazwisko">
                            <div class="invalid-feedback">Nieprawidłowe nazwisko!</div>
                        </div>
                        <div class="form-group mb-2">
                            <label for="username" class="form-label">Nazwa użytkownika</label>
                            <input id="username" name="username" type="text"
                                class="form-control @if ($errors->first('username')) is-invalid @endif"
                                value="{{ old('username') }}"
                                placeholder="Nazwa użytkownika">
                            <div class="invalid-feedback">Nieprawidłowe nazwisko!</div>
                        </div>
                        <div class="form-group mb-2">
                            <label for="mail" class="form-label">Email</label>
                            <input id="mail" name="mail" type="mail"
                                class="form-control @if ($errors->first('mail')) is-invalid @endif"
                                value="{{ old('mail') }}"
                                placeholder="Email">
                            <div class="invalid-feedback">Nieprawidłowy email!</div>
                        </div>
                        <div class="form-group mb-2">
                            <label for="password" class="form-label">Hasło</label>
                            <input id="password" name="password" type="password"
                                class="form-control @if ($errors->first('password')) is-invalid @endif"
                                placeholder="Hasło">
                            <div class="invalid-feedback">Nieprawidłowe hasło!</div>
                        </div>
                        <div class="form-group mb-2">
                            <label for="password_confirmation" class="form-label">Powtórz hasło</label>
                            <input id="password_confirmation" name="password_confirmation" type="password"
                                class="form-control @if ($errors->first('password_confirmation')) is-invalid @endif"
                                placeholder="Powtórz hasło">
                            <div class="invalid-feedback">Nieprawidłowe hasło lub hasła!</div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                        </div>
                        <div class="text-center mt-4">
                            <input class="btn btn-dark" type="submit" value="Wyślij" disabled>
                        </div>
                    </div>
                </form>
                <span>
                    Masz już konto?<br>
                    <a href="{{ route('login.authenticate') }}" class="text-dark">Kliknij tutaj aby się zalogować!</a>
                </span>
            </div>
        </div>
    </div>

    @include('shared.footer')
</body>
</html>

