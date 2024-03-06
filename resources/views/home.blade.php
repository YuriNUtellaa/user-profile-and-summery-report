@extends('header')
@extends('footer')

<body>
  
  @auth ('admin')

    <section class="main-home">
      <div class="main-text">
          <h5 style="font-size: 20px">SPark</h5>
          <h1 style="color: rgb(74, 83, 118)">Smart Parking <br></h1>
          <h1>SYSTEM 2024</h1>
          <p>Advanced renting system!</p>

          <a href="/slots-control-admin" class="main-btn">Controls! <i class='bx bxs-chevron-right'></i></a>
      </div>
    </section>

  @else

      @auth

        <section class="main-home">
          <div class="main-text">
              <h5 style="font-size: 20px">SPark</h5>
              <h1 style="color: rgb(74, 83, 118)">Smart Parking <br></h1>
              <h1>SYSTEM 2024</h1>
              <p>Advanced renting system!</p>

              <a href="/" class="main-btn">Rent Now! <i class='bx bxs-chevron-right'></i></a>
          </div>
        </section>

      @else

        <section class="main-home">
          <div class="main-text">
              <h5 style="font-size: 20px">SPark</h5>
              <h1 style="color: rgb(74, 83, 118)">Smart Parking <br></h1>
              <h1>SYSTEM 2024</h1>
              <p>Advanced renting system!</p>

              <a href="/" class="main-btn">Rent Now! <i class='bx bxs-chevron-right'></i></a>
          </div>
        </section>


      @endauth

  @endauth


</body>
</html>