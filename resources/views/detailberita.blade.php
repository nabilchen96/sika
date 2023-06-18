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
                    <img class="detail-news-image" src="{{ asset('gambar_berita') }}/{{ $detailberita->gambar_utama }}"
                        style="
                    float: center;
                    width: 100%;
                    height: 500px;
                    object-fit: cover;
                    border-radius: 15px;
                "
                        alt="">
                    <h2 class="mt-4">{{ $detailberita->judul_berita }}</h2>
                    <i class="mdi mdi-account"></i> {{ $detailberita->name }} &nbsp;|&nbsp;<i class="mdi mdi-calendar"></i>
                    {{ date('d-m-Y', strtotime($detailberita->created_at)) }}
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
                    | <a href="#" data-toggle="modal" data-target="#modal"
                        class="text-success">{{ $detailberita->input_lamaran == 'Ya' ? 'Bisa Apply Lamaran' : '' }}</a>
                    <br><br>
                    <div class="berita">
                        <?php
                        echo html_entity_decode(htmlentities($detailberita->isi_berita));
                        ?>
                        @if ($detailberita->input_lamaran == 'Ya')
                            <button style="border-radius: 25px;" class="btn btn-sm btn-primary" data-toggle="modal"
                                data-target="#modal"> <i class="mdi mdi-plus"></i> Apply Lamaran</button>
                        @endif
                    </div>
                </div>
                <div class="col-lg-3">
                    @foreach ($recentberita->all() as $k => $item)
                        <div class="mb-4" data-aos="zoom-in">
                            <img src="{{ asset('gambar_berita') }}/{{ $item->gambar_utama }}"
                                style="
                        float: center;
                        width: 100%;
                        height: 150px;
                        object-fit: cover;
                        transition: all 0.3s ease;
                        border-radius: 15px;
                      "
                                alt="">
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

            <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Apply Lamaran</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="form">
                            <div class="modal-body p-3">
                                <input type="hidden" name="id_berita" id="id_berita" value="{{ $detailberita->id_berita }}">
                                <div class="mb-4">
                                    <label for="recipient-name" class="col-form-label">Nama Pelamar <sup
                                            class="text-danger">*</sup></label>
                                    <input type="text" name="nama_pelamar" placeholder="Nama Pelamar" id="nama_pelamar"
                                        class="form-control" required>
                                </div>
                                <div class="mb-4">
                                    <label for="recipient-name" class="col-form-label">Email <sup
                                            class="text-danger">*</sup></label>
                                    <input type="email" class="form-control" placeholder="Email" required id="email"
                                        name="email">
                                </div>
                                <div class="mb-4">
                                    <label for="recipient-name" class="col-form-label">Jenis Kelamin <sup
                                            class="text-danger">*</sup></label>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                        <option value="">--Pilih Jenis Kelamin--</option>
                                        <option>Laki-laki</option>
                                        <option>Perempuan</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="recipient-name" class="col-form-label">Nomor Telpon <sup
                                            class="text-danger">*</sup></label>
                                    <input type="number" class="form-control" placeholder="Nomor Telpon" required
                                        id="nomor_telpon" name="nomor_telpon">
                                </div>
                                <div class="mb-4">
                                    <label for="recipient-name" class="col-form-label">Alamat <sup
                                            class="text-danger">*</sup></label>
                                    <textarea name="alamat" id="alamat" cols="30" rows="3" class="form-control" required
                                        placeholder="Alamat"></textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="recipient-name" class="col-form-label">Pengalaman <sup
                                            class="text-danger">*</sup></label>
                                    <textarea name="pengalaman" id="pengalaman" cols="30" class="form-control" rows="3" required
                                        placeholder="Pengalaman"></textarea>
                                </div>
                                <div>
                                    <label for="recipient-name" class="col-form-label">Upload Berkas Lamaran<sup
                                            class="text-danger">*</sup></label>
                                    <input type="file" class="form-control" placeholder="Upload Berkas" required
                                        id="upload_lamaran" name="upload_lamaran">
                                    <span style="font-size: 10px;" class="text-danger">Upload Lamaran Dalam Bentuk PDF Max Size 1024KB</span>
                                </div>
                            </div>
                            <div class="modal-footer p-3">
                                <button type="button" class="btn btn-secondary" style="border-radius: 25px;"
                                    data-dismiss="modal">Close</button>
                                <button id="tombol_kirim" type="submit" style="border-radius: 25px;"
                                    class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

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
                    Developed by<a href="https://sahretech.com" target="_blank" class="px-1">Mustechs</a>All rights
                    reserved.</p>
            </footer>
        </div>
    </div>
    <script src="https://unpkg.com/axios@0.27.2/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.all.min.js"></script>
    <script>

        form.onsubmit = (e) => {

            let formData = new FormData(form);

            e.preventDefault();

            axios({
                    method: 'post',
                    url: '/tambah-lamaran-kerja',
                    data: formData,
                })
                .then(function(res) {
                    //handle success         
                    if (res.data.responCode == 1) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: 'Terima Kasih, Data Lamaran Anda Sudah Kami Terima',
                            timer: 3000,
                            showConfirmButton: false
                        })

                        $("#modal").modal("hide");
                        // location.reload()

                    } else {

                        Swal.fire({
                            icon: 'warning',
                            title: 'Ada kesalahan',
                            text: `Pastikan anda memasukkan semua data dengan benar`,
                        })
                        
                        console.log('error');
                    }

                })
                .catch(function(res) {
                    
                    //handle error
                    console.log(res);
                });
        }
    </script>
@endsection
