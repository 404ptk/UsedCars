@include('shared.html')

@include('shared.head', ['pageTitle' => 'Dodaj aukcje | UsedCarsPL'])

<body>
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
    @include('shared.navbar')
    <div class="container mt-2 mb-5">
        @include('shared.session-error')
        @include('shared.validation-error')
        <div class="row mt-4 mb-4 text-center">
            <h1>Dodaj aukcje</h1>
        </div>
        <form id="auctionForm" method="POST" action="{{ route('auctions.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="p-3 mb-2 bg-light border border-4 rounded row d-flex justify-content-center">
                <div class="row d-flex justify-content-center">
                    <div class="col-10 col-sm-10 col-md-6 col-lg-4">
                        <div class="form-group mb-4">
                            <label for="name">Nazwa samochodu</label>
                            <input type="text" class="form-control" id="name" name="name" required placeholder="np. Opel Astra GTC 1.6">
                        </div>
                    </div>
                </div>
                <h4 class="text-center mt-2">Wypełnienie danych na temat samochodu</h4>
                
                <div class="row d-flex justify-content-center">
                    <div class="col-12 col-sm-10 col-md-4 mb-2">
                        <div class="form-group mb-2">
                            <label for="brand">Marka</label>
                            <input type="text" class="form-control" id="brand" name="brand" required placeholder="np. Mercedes">
                        </div>
                    </div>
                    <div class="col-12 col-sm-10 col-md-4 mb-2">
                        <div class="form-group mb-2">
                            <label for="capacity">Pojemność silnika</label>
                            <input type="number" class="form-control" id="capacity" name="capacity" min="0" required placeholder="np. 1600">
                        </div>
                    </div>
                    <div class="col-12 col-sm-10 col-md-4 mb-2">
                        <div class="form-group mb-2">
                            <label for="engine">Silnik</label>
                            <input type="text" class="form-control" id="engine" name="engine" required placeholder="np. 16V">
                        </div>
                    </div>
                </div>

                <div class="row d-flex justify-content-center">
                    <div class="col-12 col-sm-10 col-md-4 mb-2">
                        <div class="form-group mb-2">
                            <label for="hp">Moc</label>
                            <input type="number" class="form-control" id="hp" name="hp" required placeholder="np. 115">
                        </div>
                    </div>
                    <div class="col-12 col-sm-10 col-md-4 mb-2">
                        <div class="form-group mb-2">
                            <label for="mileage">Przebieg</label>
                            <input type="number" class="form-control" id="mileage" name="mileage" required placeholder="np. 169300">
                        </div>
                    </div>
                    <div class="col-12 col-sm-10 col-md-4 mb-2">
                        <div class="form-group mb-2">
                            <label for="gearbox">Skrzynia biegów</label>
                            <input type="text" class="form-control" id="gearbox" name="gearbox" required placeholder="np. Manualna">
                        </div>
                    </div>
                </div>

                <div class="row d-flex justify-content-center">
                    <div class="col-12 col-sm-10 col-md-4 mb-2">
                        <div class="form-group mb-2">
                            <label for="drive">Napęd</label>
                            <input type="text" class="form-control" id="drive" name="drive" required placeholder="np. FWD">
                        </div>
                    </div>
                    <div class="col-12 col-sm-10 col-md-4 mb-2">
                        <div class="form-group mb-2">
                            <label for="condition">Stan</label>
                            <input type="text" class="form-control" id="condition" name="condition" required placeholder="np. Używany">
                        </div>
                    </div>
                    <div class="col-12 col-sm-10 col-md-4 mb-2">
                        <div class="form-group mb-2">
                            <label for="vin">VIN</label>
                            <input type="text" class="form-control" id="vin" name="vin" required placeholder="np. W0L0TGF4835167621">
                        </div>
                    </div>
                </div> 

                <div class="row d-flex justify-content-center">
                    <div class="col-12 col-sm-10 col-md-4 mb-2">
                        <div class="form-group mb-2">
                            <label for="color">Kolor</label>
                            <input type="text" class="form-control" id="color" name="color" required placeholder="np. Czerwony">
                        </div>
                    </div>
                    <div class="col-12 col-sm-10 col-md-4 mb-2">
                        <div class="form-group mb-2">
                            <label for="body">Rodzaj nadwozia</label>
                            <input type="text" class="form-control" id="body" name="body" required placeholder="np. Hatchback">
                        </div>
                    </div>
                    <div class="col-12 col-sm-10 col-md-4 mb-2">
                        <div class="form-group mb-2">
                            <label for="localization">Lokalizacja</label>
                            <input type="text" class="form-control" id="localization" name="localization" required placeholder="np. Rzeszów, Podkarpackie">
                        </div>
                    </div>
                
                <div class="row d-flex justify-content-center">
                    <div class="col-12 col-sm-10 col-md-4 mb-2">
                        <div class="form-group mb-2">
                            <label for="country_of_origin">Kraj pochodzenia</label>
                            <input type="text" class="form-control" id="country_of_origin" name="country_of_origin" required placeholder="np. Niemcy">
                        </div>
                    </div>
                    <div class="col-12 col-sm-10 col-md-4 mb-2">
                        <div class="form-group mb-2">
                            <label for="production_date">Data produkcji</label>
                            <input type="date" class="form-control" id="production_date" name="production_date" required max="{{ date('Y-m-d') }}">
                        </div>
                    </div>    
                    <div class="col-12 col-sm-10 col-md-4 mb-2">
                        <div class="form-group mb-2">
                            <label for="first_registration">Pierwsza rejestracja</label>
                            <input type="date" class="form-control" id="first_registration" name="first_registration" required max="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </div>  

                <div class="row d-flex justify-content-center">
                    <div class="col-10 col-sm-10 col-md-6 col-lg-4">
                        <div class="form-group mb-4">
                            <label for="image">Zdjęcie poglądowe</label>
                            <input type="file" class="form-control" id="image" name="image" required accept="image/*">
                        </div>
                    </div>
                </div>

                <span class="text-center text-danger mb-2">
                    <b>UWAGA!</b> Upewnij się że dobrze wypełniłeś dane, każda pomyłka może wpływać na sprzedaż!
                </span>
                <div class="d-flex flex-column justify-content-center align-items-center">            
                    <div class="form-group mb-2">
                        <label for="description">Opis</label>
                        <textarea type="textarea" class="form-control" id="description" name="description" rows="8" cols="50" required placeholder="Napisz tu najważniejsze informacje na temat samochodu, np. co jest do wymiany, co zostało zrobione itd. MINIMUM 10 ZNAKÓW!"></textarea>
                    </div>      
                    <div class="form-group mb-2">
                        <label for="price">Cena wywoławcza</label>
                        <input type="number" class="form-control" id="price" name="price" min="100" required placeholder="np. 6800">
                    </div> 
                    <div class="form-group mb-2 text-center mt-2">
                        <button type="submit" class="btn btn-dark" disabled>Dodaj aukcję</button>
                    </div>   
                </div> 
            </div>
        </form>
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
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('auctionForm');
            const submitBtn = form.querySelector('button[type="submit"]');

            form.addEventListener('input', function() {
                const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
                let isValid = true;
                
                inputs.forEach(function(input) {
                    if (!input.value.trim()) {
                        isValid = false;
                    }
                });

                if (isValid) {
                    submitBtn.removeAttribute('disabled');
                } else {
                    submitBtn.setAttribute('disabled', 'disabled');
                }
            });

            const restrictInput = (event) => {
                const newValue = event.target.value.replace(/\d/g, '');
                if (newValue !== event.target.value) {
                    event.target.value = newValue;
                }
            };

            const fieldsToRestrict = [
                'gearbox', 
                'country_of_origin', 
                'localization', 
                'color', 
                'condition', 
                'drive',
                'body'
            ];

            fieldsToRestrict.forEach(id => {
                const inputField = document.getElementById(id);
                inputField.addEventListener('input', restrictInput);
            });

        });
    </script>
</body>

