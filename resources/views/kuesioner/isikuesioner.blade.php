@extends('template.frontend')
@section('content')
<div class="content-wrapper">
    <div class="container">

        <section class="features-overview" id="features-section" style="padding-top: 50px;">
            <div class="content-header">
                <h2>Kuesioner Alumni</h2>
                <h6 class="section-subtitle text-muted">One theme that serves as an easy-to-use operational
                    toolkit<br>that
                    meets customer's needs.</h6>
                <br><br>
            </div>

            @if($message = Session::get('sukses'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if (@$nim == null)
            <form action="{{ url('isikuesioner') }}" method="get">
                <div class="card" style="background-color: #f7f8fa; border-radius: 10px;">
                    <div class="row">
                        <div class="col-6">
                            <div class="text-center">
                                <img src="{{ asset('formx.png') }}" style="margin-top: 50px">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nomor Induk Taruna</label>
                                    <input type="text" name="nim" class="form-control"
                                        style="background-color: white; border-radius: 10px;">
                                </div>
                                @if($message = Session::get('gagal'))
                                <p class="text-danger">{{ $message }}</p>
                                @endif
                                <br>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Program Studi</label>
                                    <select name="" class="form-control"
                                        style="background-color: white; border-radius: 10px;">
                                        <option value="">D3 Manajemen Bandar Udara</option>
                                        <option value="">D3 Penyelamatan dan Pemadam Kebakaran</option>
                                        <option value="">D4 Teknologi Rekayasa Bandar Udara</option>
                                    </select>
                                </div>
                                <br>
                                <div class="form-group mt-1">
                                    <label for="exampleInputEmail1">Tanggal Lahir</label>
                                    <input type="date" class="form-control"
                                        style="background-color: white; border-radius: 10px;">
                                </div>
                                <br>
                                <div class="form-group mt-1">
                                    <button type="submit" class="btn btn-sm btn-primary"><i
                                            class="fas fa-search"></i>Cari</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
            <br>
            @endif

            <form action="{{ url('tambahisikuesioner') }}" method="post">
                @csrf
                <input type="hidden" name="id_alumni" value="{{ @$taruna->id_alumni }}">
                <?php $no = 1; ?>
                @foreach ($soal as $k => $item)
                @if($item->jenis_soal == '1')
                <div class="form-group">
                    <div class="card">
                        <div class="card-body p-4" style="background-color: #f7f8fa; border-radius: 10px;">
                            <label for="exampleInputEmail1">{{ $no++ }}. {{ $item->soal }}</label>
                            <input type="hidden" name="{{ $no-1 }}[id_detail_kuesioner]"
                                value="{{ $item->id_detail_kuesioner }}">
                            <br>
                            <?php $jawaban = unserialize($item->jawaban);  ?>
                            @foreach ($jawaban as $i)
                            <div class="form-check mt-1">
                                <input class="form-check-input" type="radio" name="{{ $no-1 }}[jawaban]"
                                    value="{{ $i }}" id="exampleRadios2">
                                <label class="form-check-label" for="inlineCheckbox1">{{ $i }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @elseif($item->jenis_soal == '2')
                <div class="form-group">
                    <div class="card">
                        <div class="card-body p-4" style="background-color: #f7f8fa; border-radius: 10px;">
                            <label for="exampleInputEmail1">{{ $no++ }}. {{ $item->soal }}</label>
                            <input type="hidden" name="{{ $no-1 }}[id_detail_kuesioner]"
                                value="{{ $item->id_detail_kuesioner }}">
                            <br>
                            <textarea name="{{ $no-1 }}[jawaban]" id="" rows="2" class="form-control mt-1"
                                style="background-color: white; border-radius: 10px;"></textarea>
                        </div>
                    </div>
                </div>
                @elseif($item->jenis_soal == '3')
                <div class="form-group">
                    <div class="card">
                        <div class="card-body p-4" style="background-color: #f7f8fa; border-radius: 10px;">
                            <label for="exampleInputEmail1">{{ $no++ }}. {{ $item->soal }}</label>
                            <input type="hidden" name="{{ $no-1 }}[id_detail_kuesioner]"
                                value="{{ $item->id_detail_kuesioner }}">
                            <br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="{{ $no-1 }}[jawaban]" value="Ya"
                                    id="exampleRadios2" value="option2">
                                <label class="form-check-label" for="inlineCheckbox1">Ya</label>
                            </div>
                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="radio" name="{{ $no-1 }}[jawaban]" value="Tidak"
                                    id="exampleRadios2" value="option2">
                                <label class="form-check-label" for="inlineCheckbox1">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
                @elseif($item->jenis_soal == '4')
                <div class="form-group">
                    <div class="card">
                        <div class="card-body p-4" style="background-color: #f7f8fa; border-radius: 10px;">
                            <label for="exampleInputEmail1">{{ $no++ }}. {{ $item->soal }}</label>
                            <input type="hidden" name="{{ $no-1 }}[id_detail_kuesioner]"
                                value="{{ $item->id_detail_kuesioner }}">
                            <br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="{{ $no-1 }}[jawaban]" value="1"
                                    id="exampleRadios2" value="option2">
                                <label class="form-check-label" for="inlineCheckbox1">1</label>
                            </div>
                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="radio" name="{{ $no-1 }}[jawaban]" value="2"
                                    id="exampleRadios2" value="option2">
                                <label class="form-check-label" for="inlineCheckbox1">2</label>
                            </div>
                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="radio" name="{{ $no-1 }}[jawaban]" value="3"
                                    id="exampleRadios2" value="option2">
                                <label class="form-check-label" for="inlineCheckbox1">3</label>
                            </div>
                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="radio" name="{{ $no-1 }}[jawaban]" value="4"
                                    id="exampleRadios2" value="option2">
                                <label class="form-check-label" for="inlineCheckbox1">4</label>
                            </div>
                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="radio" name="{{ $no-1 }}[jawaban]" value="5"
                                    id="exampleRadios2" value="option2">
                                <label class="form-check-label" for="inlineCheckbox1">5</label>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @endforeach
                @if (@$nim != null)
                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-primary">Kirim</button>
                </div>
                @endif
            </form>
        </section>

        <br><br><br>
        <section class="contact-details" id="contact-details-section">
            <div class="row text-center text-md-left">
                <div class="col-12 col-md-6 col-lg-3 grid-margin">
                    <img src="images/Group2.svg" alt="" class="pb-2">
                    <div class="pt-2">
                        <p class="text-muted m-0">Jl. Adi Sucipto No.3012, Sukodadi, Kec. Sukarami, Palembang, Sumatera
                            Selatan,
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
            <p class="text-center text-muted pt-4">© Copyright Subbag Aktar Politeknik Penerbangan Palembang. Designed
                by<a href="https://www.bootstrapdash.com/" class="px-1">Bootstrapdash.</a>All rights reserved.</p>
        </footer>
    </div>
</div>
@endsection