@extends('template.frontend')
@section('content')
<div class="content-wrapper">
    <div class="container">

      <section class="features-overview" id="features-section" style="padding-top: 50px;">
        <div class="content-header">
          <h2>Pengumuman & Berita</h2>
          <h6 class="section-subtitle text-muted mb-4">
            Pengumuman dan informasi untuk taruna dan alumni
            <br>Politeknik Penerbangan Palembang</h6>
        </div>
        <div class="row">
          <?php
          $data = DB::table('beritas')->paginate(6);  
          ?>
          @foreach ($data as $k => $item)
          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="{{ $k+1 }}00">
            <div class=>
              <div class="card">
                <div class="card-body">
                  <img src="{{  asset('gambar_berita') }}/{{ $item->gambar_utama }}" width="100%" alt="" class="img-fluid mb-3 img-proporsional" style="border-radius: 15px;">
                  <h5 class="card-title">{{ substr($item->judul_berita, 0, 50) }}</h5>
                  <p class="card-text">
                    {{ strip_tags(substr($item->isi_berita, 0, 90)) }}
                  </p>
                  <a href="{{ url('detailberita') }}/{{ $item->id_berita }}" class="btn btn-primary">Detail</a>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        <br>
        <div class="d-flex justify-content-center">
          {{ $data->links() }}
        </div>
      </section>

      <br><br><br>
      <section class="contact-details" id="contact-details-section">
        <div class="row text-center text-md-left">
          <div class="col-12 col-md-6 col-lg-3 grid-margin">
            <img src="{{ asset('frontend/images/logo.png') }}" width="30%" alt="" class="pb-2">
            <div class="pt-2">
              <p class="text-muted m-0">Jl. Adi Sucipto No.3012, Sukodadi, Kec. Sukarami, Palembang, Sumatera Selatan, 30961</p>
              <p class="text-muted m-0">Email: pusbangkar@poltekbangplg.ac.id</p>
              <p class="text-muted m-0">Telpon: 0711-410930</p>
              <p class="text-muted m-0">Fax: 0711-420385</p>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-3 grid-margin">
            <h5 class="pb-2">Sosial Media</h5>
            <div class="d-flex justify-content-center justify-content-md-start">
              <a href="https://www.facebook.com/poltekbangplg/"><span class="mdi mdi-facebook"></span></a>
              <a href="https://twitter.com"><span class="mdi mdi-twitter"></span></a>
              <a href="https://www.instagram.com/poltekbangplg/"><span class="mdi mdi-instagram"></span></a>
              <a href="https://www.youtube.com/channel/UC_AW0-niVg52RtQB5NeG34g"><span class="mdi mdi-youtube-play"></span></a>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-3 grid-margin">
            <h5 class="pb-2">Akses Akademik</h5>
            <a href="https://siakad.poltekbangplg.ac.id">
              <p class="m-0 pt-1 pb-2">Sistem Informasi Akademik</p>
            </a>
            <a href="https://feedeer.poltekbangplg.ac.id:8082">
              <p class="m-0 pt-1 pb-2">Feeder Dikti</p>
            </a>
            <a href="http://sister.poltekbangplg.ac.id/auth/login">
              <p class="m-0 pt-1 pb-2">Sister Dikti</p>
            </a>
            <a href="https://e-learning.poltekbangplg.ac.id/">
              <p class="m-0 pt-1 pb-2">Learning Management System</p>
            </a>
            <a href="https://library.poltekbangplg.ac.id/">
              <p class="m-0 pt-1">Library Management System</p>
            </a>
          </div>
          <div class="col-12 col-md-6 col-lg-3 grid-margin">
            <h5 class="pb-2">Akses Aplikasi Lain</h5>
            <a href="https://sik.dephub.go.id/">
              <p class="m-0 pt-1 pb-2">Sistem Informasi Kepegawaian</p>
            </a>
            <a href="https://esurat.dephub.go.id/site/login">
              <p class="m-0 pt-1 pb-2">E-persuratan</p>
            </a>
            <a href="https://skemaraja.dephub.go.id/">
              <p class="m-0 pt-1 pb-2">Skemaraja</p>
            </a>
            <a href="https://marketing.poltekbangplg.ac.id">
              <p class="m-0 pt-1 pb-2">E-marketing</p>
            </a>
            <a href="https://e-spm.poltekbangplg.ac.id/">
              <p class="m-0 pt-1">Sistem Penjamin Mutu Internal</p>
            </a>
          </div>
        </div>
      </section>
      <footer class="border-top">
        <p class="text-center text-muted pt-4">Copyright © <?php echo date('Y'); ?> Subbag Aktar Politeknik Penerbangan Palembang. 
            Developed by<a
            href="https://www.mustechs.com/" class="px-1">Mustechs</a>All rights reserved.</p>
      </footer>
    </div>
</div>
@endsection