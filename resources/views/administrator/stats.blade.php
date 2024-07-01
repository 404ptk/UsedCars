@include('shared.html')

@include('shared.head', ['pageTitle' => 'Statystki | UsedCarsPL'])
<body>
    @include ('shared.navbar')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="container">
        <div class="card mb-4">
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item text-center bg-dark text-white">Statystyki strony | UsedCarsPL</li>
                    <li class="list-group-item">Łączna liczba aukcji: {{ $totalAuctions }}</li>
                    <li class="list-group-item">Łączna liczba użytkowników: {{ $totalUsers }}</li>
                    <li class="list-group-item">Łączna liczba licytacji: {{ $totalBids }}</li>
                    <li class="list-group-item">Najwyższa kwota złożona na aukcji: {{ number_format($highestBid) }} PLN</li>
                </ul>
            </div>
        </div>
    </div>
<!--
<script src="{{ mix('js/app.js') }}"></script>
-->
<script type="module" src="{{ mix('resources/js/app.js') }}"></script>
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
@include ('shared.footer')
</body>
