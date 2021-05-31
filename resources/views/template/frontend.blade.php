<!DOCTYPE html>
<html lang="en">

<head>
  <title>Simple landing page</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{ asset('frontend/vendors/owl-carousel/css/owl.carousel.min.css') }} ">
  <link rel="stylesheet" href="{{ asset('frontend/vendors/owl-carousel/css/owl.theme.default.css') }} ">
  <link rel="stylesheet" href="{{ asset('frontend/vendors/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/vendors/aos/css/aos.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/style.min.css') }}">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
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
  </style>
</head>

<body id="body" data-spy="scroll" data-target=".navbar" data-offset="100">
  <header id="header-section">
    <nav class="navbar navbar-expand-lg pl-3 pl-sm-0" id="navbar">
      <div class="container">
        <div class="navbar-brand-wrapper d-flex w-100">
          <img src="{{ asset('frontend/images/logo.png') }}" style="width: 23%;" alt="">
          <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="mdi mdi-menu navbar-toggler-icon"></span>
          </button>
          <p style="font-size: 14px; margin-top: 15px;">
            <strong> Unit Ketarunaan</strong>
          <br>Poltekbang Palembang</p>
        </div>
        <div class="collapse navbar-collapse navbar-menu-wrapper" id="navbarSupportedContent">
          <ul class="navbar-nav align-items-lg-center align-items-start ml-auto right">
            <li class="d-flex align-items-center justify-content-between pl-4 pl-lg-0">
              <div class="navbar-collapse-logo">
                <img src="{{ asset('frontend/images/Group2.svg') }}" alt="">
              </div>
              <button class="navbar-toggler close-button" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="mdi mdi-close navbar-toggler-icon pl-5"></span>
              </button>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/') }}">Beranda</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('pengumuman') }}">Pengumuman</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('peraturan') }}">PT3</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pelanggaran.html">Prestasi</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pelanggaran.html">Kuesioner</a>
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
  <script src="{{ asset('frontend/vendors/bootstrap/bootstrap.min.js') }}"></script>
  <script src="{{ asset('frontend/vendors/owl-carousel/js/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('frontend/vendors/aos/js/aos.js') }}"></script>
  <script src="{{ asset('frontend/js/landingpage.js') }}"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js "></script>
  <script>
      $(document).ready(function () {
          $('#example').DataTable();
          $('#example1').DataTable();
      });
  </script>
</body>

</html>