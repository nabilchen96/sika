@extends('template.frontend')

@push('style')
<style>
    .berita p {
        line-height: 2 !important;
    }
</style>
@endpush

@section('content')
<div class="content-wrapper">
    <div class="container">

        <div class="row">
            <div class="col-lg-9" data-aos="zoom-in">
                <img class="detail-news-image" src="{{ asset('gambar_berita') }}/{{ $detailberita->gambar_utama }}" style="
                    float: center;
                    width: 100%;
                    height: 500px;
                    object-fit: cover;
                    border-radius: 15px;
                " alt="">
                <h2 class="mt-4">{{ $detailberita->judul_berita }}</h2>
                <i class="mdi mdi-account"></i> {{ $detailberita->name }} &nbsp;|&nbsp;<i class="mdi mdi-calendar"></i>
                {{ date('d-m-Y', strtotime($detailberita->created_at ))}}
                &nbsp;|&nbsp; <i class="mdi mdi-file-document-box"></i>
                @if ($detailberita->kategori == 1)
                Pendidikan
                @elseif ($detailberita->kategori == 2)
                Lowongan Kerja
                @elseif ($detailberita->kategori == 3)
                Layanan
                @else
                Lainnya
                @endif
                <br><br>
                <div class="berita">
                    <?php 
                    echo html_entity_decode(htmlentities($detailberita->isi_berita));
                ?>
                </div>
            </div>
            <div class="col-lg-3">
                @foreach ($recentberita->all() as $k => $item)
                <div class="mb-4" data-aos="zoom-in">
                    <img src="{{ asset('gambar_berita') }}/{{ $item->gambar_utama }}" style="
                        float: center;
                        width: 100%;
                        height: 150px;
                        object-fit: cover;
                        transition: all 0.3s ease;
                        border-radius: 15px;
                      " alt="">
                    <p class="mt-2">
                        <a href="{{ url('detailberita') }}/{{ $item->id_berita }}">{{ $item->judul_berita }}</a>
                        <br>
                        <i class="mdi mdi-account"></i> {{ $detailberita->name }} &nbsp;|&nbsp;<i
                            class="mdi mdi-calendar"></i>
                        {{ date('d-m-Y', strtotime($detailberita->created_at)) }}
                    </p>
                    <hr>
                </div>
                @endforeach
                <iframe
                    src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fpoltekbangplg&tabs&width=340&height=130&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=false&appId"
                    width="100%" height="130" style="border:none;overflow:hidden" scrolling="no" frameborder="0"
                    allowfullscreen="true"
                    allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
            </div>

        </div>

        <br><br><br>
        <section class="contact-details" id="contact-details-section">
            <div class="row text-center text-md-left">
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
                        <a href="https://www.facebook.com/poltekbangplg/"><span class="mdi mdi-facebook"></span></a>
                        <a href="https://twitter.com"><span class="mdi mdi-twitter"></span></a>
                        <a href="https://www.instagram.com/poltekbangplg/"><span class="mdi mdi-instagram"></span></a>
                        <a href="https://www.youtube.com/channel/UC_AW0-niVg52RtQB5NeG34g"><span
                                class="mdi mdi-youtube-play"></span></a>
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
            <p class="text-center text-muted pt-4">Copyright © <?php echo date('Y'); ?> Subbag Aktar Politeknik
                Penerbangan Palembang.
                Developed by<a href="https://www.mustechs.com/" class="px-1">Mustechs</a>All rights reserved.</p>
        </footer>
    </div>
</div>
@endsection