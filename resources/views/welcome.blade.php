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
          <img src="{{ asset('frontend/images/logo.png') }}" style="width: 20%;" alt="">
          <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="mdi mdi-menu navbar-toggler-icon"></span>
          </button>
          <p style="font-size: 14px; margin-top: 10px;">
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
              <a class="nav-link" href="pengumuman.html">Pengumuman</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="prestasi.html">Prestasi</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pelanggaran.html">Pelanggaran</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="tentang.html">Tentang</a>
            </li>
            <li class="nav-item btn-contact-us pl-4 pl-lg-0" style="margin-left: 20px;">
              <button class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
                <span class="mdi mdi-lock"></span> Login</button>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <div class="banner">
    <div class="container">
      <h1 class="font-weight-semibold">Sistem Informasi <br> Ketarunaan & Alumni</h1>
      <!-- <h6 class="font-weight-normal text-muted pb-3">Simple is a simple template with a creative design that solves all your marketing and SEO queries.</h6> -->
      <!-- <div>
        <button class="btn btn-opacity-light mr-1">Get started</button>
        <button class="btn btn-opacity-success ml-1">Learn more</button>
      </div> -->
      <img src="{{ asset('frontend/images/undrawx.png') }}" alt="" class="img-fluid">
      <br><br>
    </div>
  </div>
  <div class="content-wrapper">
    <div class="container">

      <section class="features-overview" id="features-section">
        <div class="content-header">
          <h2>Pengumuman</h2>
          <h6 class="section-subtitle text-muted">One theme that serves as an easy-to-use operational toolkit<br>that
            meets customer's needs.</h6>
        </div>
        <div class="d-md-flex justify-content-between">
          <div class="grid-margin d-flex justify-content-start">
            <div class=>
              <div class="card">
                <div class="card-body">
                  <img src="{{ asset('frontend/images/empty.jpg') }}" width="100%" alt="" class="img-fluid mb-3" style="border-radius: 15px;">
                  <h5 class="card-title">Lowongan Kerja</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                    card's content.</p>
                  <a href="#" class="btn btn-primary">Detail</a>
                </div>
              </div>
            </div>
          </div>
          <div class="grid-margin d-flex justify-content-start">
            <div class=>
              <div class="card">
                <div class="card-body">
                  <img src="{{ asset('frontend/images/empty.jpg') }}" width="100%" alt="" class="img-fluid mb-3" style="border-radius: 15px;">
                  <h5 class="card-title">Pengambilan Ijazah</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                    card's content.</p>
                  <a href="#" class="btn btn-primary">Detail</a>
                </div>
              </div>
            </div>
          </div>
          <div class="grid-margin d-flex justify-content-start">
            <div class=>
              <div class="card">
                <div class="card-body">
                  <img src="{{ asset('frontend/images/empty.jpg') }}" width="100%" alt="" class="img-fluid mb-3" style="border-radius: 15px;">
                  <h5 class="card-title">Beasiswa Ketarunaan</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                    card's content.</p>
                  <a href="#" class="btn btn-primary">Detail</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="contact-us" id="contact-section">
        <div class="contact-us-bgimage grid-margin">
          <div class="row">
            <div class="col p-12">
              <iframe class="embed-responsive"
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15938.708954153537!2d104.6991992!3d-2.9089414!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x5e411b86b9a1b4e9!2sPoliteknik%20Penerbangan%20Palembang!5e0!3m2!1sid!2sid!4v1613966893900!5m2!1sid!2sid"
                height="420" title="poltekbangplg" style="border:0" allowfullscreen></iframe>
            </div>
            <div class="col" style="text-align: left;">
              <h1>Sistem Informasi Ketarunaan dan Alumni</h1>
              <br>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repudiandae fugiat aspernatur quasi totam
                voluptas quidem, ipsum veritatis obcaecati harum! Laudantium minima culpa cupiditate natus, distinctio
                accusantium animi voluptatum dolores. Autem. Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                Blanditiis iure aperiam unde velit id distinctio! Deleniti accusantium perferendis sequi consequuntur
                nihil! Non temporibus dignissimos tempora, asperiores et molestias amet quisquam!</p>
            </div>
          </div>
        </div>
      </section>
      <section class="contact-details" id="contact-details-section">
        <div class="row text-center text-md-left">
          <div class="col-12 col-md-6 col-lg-3 grid-margin">
            <img src="{{ asset('frontend/images/logo.png') }}" width="30%" alt="" class="pb-2">
            <div class="pt-2">
              <p class="text-muted m-0">Jl. Adi Sucipto No.3012, Sukodadi, Kec. Sukarami, Palembang, Sumatera Selatan, 30961</p>
              <p class="text-muted m-0">Email: info@poltekbangplg.ac.id</p>
              <p class="text-muted m-0">Telpon: 0711-410930</p>
              <p class="text-muted m-0">Fax: 0711-420385</p>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-3 grid-margin">
            <h5 class="pb-2">Sosial Media</h5>
            <!-- <p class="text-muted">518 Schmeler Neck<br>Bartlett. Illinois</p> -->
            <div class="d-flex justify-content-center justify-content-md-start">
              <a href="#"><span class="mdi mdi-facebook"></span></a>
              <a href="#"><span class="mdi mdi-twitter"></span></a>
              <a href="#"><span class="mdi mdi-instagram"></span></a>
              <a href="#"><span class="mdi mdi-youtube-play"></span></a>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-3 grid-margin">
            <h5 class="pb-2">Akses Akademik</h5>
            <a href="#">
              <p class="m-0 pt-1 pb-2">Sistem Informasi Akademik</p>
            </a>
            <a href="#">
              <p class="m-0 pt-1 pb-2">Feeder Dikti</p>
            </a>
            <a href="#">
              <p class="m-0 pt-1 pb-2">Sister Dikti</p>
            </a>
            <a href="#">
              <p class="m-0 pt-1 pb-2">Learning Management System</p>
            </a>
            <a href="#">
              <p class="m-0 pt-1">Library Management System</p>
            </a>
          </div>
          <div class="col-12 col-md-6 col-lg-3 grid-margin">
            <h5 class="pb-2">Akses Aplikasi Lain</h5>
            <a href="#">
              <p class="m-0 pt-1 pb-2">Sistem Informasi Kepegawaian</p>
            </a>
            <a href="#">
              <p class="m-0 pt-1 pb-2">E-persuratan</p>
            </a>
            <a href="#">
              <p class="m-0 pt-1 pb-2">Skemaraja</p>
            </a>
            <a href="#">
              <p class="m-0 pt-1 pb-2">E-marketing</p>
            </a>
            <a href="#">
              <p class="m-0 pt-1">Sistem Penjamin Mutu Internal</p>
            </a>
          </div>
        </div>
      </section>
      <footer class="border-top">
        <p class="text-center text-muted pt-4">© Copyright Subbag Aktar Politeknik Penerbangan Palembang. Designed by<a
            href="https://www.bootstrapdash.com/" class="px-1">Bootstrapdash.</a>All rights reserved.</p>
      </footer>
      <!-- Modal for Contact - us Button -->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="exampleModalLabel">Contact Us</h4>
            </div>
            <div class="modal-body">
              <form>
                <div class="form-group">
                  <label for="Name">Name</label>
                  <input type="text" class="form-control" id="Name" placeholder="Name">
                </div>
                <div class="form-group">
                  <label for="Email">Email</label>
                  <input type="email" class="form-control" id="Email-1" placeholder="Email">
                </div>
                <div class="form-group">
                  <label for="Message">Message</label>
                  <textarea class="form-control" id="Message" placeholder="Enter your Message"></textarea>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-success">Submit</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('frontend/vendors/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('frontend/vendors/bootstrap/bootstrap.min.js') }}"></script>
  <script src="{{ asset('frontend/vendors/owl-carousel/js/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('frontend/vendors/aos/js/aos.js') }}"></script>
  <script src="{{ asset('frontend/js/landingpage.js') }}"></script>
</body>

</html>