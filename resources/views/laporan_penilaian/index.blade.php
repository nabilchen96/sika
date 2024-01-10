@extends('template.index')

@push('style')
    <link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
                <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-file"></i> Laporan / Laporan Penghargaan</h2>
            </div>
        </div>
        <div class="col-lg-3">
            <form action="{{ url('laporan-penilaian') }}">
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
        <div class="col-lg-6 mb-4">
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
    </div>
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div id="container3"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div id="container4"></div>
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
        axios.get('/data-laporan-penilaian?id_semester={{ request('id_semester') }}').then(function(res) {

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

            program_studi(samapta, softskill, pelanggaran, penghargaan, prodi_label)


            //nilai jk
            let jk_label = res.data.nilai_jk.map(function(e) {
                // return e.jenis_kelamin
                if(e.jenis_kelamin == 'L'){
                    return 'Taruna'
                }else{
                    return 'Taruni'
                }
            })

            let nilai_0 = res.data.nilai_jk[0]
            let nilai_1 = res.data.nilai_jk[1]
            jenis_kelamin(jk_label, nilai_0, nilai_1)
        })

        function program_studi(samapta, softskill, pelanggaran, penghargaan, prodi_label) {
            Highcharts.chart("container1", {
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

        function jenis_kelamin(jk_label, nilai_0, nilai_1) {
            Highcharts.chart("container2", {
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
        axios.get('/data-laporan-jasmani?id_semester={{ request('id_semester') }}').then(function(res) {

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
                if(e.jenis_kelamin == 'L'){
                    return 'Taruna'
                }else{
                    return 'Taruni'
                }
            })

            let nilai_0 = res.data.nilai_jk[0]
            let nilai_1 = res.data.nilai_jk[1]
            jasmani_jenis_kelamin(jk_label, nilai_0, nilai_1)
        })

        function jasmani_program_studi(lari, push_up, sit_up, shuttle_run, prodi_label) {
            Highcharts.chart("container3", {
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
            Highcharts.chart("container4", {
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
