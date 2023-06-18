@extends('template.index')
@push('style')
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
@endpush
@section('content')
    <?php
    
        if(Request('aplikasi')){

            Session::put('dashboard', Request('aplikasi'));
        }
    
    ?>
    @if (Session::get('dashboard') == null or Session::get('dashboard') == 'ketarunaan')
        <div class="row">

            <div class="col-lg-12">
                <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
                    <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Dashboard Ketarunaan</h2>
                </div>
            </div>

            <div class="col-lg-12">
                <ul class="nav nav-lt-tab" style="border: 0;" role="tablist">
                    <div id="post"></div>
                </ul>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            @if (auth::user()->role != 'taruna')
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Taruna
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $taruna }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Jumlah Pengasuh
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pengasuh }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Jumlah Kamar
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ DB::table('kamars')->count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-hotel fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Semester Aktif</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $semester->nama_semester }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="row mb-4">
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-body">
                        <div id="container1"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-body">
                        <div id="container2"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div id="container3"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div id="container4"></div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">

            <div class="col-lg-12">
                <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
                    <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Dashboard Alumni</h2>
                </div>
            </div>

            <div class="col-lg-12">
                <ul class="nav nav-lt-tab" style="border: 0;" role="tablist">
                    <div id="post"></div>
                </ul>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Alumni</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ DB::table('alumnis')->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Jumlah Kuesioner
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ DB::table('kuesioners')->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-question fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Alumni Bekerja</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-briefcase fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- Pending Requests Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Lowongan Tersedia
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ DB::table('beritas')->where('kategori', '2')->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-briefcase fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
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

        function semester(semester_label, semester_total) {
            Highcharts.chart("container22", {
                chart: {
                    type: "column",
                },
                title: {
                    text: "Sebaran Taruna Semester Aktif",
                },
                xAxis: {
                    categories: semester_label,
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
                    name: "semester",
                    data: semester_total
                }],
            });
        }

        //pelanggaran dan penghargaan
        axios.get('/pelanggaran-penghargaan-terbanyak').then(function(res) {

            let pelanggaran_label = res.data.pelanggaran.map(function(e) {
                return e.pelanggaran
            })

            let pelanggaran_total = res.data.pelanggaran.map(function(e) {
                return e.total_pelanggaran
            })

            let penghargaan_label = res.data.penghargaan.map(function(e) {
                return e.penghargaan
            })

            let penghargaan_total = res.data.penghargaan.map(function(e) {
                return e.total_penghargaan
            })

            pelanggaran_terbanyak(pelanggaran_label, pelanggaran_total)
            penghargaan_terbanyak(penghargaan_label, penghargaan_total)
        })

        function pelanggaran_terbanyak(pelanggaran_label, pelanggaran_total) {
            Highcharts.chart("container3", {
                chart: {
                    type: "column",
                },
                title: {
                    text: "5 Pelanggaran terbanyak",
                },
                subtitle: {
                    text: "Statistik dari sejak awal Poltekbang berdiri",
                },
                xAxis: {
                    categories: pelanggaran_label,
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
                    name: "Pelanggaran",
                    data: pelanggaran_total
                }],
            });
        }

        function penghargaan_terbanyak(penghargaan_label, penghargaan_total) {
            Highcharts.chart("container4", {
                chart: {
                    type: "column",
                },
                title: {
                    text: "5 penghargaan terbanyak",
                },
                subtitle: {
                    text: "Statistik dari sejak awal Poltekbang berdiri",
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
                    name: "penghargaan",
                    data: penghargaan_total
                }],
            });
        }
    </script>

<script>
    axios.get('https://poltekbangplg.ac.id/wp-json/wp/v2/posts?categories=107').then(function(res) {

        console.log(res.data);

        let postData = ''

        res.data.forEach(e => {

            if (e.categories[0] != 216) {

                postData += `<li class="nav-item" style="margin-right: 10px;">
                        <a href="${e.link}">
                            <div class="card"
                                style="
                        background-image: linear-gradient(360deg, black, transparent), url('${e.jetpack_featured_media_url}'); 
                        background-position: center;
                        background-size: cover;
                        width: 320px; 
                        min-height: 200px;
                        border-radius: 15px; 
                        border: none;">
                                <div class="card-body" style="white-space: normal;">
                                    <div style="position: absolute; bottom: 10px;">
                                        <h5 class="card-title text-white">${e.title.rendered}</h5>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>`
            }
        });


        document.querySelector('#post').innerHTML = postData
    })
</script>
@endpush
