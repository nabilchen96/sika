@extends('template.frontend')
@section('content')
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
    
  </div>
</div>
@endsection