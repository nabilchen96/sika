@extends('template.frontend')
@section('content')
<div class="content-wrapper">
    <div class="container">

        <section class="features-overview" id="features-section" style="padding-top: 50px;">
            <div class="content-header">
                <h2>Peraturan & Tata Tertib Taruna</h2>
                <h6 class="section-subtitle text-muted">One theme that serves as an easy-to-use operational
                    toolkit<br>that
                    meets customer's needs.</h6>
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
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="grid-margin">
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
                                <tr>
                                    <td>1</td>
                                    <td>Kamar tidur, ruang belajar, kamar mandi dan koridor asrama tidak atau kotor</td>
                                    <td>Pelanggaran Ringan</td>
                                    <td>5 poin</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Tata letak perlengkapan tidak sesuai ketentuan peraturan urusan dinas dalam</td>
                                    <td>Pelanggaran Ringan</td>
                                    <td>5 poin</td>
                                </tr>
                            </tbody>
                        </table>
                        <div>
                            <div class="card">
                                <div class="card-body">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="grid-margin">
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
                                <tr>
                                    <td>1</td>
                                    <td>Peringkat kelas no 1 s/d 5</td>
                                    <td>Akademik</td>
                                    <td>25 poin</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Menang Lomba Cerdas Cermat</td>
                                    <td>Akademik</td>
                                    <td>25 poin</td>
                                </tr>
                            </tbody>
                        </table>
                        <div>
                            <div class="card">
                                <div class="card-body">

                                </div>
                            </div>
                        </div>
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
                        <p class="text-muted m-0">Jl. Adi Sucipto No.3012, Sukodadi, Kec. Sukarami, Palembang,
                            Sumatera Selatan,
                            Kode Pos: 30961</p>
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
            <p class="text-center text-muted pt-4">© Copyright Subbag Aktar Politeknik Penerbangan Palembang.
                Designed by<a href="https://www.bootstrapdash.com/" class="px-1">Bootstrapdash.</a>All rights
                reserved.</p>
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
@endsection