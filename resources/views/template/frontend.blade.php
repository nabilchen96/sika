<!DOCTYPE html>
<html lang="en">

<head>
  <title>Sistem Informasi Ketarunaan dan Alumni</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{ asset('frontend/vendors/owl-carousel/css/owl.carousel.min.css') }} ">
  <link rel="stylesheet" href="{{ asset('frontend/vendors/owl-carousel/css/owl.theme.default.css') }} ">
  <link rel="stylesheet" href="{{ asset('frontend/vendors/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/vendors/aos/css/aos.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/style.min.css') }}">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
  @stack('style')
  <style>
    .contact-us .contact-us-bgimage {
      padding: 20px !important;
      border-radius: 15px;
    }

    .card.card-body {
      padding: 0;
    }

    .features-overview .content-header {
      padding: 0;
    }

    .navbar {
      padding: 18px 0;
    }

    .font-weight-semibold {
      padding-top: 50px;
    }

    .img-proporsional {
      float: center;
      width: 100%;
      height: 200px;
      object-fit: cover;
      transition: all 0.3s ease;
    }

    .img-proporsional:hover,
    .img-proporsional:focus {
      transform: scale(1.1);
    }

    @media only screen and (max-width: 800px) {
       .card .card-body{
        padding: 0 0 43px 0;
      }

      .sika-map{
        margin-bottom: 30px;
      }

      .sika-map iframe{
        height: 320px;
      }
      .sika-description h1{
        font-size: 25px;
      }

      .web-title{
        display: none;
      }

      .btn-contact-us{
        margin-left: 0 !important;
      }
      .close-icon{
        margin-right: 20px;
      }

      .kuesioner img{
        display: none;
      }

      .card-kuesioner{
        margin: 20px;
      }

      .detail-news-image{
        height: 250px !important;
      }

      /* .icon-image{
        height: 30%;
      } */
    }
  </style>
</head>

<body id="body" data-spy="scroll" data-target=".navbar" data-offset="100">
  <header id="header-section">
    <nav class="navbar navbar-expand-lg pl-3 pl-sm-0" id="navbar">
      <div class="container" data-aos="fade-down">
        <div class="navbar-brand-wrapper d-flex w-100">
          <img class="icon-image" src="{{ asset('frontend/images/logo.png') }}" style="width: 23%;" alt="">
          <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="mdi mdi-menu navbar-toggler-icon"></span>
          </button>
          <p class="web-title" style="font-size: 14px; margin-top: 15px;">
            <strong> Pusat Pengembangan Karakter</strong>
            <br>Poltekbang Palembang</p>
        </div>
        <div class="collapse navbar-collapse navbar-menu-wrapper" id="navbarSupportedContent">
          <ul class="navbar-nav align-items-lg-center align-items-start ml-auto right">
            <li class="d-flex align-items-center justify-content-between pl-4 pl-lg-0">
              <div class="navbar-collapse-logo">
                {{-- <img src="{{ asset('frontend/images/Group2.svg') }}" alt=""> --}}
                <img src="{{ asset('frontend/images/logo.png') }}" style="width: 50%;" alt="">
              </div>
              <button class="navbar-toggler close-button" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="close-icon toggle-icon mdi mdi-close navbar-toggler-icon pl-5"></span>
              </button>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(Request::is('/')) active @endif" href="{{ url('/') }}">Beranda</a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(Request::is('pengumuman')) active @endif" href="{{ url('pengumuman') }}">Pengumuman</a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(Request::is('peraturan')) active @endif"" href="{{ url('peraturan') }}">PT3</a>
            </li>
            {{-- <li class="nav-item">
              <a class="nav-link" href="pelanggaran.html">Prestasi</a>
            </li> --}}
            <li class="nav-item" style="width: 130px;">
              <a class="nav-link @if(Request::is('isikuesioner')) active @endif"" href="{{ url('isikuesioner') }}">Tracer Study</a>
            </li>
            <li class="nav-item btn-contact-us pl-4 pl-lg-0" style="margin-left: 20px;">
              <a href="{{ url('login') }}" class="btn btn-info">
                <span class="mdi mdi-lock"></span> Login</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  @yield('content')

  <script src="{{ asset('frontend/vendors/jquery/jquery.min.js') }}"></script>
  {{-- <script src="{{ asset('frontend/vendors/bootstrap/bootstrap.min.js') }}"></script> --}}
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous">
  </script>
  <script src="{{ asset('frontend/vendors/owl-carousel/js/owl.carousel.min.js') }}"></script>
  {{-- <script src="{{ asset('frontend/vendors/aos/js/aos.js') }}"></script> --}}
  <script src="{{ asset('frontend/js/landingpage.js') }}"></script>
  <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js "></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
  <script>
    $(document).ready(function () {
      $('#example').DataTable();
      $('#example1').DataTable();
      $('#example2').DataTable();
    });
  </script>
</body>

</html>