@extends('template.index')

@push('style')
    <link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
                <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-file"></i> Laporan / Laporan Pelanggaran</h2>
            </div>
        </div>
        <div class="col-lg-3">
            <form action="{{ url('laporan-pelanggaran') }}">
                <select onchange="submit()" data-allow-clear="true" name="id_semester" id="carisemester"
                    class="mb-3 form-control cari" required>
                    <option value="">All Time</option>
                    @php
                        $semester = DB::table('semesters')->get();
                    @endphp
                    @foreach ($semester as $item)
                        <option {{ request('id_semester') == $item->id_semester ? 'selected' : '' }}
                            value="{{ $item->id_semester }}">{{ $item->nama_semester }}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div id="container1"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div id="container2"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div id="container3"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" width="100%" id="dataTable" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="width: 20px">No</th>
                                    <th>Foto</th>
                                    <th>Nama Taruna</th>
                                    <th>Program Studi</th>
                                    <th>Semester</th>
                                    <th>Total Poin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($taruna as $k => $item)
                                    <tr>
                                        <td>{{ $k+1 }}</td>
                                        <td>
                                            <div style="
                                                width: 50px;
                                                height: 50px;
                                                background-image: url('{{ $item->foto }}');
                                                background-size: cover;
                                            "></div>
                                        </td>
                                        <td>
                                            {{ $item->nim }} <br>
                                            {{ $item->nama_mahasiswa }}
                                        </td>
                                        <td>{{ $item->nama_program_studi }}</td>
                                        <td>{{ $item->semester }}</td>
                                        <td>{{ $item->total_poin }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('template/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://unpkg.com/axios@1.1.2/dist/axios.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('template/js/demo/datatables-demo.js') }}"></script>

    <script>
        axios.get('/data-laporan-pelanggaran?id_semester={{ request('id_semester') }}').then(function(res) {

            let pelanggaran_label = res.data.pelanggaran.map(function(e) {
                return e.pelanggaran
            })

            let pelanggaran_total = res.data.pelanggaran.map(function(e) {
                return e.total_pelanggaran
            })

            let prodi = res.data.pelanggaran_prodi[0]
            program_studi(prodi)

            let jk = res.data.pelanggaran_jk[0]
            jenis_kelamin(jk)

            pelanggaran_terbanyak(pelanggaran_label, pelanggaran_total)
        })

        function pelanggaran_terbanyak(pelanggaran_label, pelanggaran_total) {
            Highcharts.chart("container1", {
                chart: {
                    type: "column",
                },
                title: {
                    text: "10 Pelanggaran terbanyak",
                },
                subtitle:{
                    text: "Dilakuan dalam periode tertentu"
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

        function program_studi(prodi) {
            Highcharts.chart("container2", {
                chart: {
                    type: "column",
                },
                title: {
                    text: "Perbandingan Pelanggaran Taruna Prodi",
                },
                subtitle:{
                    text: "Dilakuan dalam periode tertentu"
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

        function jenis_kelamin(jk) {
            Highcharts.chart("container3", {
                chart: {
                    type: "column",
                },
                title: {
                    text: "Perbandingan Pelanggaran Taruna/Taruni",
                },
                subtitle:{
                    text: "Dilakuan dalam periode tertentu"
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
@endpush
