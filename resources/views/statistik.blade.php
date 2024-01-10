@extends('template.frontend')
@section('content')
    <div class="content-wrapper">
        <div class="container">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                        aria-controls="home" aria-selected="true">Data Taruna</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#penghargaan" role="tab"
                        aria-controls="profile" aria-selected="false">Penghargaan</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="dewan-tab" data-toggle="tab" href="#nonakademik" role="tab"
                        aria-controls="dewan" aria-selected="false">Nilai Non Akademik</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row mb-4">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div id="container1"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div id="container2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="penghargaan" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="row mb-4">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div id="container3"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div id="container4"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div id="container5"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nonakademik" role="tabpanel" aria-labelledby="dewan-tab">
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div id="container6"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div id="container7"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div id="container8"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div id="container9"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://unpkg.com/axios@1.1.2/dist/axios.min.js"></script>

    <script>
        @if ($message = Session::get('sukses'))
            toastr.success("{{ $message }}")
        @endif
    </script>

    <script>
        //total taruna
        axios.get('/total-taruna').then(function(res) {

            let jk = res.data.jenis_kelamin[0]
            jenis_kelamin(jk)

            let prodi = res.data.prodi[0]
            program_studi(prodi)

            let semester_label = res.data.semester.map(function(e) {
                return e.semester
            })

            let semester_total = res.data.semester.map(function(e) {
                return e.total_semester
            })

            semester(semester_label, semester_total)

        })

        function jenis_kelamin(jk) {
            Highcharts.chart("container1", {
                chart: {
                    type: "column",
                },
                title: {
                    text: "Data Sebaran Taruna dan Taruni",
                },
                subtitle: {
                    // text: "10 Laporan Hazard Paling Banyak",
                },
                xAxis: {
                    categories: [
                        'Taruna',
                        'Taruni'
                    ],
                    // crosshair: true,
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: "",
                    },
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"> <b>{point.y:.1f}</b></td></tr>',
                    footerFormat: "</table>",
                    shared: true,
                    useHTML: true,
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                    },
                },
                credits: {
                    enabled: false
                },
                series: [{
                    name: "Taruna/Taruni",
                    data: [jk.laki_laki, jk.perempuan]
                }],
            });
        }

        function program_studi(prodi) {
            Highcharts.chart("container2", {
                chart: {
                    type: "column",
                },
                title: {
                    text: "Data Sebaran Taruna Program Studi",
                },
                subtitle: {
                    // text: "10 Laporan Hazard Paling Banyak",
                },
                xAxis: {
                    categories: [
                        'TRBU',
                        'PPKP',
                        'MBU'
                    ],
                    // crosshair: true,
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: "",
                    },
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"> <b>{point.y:.1f}</b></td></tr>',
                    footerFormat: "</table>",
                    shared: true,
                    useHTML: true,
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                    },
                },
                credits: {
                    enabled: false
                },
                series: [{
                    name: "Taruna/Taruni",
                    data: [prodi.TRBU, prodi.PPKP, prodi.MBU]
                }],
            });
        }
    </script>
    <script>
        axios.get('/data-laporan-penghargaan').then(function(res) {

            let penghargaan_label = res.data.penghargaan.map(function(e) {
                return e.penghargaan
            })

            let penghargaan_total = res.data.penghargaan.map(function(e) {
                return e.total_penghargaan
            })

            let prodi = res.data.penghargaan_prodi[0]
            penghargaan_program_studi(prodi)

            let jk = res.data.penghargaan_jk[0]
            penghargaan_jenis_kelamin(jk)

            penghargaan_terbanyak(penghargaan_label, penghargaan_total)
        })

        function penghargaan_terbanyak(penghargaan_label, penghargaan_total) {
            Highcharts.chart("container3", {
                chart: {
                    type: "column",
                },
                title: {
                    text: "10 Penghargaan terbanyak",
                },
                xAxis: {
                    categories: penghargaan_label,
                    // crosshair: true,
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: "",
                    },
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"> <b>{point.y:.1f}</b></td></tr>',
                    footerFormat: "</table>",
                    shared: true,
                    useHTML: true,
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                    },
                },
                credits: {
                    enabled: false
                },
                series: [{
                    name: "Penghargaan",
                    data: penghargaan_total
                }],
            });
        }

        function penghargaan_program_studi(prodi) {
            Highcharts.chart("container4", {
                chart: {
                    type: "column",
                },
                title: {
                    text: "Perbandingan Penghargaan Taruna Prodi",
                },
                subtitle: {
                    // text: "10 Laporan Hazard Paling Banyak",
                },
                xAxis: {
                    categories: [
                        'TRBU',
                        'PPKP',
                        'MBU'
                    ],
                    // crosshair: true,
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: "",
                    },
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"> <b>{point.y:.1f}</b></td></tr>',
                    footerFormat: "</table>",
                    shared: true,
                    useHTML: true,
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                    },
                },
                credits: {
                    enabled: false
                },
                series: [{
                    name: "Taruna/Taruni",
                    data: [prodi.TRBU, prodi.PPKP, prodi.MBU]
                }],
            });
        }

        function penghargaan_jenis_kelamin(jk) {
            Highcharts.chart("container5", {
                chart: {
                    type: "column",
                },
                title: {
                    text: "Perbandingan Penghargaan Taruna/Taruni",
                },
                subtitle: {
                    // text: "10 Laporan Hazard Paling Banyak",
                },
                xAxis: {
                    categories: [
                        'Taruna',
                        'Taruni'
                    ],
                    // crosshair: true,
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: "",
                    },
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"> <b>{point.y:.1f}</b></td></tr>',
                    footerFormat: "</table>",
                    shared: true,
                    useHTML: true,
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                    },
                },
                credits: {
                    enabled: false
                },
                series: [{
                    name: "Taruna/Taruni",
                    data: [jk.laki_laki, jk.perempuan]
                }],
            });
        }
    </script>

    <script>
        axios.get('/data-laporan-penilaian').then(function(res) {

            //nilai prodi
            let prodi_label = res.data.nilai_prodi.map(function(e) {
                return e.nama_program_studi
            })

            let samapta = res.data.nilai_prodi.map(function(e) {
                return e.nilai_samapta
            })

            let softskill = res.data.nilai_prodi.map(function(e) {
                return e.nilai_softskill
            })

            let pelanggaran = res.data.nilai_prodi.map(function(e) {
                return e.nilai_pelanggaran
            })

            let penghargaan = res.data.nilai_prodi.map(function(e) {
                return e.nilai_penghargaan
            })

            nilai_program_studi(samapta, softskill, pelanggaran, penghargaan, prodi_label)


            //nilai jk
            let jk_label = res.data.nilai_jk.map(function(e) {
                // return e.jenis_kelamin
                if (e.jenis_kelamin == 'L') {
                    return 'Taruna'
                } else {
                    return 'Taruni'
                }
            })

            let nilai_0 = res.data.nilai_jk[0]
            let nilai_1 = res.data.nilai_jk[1]
            nilai_jenis_kelamin(jk_label, nilai_0, nilai_1)
        })

        function nilai_program_studi(samapta, softskill, pelanggaran, penghargaan, prodi_label) {
            Highcharts.chart("container6", {
                chart: {
                    type: "column",
                },
                title: {
                    text: "Perbandingan Rata-rata Nilai Taruna Prodi",
                },
                subtitle: {
                    text: "Nilai yang Diambil Telah Disahkan Menjadi Nilai Rapor",
                },
                xAxis: {
                    categories: prodi_label
                    // crosshair: true,
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: "",
                    },
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"> <b>{point.y:.1f}</b></td></tr>',
                    footerFormat: "</table>",
                    shared: true,
                    useHTML: true,
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                    },
                },
                credits: {
                    enabled: false
                },
                series: [{
                        name: "Nilai Jasmani",
                        data: samapta
                    },
                    {
                        name: "Nilai Softskill",
                        data: softskill
                    },
                    {
                        name: "Nilai Pelanggaran",
                        data: pelanggaran
                    },
                    {
                        name: "Nilai Penghargaan",
                        data: penghargaan
                    }
                ],
            });
        }

        function nilai_jenis_kelamin(jk_label, nilai_0, nilai_1) {
            Highcharts.chart("container7", {
                chart: {
                    type: "column",
                },
                title: {
                    text: "Perbandingan Rata-rata Nilai Taruna/Taruni",
                },
                subtitle: {
                    text: "Nilai yang Diambil Telah Disahkan Menjadi Nilai Rapor",
                },
                xAxis: {
                    categories: jk_label
                    // crosshair: true,
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: "",
                    },
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"> <b>{point.y:.1f}</b></td></tr>',
                    footerFormat: "</table>",
                    shared: true,
                    useHTML: true,
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                    },
                },
                credits: {
                    enabled: false
                },
                series: [{
                        name: "Nilai Samapta",
                        data: [nilai_0.nilai_samapta, nilai_1.nilai_samapta]
                    },
                    {
                        name: "Nilai Softskill",
                        data: [nilai_0.nilai_softskill, nilai_1.nilai_softskill]
                    },
                    {
                        name: "Nilai Pelanggaran",
                        data: [nilai_0.nilai_pelanggaran, nilai_1.nilai_pelanggaran]
                    },
                    {
                        name: "Nilai Penghargaan",
                        data: [nilai_0.nilai_penghargaan, nilai_1.nilai_penghargaan]
                    }
                ],
            });
        }
    </script>

    <script>
        axios.get('/data-laporan-jasmani').then(function(res) {

            //nilai prodi
            let prodi_label = res.data.nilai_prodi.map(function(e) {
                return e.nama_program_studi
            })

            let lari = res.data.nilai_prodi.map(function(e) {
                return e.nilai_lari
            })

            let push_up = res.data.nilai_prodi.map(function(e) {
                return e.nilai_push_up
            })

            let sit_up = res.data.nilai_prodi.map(function(e) {
                return e.nilai_sit_up
            })

            let shuttle_run = res.data.nilai_prodi.map(function(e) {
                return e.nilai_shuttle_run
            })

            jasmani_program_studi(lari, push_up, sit_up, shuttle_run, prodi_label)


            // nilai jk
            let jk_label = res.data.nilai_jk.map(function(e) {
                // return e.jenis_kelamin
                if (e.jenis_kelamin == 'L') {
                    return 'Taruna'
                } else {
                    return 'Taruni'
                }
            })

            let nilai_0 = res.data.nilai_jk[0]
            let nilai_1 = res.data.nilai_jk[1]
            jasmani_jenis_kelamin(jk_label, nilai_0, nilai_1)
        })

        function jasmani_program_studi(lari, push_up, sit_up, shuttle_run, prodi_label) {
            Highcharts.chart("container8", {
                chart: {
                    type: "column",
                },
                title: {
                    text: "Perbandingan Rata-rata Nilai Jasmani Taruna Prodi",
                },
                subtitle: {
                    text: "Nilai yang Diambil Telah Disahkan Menjadi Nilai Rapor",
                },
                xAxis: {
                    categories: prodi_label
                    // crosshair: true,
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: "",
                    },
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"> <b>{point.y:.1f}</b></td></tr>',
                    footerFormat: "</table>",
                    shared: true,
                    useHTML: true,
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                    },
                },
                credits: {
                    enabled: false
                },
                series: [{
                        name: "Nilai Lari",
                        data: lari
                    },
                    {
                        name: "Nilai Push Up",
                        data: push_up
                    },
                    {
                        name: "Nilai Sit Up",
                        data: sit_up
                    },
                    {
                        name: "Nilai Shuttle Run",
                        data: shuttle_run
                    }
                ],
            });
        }

        function jasmani_jenis_kelamin(jk_label, nilai_0, nilai_1) {
            Highcharts.chart("container9", {
                chart: {
                    type: "column",
                },
                title: {
                    text: "Perbandingan Rata-rata Nilai Jasmani Taruna/Taruni",
                },
                subtitle: {
                    text: "Nilai yang Diambil Telah Disahkan Menjadi Nilai Rapor",
                },
                xAxis: {
                    categories: jk_label
                    // crosshair: true,
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: "",
                    },
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"> <b>{point.y:.1f}</b></td></tr>',
                    footerFormat: "</table>",
                    shared: true,
                    useHTML: true,
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                    },
                },
                credits: {
                    enabled: false
                },
                series: [{
                        name: "Nilai Lari",
                        data: [nilai_0.nilai_lari, nilai_1.nilai_lari]
                    },
                    {
                        name: "Nilai Push Up",
                        data: [nilai_0.nilai_push_up, nilai_1.nilai_push_up]
                    },
                    {
                        name: "Nilai Sit Up",
                        data: [nilai_0.nilai_sit_up, nilai_1.nilai_sit_up]
                    },
                    {
                        name: "Nilai Shuttle Run",
                        data: [nilai_0.nilai_shuttle_run, nilai_1.nilai_shuttle_run]
                    }
                ],
            });
        }
    </script>
@endpush
