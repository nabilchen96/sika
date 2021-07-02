@extends('template.frontend')
@section('content')
<div class="content-wrapper">
    <div class="container">

        <section class="features-overview" id="features-section" style="padding-top: 50px;">
            <div class="content-header">
                <h2>Kuesioner Alumni</h2>
                <h6 class="section-subtitle text-muted">
                Silahkan Login untuk Mengisi Data Kuesioner Alumni
                <br>Politeknik Penerbangan Palembang</h6>
                <br><br>
            </div>

            @if($message = Session::get('sukses'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Terima kasih atas partisipasi anda dalam mengisi kuesioner ini
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if (@$nim == null)
            <form action="{{ url('isikuesioner') }}" method="get">
                <div class="card" style="background-color: #f7f8fa; border-radius: 10px;">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="text-center kuesioner">
                                <img src="{{ asset('formx.png') }}" style="margin-top: 50px;">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card-body card-kuesioner">
                                <div class="form-group mt-4">
                                    <label for="exampleInputEmail1">Nomor Induk Taruna</label>
                                    <input type="text" name="nim" class="form-control"
                                        style="background-color: white; border-radius: 10px;" required>
                                </div>
                                @if($message = Session::get('gagal'))
                                <p class="text-danger">{{ $message }}</p>
                                @endif
                                <br>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Program Studi</label>
                                    <select name="prodi" class="form-control"
                                        style="background-color: white; border-radius: 10px;" required>
                                        <option value="Manajemen Bandar Udara">D3 Manajemen Bandar Udara</option>
                                        <option value="Penyelamatan dan Pemadam Kebakaran Penerbangan">D3 Penyelamatan dan Pemadam Kebakaran</option>
                                        <option value="Teknologi Rekayasa Bandar Udara">D4 Teknologi Rekayasa Bandar Udara</option>
                                    </select>
                                </div>
                                <br>
                                <div class="form-group mt-1">
                                    <label for="exampleInputEmail1">Tanggal Lahir</label>
                                    <input type="date" name="tgllahir" class="form-control"
                                        style="background-color: white; border-radius: 10px;" required>
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