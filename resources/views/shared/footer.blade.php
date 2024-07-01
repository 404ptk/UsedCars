<link rel="apple-touch-icon" href="/docs/5.3/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
<link rel="icon" href="/docs/5.3/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
<link rel="icon" href="/docs/5.3/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
<link rel="manifest" href="/docs/5.3/assets/img/favicons/manifest.json">
<link rel="mask-icon" href="/docs/5.3/assets/img/favicons/safari-pinned-tab.svg" color="#712cf9">
<link rel="icon" href="/docs/5.3/assets/img/favicons/favicon.ico">
<script src="https://kit.fontawesome.com/5babc094a0.js" crossorigin="anonymous"></script>
<meta name="theme-color" content="#712cf9">


<link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sidebars/">


<!-- Remove the container if you want to extend the Footer to full width. -->
<div class="container my-5">

  <footer class="bg-dark text-center text-lg-start text-white">
    <!-- Grid container -->
    <div class="container p-4">
      <!--Grid row-->
      <div class="row mt-4 justify-content-center">
        <!--Grid column-->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase">Pomoc</h5>

          <ul class="list-unstyled mb-0">
            <li>
              <a href="{{route('profile.show')}}" class="text-white nav-link"><i class="fa-solid fa-user fa-fw fa-sm me-2"></i>Twoje konto</a>
            </li>
            <li>
              <a href="{{route('mainpage')}}" class="text-white nav-link"><i class="fa-regular fa-money-bill-1 fa-fw fa-sm me-2"></i>Aukcje</a>
            </li>
          </ul>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase">UsedCarsPL</h5>

          <ul class="list-unstyled">
            <li>
              <a class="text-white nav-link"><i class="fa-solid fa-map-pin fa-fw fa-sm me-2"></i>Rzeszów, Polska</a>
            </li>
            <li>
              <a class="text-white nav-link"><i class="fas fa-envelope fa-fw fa-sm me-2"></i>usedcars@help.pl</a>
            </li>
            <li>
              <a class="text-white nav-link"><i class="fa-solid fa-phone fa-fw fa-sm me-2"></i>+48 123 456 678</a>
            </li>
          </ul>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase">Nasze samochody</h5>
          <div id="carCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              @php
                $cars = \App\Models\Car::all();
              @endphp
              @foreach($cars as $index => $car)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                  <img src="{{ asset('images/' . $car->image) }}" class="d-block w-100 rounded object-fit-cover" alt="Car Image">
                </div>
              @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
        <!--Grid column-->
      </div>
      <!--Grid row-->
    </div>
    <!-- Grid container -->

    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
      © 2024 Copyright:
      <a class="text-white" href="{{ route('mainpage') }}">UsedCarsPL</a>
    </div>
    <!-- Copyright -->
  </footer>

</div>
<!-- End of .container -->
