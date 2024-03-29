@extends('template.frontend')
@section('content')
<div class="content-wrapper">
    <div class="container">
        <section class="features-overview" id="features-section" style="padding-top: 50px;">
            <div class="content-header">
                <h2>Peraturan & Tata Tertib Taruna</h2>
                <h6 class="section-subtitle text-muted">Pedoman tentang tata tertib taruna dan anggota dewan kehormatan
                    <br>Politeknik Penerbangan Palembang
                </h6>
            </div>
            <br><br>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                        aria-controls="home" aria-selected="true">Pelanggaran</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                        aria-controls="profile" aria-selected="false">Penghargaan</a>
                </li>
                <li class="nav-item" role="presentation">
                  <a class="nav-link" id="dewan-tab" data-toggle="tab" href="#dewan" role="tab"
                      aria-controls="dewan" aria-selected="false">Dewan Kehormatan</a>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="grid-margin table-responsive">
                        <br>
                        <table id="example" class="table table-striped table-bordered" aria-describedby="tabel">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Pelanggaran</th>
                                    <th scope="col">Kategori Pelanggaran</th>
                                    <th scope="col">Poin Pelanggaran</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 14px;">
                               @foreach ($pelanggaran as $k => $item)
                                   <tr>
                                       <td>{{ $k+1 }}</td>
                                       <td>{{ $item->pelanggaran }}</td>
                                       <td>{{ $item->kategori_pelanggaran }}</td>
                                       <td>{{ $item->poin_pelanggaran }} Poin</td>
                                   </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="table-responsive grid-margin">
                        <br>
                        <table id="example1" class="table table-striped table-bordered" aria-describedby="tabel">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Penghargaan</th>
                                    <th scope="col">Bidang Penghargaan</th>
                                    <th scope="col">Poin Penghargaan</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 14px;">
                                @foreach ($penghargaan as $k => $item)
                                <tr>
                                    <td>{{ $k+1 }}</td>
                                    <td>{{ $item->penghargaan }}</td>
                                    <td>{{ $item->bidang_penghargaan }}</td>
                                    <td>{{ $item->poin_penghargaan }} Poin</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="dewan" role="tabpanel" aria-labelledby="dewan-tab">
                  <div class="grid-margin table-responsive">
                      <br>
                      <table id="example2" class="table table-striped table-bordered" aria-describedby="tabel">
                          <thead>
                              <tr>
                                  <th style="width: 20px;" scope="col">No</th>
                                  <th scope="col">Nama</th>
                                  <th scope="col">Jabatan</th>
                                  <th scope="col">Jabatan Dalam Kepanitiaan</th>
                              </tr>
                          </thead>
                          @php
                            $dewan = DB::table('dewan_kehormatans')->get();
                          @endphp
                          <tbody style="font-size: 14px;">
                              @foreach ($dewan as $k => $item)
                                <tr>
                                  <td style="width: 20px;">{{ $k+1 }}</td>
                                  <td>{{ $item->nama_pejabat }}</td>
                                  <td>{{ $item->jabatan }}</td>
                                  <td>{{ $item->jabatan_kepanitiaan }}</td>
                                </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
            </div>
        </section>

        <br>
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
              <a target="_blank" href="https://www.facebook.com/poltekbangplg/"><span class="mdi mdi-facebook"></span></a>
              <a target="_blank" href="https://twitter.com"><span class="mdi mdi-twitter"></span></a>
              <a target="_blank" href="https://www.instagram.com/poltekbangplg/"><span class="mdi mdi-instagram"></span></a>
              <a target="_blank" href="https://www.youtube.com/channel/UC_AW0-niVg52RtQB5NeG34g"><span class="mdi mdi-youtube-play"></span></a>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-3 grid-margin">
            <h5 class="pb-2">Akses Akademik</h5>
            <a target="_blank" href="https://siakad.poltekbangplg.ac.id">
              <p class="m-0 pt-1 pb-2">Sistem Informasi Akademik</p>
            </a>
            <a target="_blank" href="https://feedeer.poltekbangplg.ac.id:8082">
              <p class="m-0 pt-1 pb-2">Feeder Dikti</p>
            </a>
            <a target="_blank" href="http://sister.poltekbangplg.ac.id/auth/login">
              <p class="m-0 pt-1 pb-2">Sister Dikti</p>
            </a>
            <a target="_blank" href="https://e-learning.poltekbangplg.ac.id/">
              <p class="m-0 pt-1 pb-2">Learning Management System</p>
            </a>
            <a target="_blank" href="https://library.poltekbangplg.ac.id/">
              <p class="m-0 pt-1">Library Management System</p>
            </a>
          </div>
          <div class="col-12 col-md-6 col-lg-3 grid-margin">
            <h5 class="pb-2">Akses Aplikasi Lain</h5>
            <a target="_blank" href="https://sik.dephub.go.id/">
              <p class="m-0 pt-1 pb-2">Sistem Informasi Kepegawaian</p>
            </a>
            <a target="_blank" href="https://esurat.dephub.go.id/site/login">
              <p class="m-0 pt-1 pb-2">E-persuratan</p>
            </a>
            <a target="_blank" href="https://skemaraja.dephub.go.id/">
              <p class="m-0 pt-1 pb-2">Skemaraja</p>
            </a>
            <a target="_blank" href="https://marketing.poltekbangplg.ac.id">
              <p class="m-0 pt-1 pb-2">E-marketing</p>
            </a>
            <a target="_blank" href="https://e-spm.poltekbangplg.ac.id/">
              <p class="m-0 pt-1">Sistem Penjamin Mutu Internal</p>
            </a>
          </div>
        </div>
      </section>
      <footer class="border-top">
        <p class="text-center text-muted pt-4">Copyright © <?php echo date('Y'); ?> Subbag Aktar Politeknik Penerbangan Palembang. 
            Developed by<a
            target="_blank" href="https://sahretech.com" class="px-1">Mustechs</a>All rights reserved.</p>
      </footer>
    </div>
</div>
@endsection