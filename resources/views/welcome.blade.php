@extends('template.frontend')
@section('content')
    <style>
        .nav-lt-tab .nav-item .nav-link.active {
            border-top: 2.5px solid #624bff;
        }

        .nav {
            display: inline-block;
            overflow: auto;
            overflow-y: hidden;
            max-width: 100%;
            /* margin: 0 0 1em; */
            white-space: nowrap;
        }

        .nav li {
            display: inline-block;
            vertical-align: top;
        }

        .nav-item {
            margin-bottom: 0 !important;
        }

        .nav:hover> ::-webkit-scrollbar-thumb {
            visibility: visible;
        }

        ::-webkit-scrollbar {
            width: 0.5rem;
        }
    </style>
    <div class="banner">
        <div class="container">
            {{-- <h1 class="font-weight-semibold" data-aos="zoom-in" data-aos-delay="100">Sistem Informasi <br> Ketarunaan & Alumni
            </h1>
            <img src="{{ asset('frontend/images/undrawx.png') }}" alt="" class="img-fluid" data-aos="zoom-in"
                data-aos-delay="200">
            <br><br> --}}
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="font-weight-semibold m-4 text-left" data-aos="zoom-in" data-aos-delay="100">Sistem Informasi
                        <br> Ketarunaan &
                        Alumni
                    </h2>
                    <p class="text-left m-4">Sistem Pengelolaan data non akademik taruna, seperti perizinan, catatan sakit,
                        hukuman, pelanggaran, dan penilaian non akademik meliputi nilai samapta dan softskill</p>
                    <div class="d-flex justify-content-start m-4">
                        <a href="{{ url('login') }}" class="btn btn-info">
                            <span class="mdi mdi-lock"></span> Login</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <iframe width="100%" height="350" src="https://www.youtube.com/embed/ILT7Pm54f7U"
                        title="VIDEO PROFIL POLITEKNIK PENERBANGAN PALEMBANG" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
            </div>
            <br><br>
        </div>
    </div>
    <div class="content-wrapper">
        <div class="container">
            <section class="features-overview" id="features-section">
                <div class="content-header">
                    <h2 id="pengumuman">Pengumuman</h2>
                    <h6 class="section-subtitle text-muted mb-4">
                        Pengumuman dan informasi untuk taruna dan alumni
                        <br>Politeknik Penerbangan Palembang
                    </h6>
                    <ul class="nav nav-lt-tab mb-4" style="border: 0;" role="tablist">
                        <li class="nav-item">
                            <a href="{{ url('/') }}" style="border-radius: 25px;"
                                class="btn btn-sm btn-{{ Request('filter') == '' ? 'info' : 'primary' }}">All</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/') }}?filter=1" style="border-radius: 25px;"
                                class="btn btn-sm btn-{{ Request('filter') == '1' ? 'info' : 'primary' }}">Pendidikan</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/') }}?filter=2" style="border-radius: 25px;"
                                class="btn btn-sm btn-{{ Request('filter') == '2' ? 'info' : 'primary' }}">Lowongan
                                Kerja</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/') }}?filter=3" style="border-radius: 25px;"
                                class="btn btn-sm btn-{{ Request('filter') == '3' ? 'info' : 'primary' }}">Layanan</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/') }}?filter=4" style="border-radius: 25px;"
                                class="btn btn-sm btn-{{ Request('filter') == '4' ? 'info' : 'primary' }}">Lainnya</a>
                        </li>
                    </ul>
                </div>
                <div class="d-md-flex">
                    <?php
                    
                    if (Request('filter')) {
                        $data = DB::table('beritas')
                            ->orderBy('created_at', 'DESC')
                            ->where('kategori', Request('filter'))
                            ->limit(3)
                            ->get();
                    } else {
                        $data = DB::table('beritas')
                            ->orderBy('created_at', 'DESC')
                            ->limit(3)
                            ->get();
                    }
                    
                    ?>
                    @forelse ($data as $k => $item)
                        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="{{ $k + 1 }}00">
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
            <section class="features-overview" id="features-section">
                <div class="content-header">
                    <h2>Berita</h2>
                    <h6 class="section-subtitle text-muted mb-4">
                        Berita dan Informasi Lainnya dari Website Resmi
                        <br>Politeknik Penerbangan Palembang
                    </h6>
                </div>
                <div class="d-md-flex">
                    <div id="post" class="row">

                    </div>
                    <div style="margin-top: 20px; border-radius: 15px;">
                    </div>
                </div>
            </section>
            <section class="contact-us" id="contact-section" data-aos="fade-up" data-aos-delay="100">
                <div style="border-radius: 15px;" class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong><span class="mdi mdi-information"></span> Baru!</strong> coba beralih ke tampilan mobile
                    sekarang. <a href="{{ url('mobile/welcome') }}">Klik!</a>

                </div>
            </section>

        </div>

        <iframe class="embed-responsive"
            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15938.708954153537!2d104.6991992!3d-2.9089414!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x5e411b86b9a1b4e9!2sPoliteknik%20Penerbangan%20Palembang!5e0!3m2!1sid!2sid!4v1613966893900!5m2!1sid!2sid"
            height="420" title="poltekbangplg" style="border:0" allowfullscreen></iframe>

        <div class="container">
            <section class="contact-details" id="contact-details-section">
                <div class="row text-center text-md-left mt-5">
                    <div class="col-12 col-md-6 col-lg-3 grid-margin">
                        <img src="{{ asset('frontend/images/logo.png') }}" width="30%" alt="" class="pb-2">
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
                <p class="text-center text-muted pt-4">Copyright © <?php echo 2021; ?> Subbag Aktar Politeknik Penerbangan
                    Palembang.
                    Developed by<a target="_blank" href="https://www.mustechs.com/" class="px-1">Mustechs</a>All rights
                    reserved.</p>
            </footer>
        </div>
    </div>
@endsection
@push('script')
    <script src="https://unpkg.com/axios@0.27.2/dist/axios.min.js"></script>
    <script>
        axios.get('https://poltekbangplg.ac.id/wp-json/wp/v2/posts?categories=107').then(function(res) {

            console.log(res.data);

            let postData = ''

            res.data.forEach(e => {

                if (e.categories[0] != 216) {

                    postData +=

                        `
                          <div class="col-lg-4">
                            <a href="${e.link}" target="_blank">
                            <div>
                                <div class="card">
                                    <div class="card-body">
                                        <img src="${e.jetpack_featured_media_url}" width="100%"
                                            alt="" class="img-fluid mb-3 img-proporsional"
                                            style="border-radius: 15px;">
                                        <h5 class="card-title">${e.title.rendered}</h5>
                                        
                                    </div>
                                </div>
                            </div>
                          </a>
                        </div>
                        `
                }
            });


            document.querySelector('#post').innerHTML = postData
        })
    </script>
@endpush
