@extends('template.frontend')
@section('content')
    <div class="content-wrapper">
        <div class="container">

            <section class="features-overview" id="features-section" style="padding-top: 50px;">

                <div class="row mb-5">
                    <div class="col-lg-4">
                        <div class="card bg-info">
                            <div class="card-body text-white d-flex justify-content-center align-items-center"
                                style="height: 150px;">
                                <div class="text-center">
                                    <h1 class="counter" data-target="301" data-type="number">0</h1>
                                    <h5 style="margin-top: -10px;">Alumni</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card bg-warning">
                            <div class="card-body text-white d-flex justify-content-center align-items-center"
                                style="height: 150px;">
                                <div class="text-center">
                                    <h1 class="counter" data-target="301" data-type="number">0</h1>
                                    <h5 style="margin-top: -10px;">Bekerja</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card bg-success">
                            <div class="card-body text-white d-flex justify-content-center align-items-center"
                                style="height: 150px;">
                                <div class="text-center">
                                    <h1 class="counter" data-target="100" data-type="percent">0</h1>
                                    <h5 style="margin-top: -10px;">Success Rate</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>

                <div class="content-header">
                    <h2>Tracer Study</h2>
                    <h6 class="section-subtitle text-muted">
                        Silahkan Login untuk Mengisi Data Kuesioner Alumni
                        <br>Politeknik Penerbangan Palembang
                    </h6>
                    <br><br>
                </div>

                @if ($message = Session::get('sukses'))
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
                                            <label for="exampleInputEmail1">Nomor Induk Alumni</label>
                                            <input type="text" name="nim" class="form-control"
                                                style="background-color: white; border-radius: 10px;" required>
                                        </div>
                                        @if ($message = Session::get('gagal'))
                                            <p class="text-danger">{{ $message }}</p>
                                        @endif
                                        <br>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Program Studi</label>
                                            <select name="prodi" class="form-control"
                                                style="background-color: white; border-radius: 10px;" required>
                                                <option value="Manajemen Bandar Udara">D3 Manajemen Bandar Udara</option>
                                                <option value="Penyelamatan dan Pemadam Kebakaran Penerbangan">D3
                                                    Penyelamatan dan Pemadam Kebakaran</option>
                                                <option value="Teknologi Rekayasa Bandar Udara">D4 Teknologi Rekayasa Bandar
                                                    Udara</option>
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
                        @if ($item->jenis_soal == '1')
                            <div class="form-group">
                                <div class="card">
                                    <div class="card-body p-4" style="background-color: #f7f8fa; border-radius: 10px;">
                                        <label for="exampleInputEmail1">{{ $no++ }}. {{ $item->soal }}</label>
                                        <input type="hidden" name="{{ $no - 1 }}[id_detail_kuesioner]"
                                            value="{{ $item->id_detail_kuesioner }}">
                                        <br>
                                        <?php $jawaban = unserialize($item->jawaban); ?>
                                        @foreach ($jawaban as $i)
                                            <div class="form-check mt-1">
                                                <input class="form-check-input" type="radio"
                                                    name="{{ $no - 1 }}[jawaban]" value="{{ $i }}"
                                                    id="exampleRadios2" required>
                                                <label class="form-check-label"
                                                    for="inlineCheckbox1">{{ $i }}</label>
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
                                        <input type="hidden" name="{{ $no - 1 }}[id_detail_kuesioner]"
                                            value="{{ $item->id_detail_kuesioner }}">
                                        <br>
                                        <textarea name="{{ $no - 1 }}[jawaban]" id="" rows="2" class="form-control mt-1"
                                            style="background-color: white; border-radius: 10px;" required></textarea>
                                    </div>
                                </div>
                            </div>
                        @elseif($item->jenis_soal == '3')
                            <div class="form-group">
                                <div class="card">
                                    <div class="card-body p-4" style="background-color: #f7f8fa; border-radius: 10px;">
                                        <label for="exampleInputEmail1">{{ $no++ }}. {{ $item->soal }}</label>
                                        <input type="hidden" name="{{ $no - 1 }}[id_detail_kuesioner]"
                                            value="{{ $item->id_detail_kuesioner }}">
                                        <br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                name="{{ $no - 1 }}[jawaban]" value="Ya" id="exampleRadios2"
                                                value="option2" required>
                                            <label class="form-check-label" for="inlineCheckbox1">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline mt-3">
                                            <input class="form-check-input" type="radio"
                                                name="{{ $no - 1 }}[jawaban]" value="Tidak" id="exampleRadios2"
                                                value="option2" required>
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
                                        <input type="hidden" name="{{ $no - 1 }}[id_detail_kuesioner]"
                                            value="{{ $item->id_detail_kuesioner }}">
                                        <br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                name="{{ $no - 1 }}[jawaban]" value="1" id="exampleRadios2"
                                                value="option2" required>
                                            <label class="form-check-label" for="inlineCheckbox1">1</label>
                                        </div>
                                        <div class="form-check form-check-inline mt-3">
                                            <input class="form-check-input" type="radio"
                                                name="{{ $no - 1 }}[jawaban]" value="2" id="exampleRadios2"
                                                value="option2" required>
                                            <label class="form-check-label" for="inlineCheckbox1">2</label>
                                        </div>
                                        <div class="form-check form-check-inline mt-3">
                                            <input class="form-check-input" type="radio"
                                                name="{{ $no - 1 }}[jawaban]" value="3" id="exampleRadios2"
                                                value="option2" required>
                                            <label class="form-check-label" for="inlineCheckbox1">3</label>
                                        </div>
                                        <div class="form-check form-check-inline mt-3">
                                            <input class="form-check-input" type="radio"
                                                name="{{ $no - 1 }}[jawaban]" value="4" id="exampleRadios2"
                                                value="option2" required>
                                            <label class="form-check-label" for="inlineCheckbox1">4</label>
                                        </div>
                                        <div class="form-check form-check-inline mt-3">
                                            <input class="form-check-input" type="radio"
                                                name="{{ $no - 1 }}[jawaban]" value="5" id="exampleRadios2"
                                                value="option2" required>
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

            <section class="mt-5 features-overview" id="features-section">
                <div class="content-header">
                    <h2 id="pengumuman">Lowongan Kerja</h2>
                    <h6 class="section-subtitle text-muted mb-4">
                        Lowongan kerja bagi alumni
                        <br>Politeknik Penerbangan Palembang
                    </h6>

                </div>
                <div class="d-md-flex">
                    <?php
                    $data = DB::table('beritas')->orderBy('created_at', 'DESC')->where('kategori', '2')->limit(6)->get();
                    
                    ?>
                    @forelse ($data as $k => $item)
                        <div class="col-lg-4">
                            <div>
                                <div class="card">
                                    <div class="card-body">
                                        <img src="{{ asset('gambar_berita') }}/{{ $item->gambar_utama }}" width="100%"
                                            alt="" class="img-fluid mb-3 img-proporsional"
                                            style="border-radius: 15px;">
                                        <h5 class="card-title">{{ substr($item->judul_berita, 0, 50) }}</h5>
                                        <p class="card-text">
                                            {{ strip_tags(substr($item->isi_berita, 0, 90)) }}
                                        </p>
                                        <a href="{{ url('detailberita') }}/{{ $item->id_berita }}"
                                            class="btn btn-primary">Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 mt-4 mb-4">
                            <h4 class="text-center">Belum Ada Berita Untuk Kategori Ini</h4>
                        </div>
                    @endforelse
                </div>
            </section>

            <section class="mt-5 features-overview" id="features-section">
                <div class="content-header">
                    <h2 id="pengumuman">Testimoni</h2>
                    <h6 class="section-subtitle text-muted mb-4">
                        Testimoni alumni
                        <br>Politeknik Penerbangan Palembang
                    </h6>

                </div>
                <div>
                    <?php $data = DB::table('beritas')->orderBy('created_at', 'DESC')->where('kategori', '2')->limit(6)->get(); ?>
                    <button class="btn btn-sm btn-info mt-4" data-toggle="modal" data-target="#modaltestimoni">Tambah
                        Testimoni</button>
                    <!-- Modal -->
                    <div class="modal fade" id="modaltestimoni" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                </div>
                                <form method="POST" action="{{ url('simpantestimoni') }}">
                                    @csrf
                                    <div class="modal-body">
                                        <h5 class="mb-5 modal-title" id="exampleModalLabel">
                                            Form Testimoni Alumni
                                        </h5>
                                        <div class="form-group">
                                            <labelclass="col-form-label">Nomor Induk Alumni <sup
                                                class="text-danger">*</sup></label>
                                            <input type="text" class="form-control" name="nim" id="nim"
                                                required placeholder="Nomor Induk Alumni">
                                        </div>
                                        <div class="form-group">
                                            <label for="message-text" class="col-form-label">Testimoni <sup
                                                    class="text-danger">*</sup></label>
                                            <textarea class="form-control" name="testimoni" id="testimoni" cols="30" rows="15" required
                                                placeholder="Testimoni"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Send message</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @php
                        $testimoni = DB::table('testimonis')
                            ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'testimonis.id_mahasiswa')
                            ->select('tarunas.nama_mahasiswa', 'testimonis.*', 'tarunas.foto')
                            ->orderBy('created_at', 'DESC')
                            ->limit(6)
                            ->get();
                    @endphp
                    <div class="row">


                        @foreach ($testimoni as $k => $t)
                            <div class="col-lg-4 mt-5">
                                <div>
                                    <div class="card border-0 shadow-sm rounded-4">
                                        <div class="card-body shadow pl-4 pr-4 pt-0">

                                            <!-- Icon kutip -->
                                            <div>
                                                <span style="font-size: 100px;" class="fs-1 text-warning">“</span>
                                            </div>

                                            <!-- Isi testimoni -->
                                            <p class="text-muted"
                                                style="font-size: 14px; margin-top: -50px; line-height: 1.8;">
                                                {{ $t->testimoni }}
                                            </p>

                                            <!-- Profile -->
                                            <div class="d-flex align-items-center mt-4">
                                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-white mr-3"
                                                    style="background-image: url('{{ $t->foto }}'); 
                                                    width: 60px; 
                                                    height: 60px; 
                                                    background-size: cover; 
                                                    background-position: center; 
                                                    border-radius: 50%;">
                                                    {{-- 200x200 --}}
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $t->nama_mahasiswa }}
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
            @if (@$alert)
                <script>
                    alert("{{ $alert }}");
                </script>
            @endif
            <br><br><br>
            <section class="contact-details" id="contact-details-section">
                <div class="row text-center text-md-left">
                    <div class="col-12 col-md-6 col-lg-3 grid-margin">
                        <img src="{{ asset('frontend/images/logo.png') }}" width="30%" alt=""
                            class="pb-2">
                        <div class="pt-2">
                            <p class="text-muted m-0">Jl. Adi Sucipto No.3012, Sukodadi, Kec. Sukarami, Palembang, Sumatera
                                Selatan, 30961</p>
                            <p class="text-muted m-0">Email: pusbangkar@poltekbangplg.ac.id</p>
                            <p class="text-muted m-0">Telpon: 0711-410930</p>
                            <p class="text-muted m-0">Fax: 0711-420385</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 grid-margin">
                        <h5 class="pb-2">Sosial Media</h5>
                        <div class="d-flex justify-content-center justify-content-md-start">
                            <a target="_blank" href="https://www.facebook.com/poltekbangplg/"><span
                                    class="mdi mdi-facebook"></span></a>
                            <a target="_blank" href="https://twitter.com"><span class="mdi mdi-twitter"></span></a>
                            <a target="_blank" href="https://www.instagram.com/poltekbangplg/"><span
                                    class="mdi mdi-instagram"></span></a>
                            <a target="_blank" href="https://www.youtube.com/channel/UC_AW0-niVg52RtQB5NeG34g"><span
                                    class="mdi mdi-youtube-play"></span></a>
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
                <p class="text-center text-muted pt-4">Copyright © <?php echo date('Y'); ?> Subbag Aktar Politeknik Penerbangan
                    Palembang.
                    Developed by<a target="_blank" href="https://sahretech.com" class="px-1">Mustechs</a>All rights
                    reserved.</p>
            </footer>
        </div>
    </div>
    <script>
        const counters = document.querySelectorAll('.counter');

        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            const type = counter.getAttribute('data-type');

            let current = 0;

            const updateCounter = () => {
                const increment = target / 100;

                if (current < target) {
                    current += increment;

                    if (type === 'percent') {
                        counter.innerText = Math.ceil(current) + '%';
                    } else {
                        counter.innerText = Math.ceil(current).toLocaleString('id-ID');
                    }

                    setTimeout(updateCounter, 20);
                } else {
                    if (type === 'percent') {
                        counter.innerText = target + '%';
                    } else {
                        counter.innerText = target.toLocaleString('id-ID');
                    }
                }
            };

            updateCounter();
        });
    </script>
@endsection
