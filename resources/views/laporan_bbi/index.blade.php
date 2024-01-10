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
        axios.get('/data-laporan-bbi?id_semester={{ request('id_semester') }}').then(function(res) {

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

            let jk_berat_0 = res.data.jk_berat[0]
            let jk_berat_1 = res.data.jk_berat[1]
            fungsi_berat(jk_label, jk_berat_0, jk_berat_1)
        })

        function jenis_kelamin(jk_label, nilai_0, nilai_1) {
            Highcharts.chart("container1", {
                chart: {
                    type: "column",
                },
                title: {
                    text: "Perbandingan Rata-rata Tinggi Taruna/Taruni",
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
                    name: "Tinggi Badan",
                    data: [nilai_0.tinggi_badan, nilai_1.tinggi_badan]
                },],
            });
        }

        function fungsi_berat(jk_label, jk_berat_0, jk_berat_1) {
            Highcharts.chart("container2", {
                chart: {
                    type: "column",
                },
                title: {
                    text: "Perbandingan Rata-rata Berat Taruna/Taruni",
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
                    name: "Berat Badan",
                    data: [jk_berat_0.berat_badan, jk_berat_1.berat_badan]
                },],
            });
        }
    </script>

    <script>
        axios.get('/data-laporan-bbi2?id_semester={{ request('id_semester') }}').then(function(res) {

            let stakes_label = res.data.stakes.map(function(e) {
                if(e.stakes != null){
                    return e.stakes
                }
            }).filter(Boolean);

            let stakes_nilai = res.data.stakes.map(function(e) {
                if(e.stakes != 0){
                
                    return e.total_stakes
                }
            }).filter(Boolean);

            console.log(stakes_nilai);
            console.log(stakes_label);

            fungsi_stakes(stakes_label, stakes_nilai)
        })

        function fungsi_stakes(stakes_label, stakes_nilai) {
            Highcharts.chart("container3", {
                chart: {
                    type: "column",
                },
                title: {
                    text: "Perbandingan Stakes Taruna/Taruni",
                },
                xAxis: {
                    categories: stakes_label
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
                    name: "Stakes",
                    data: stakes_nilai
                },],
            });
        }

        function fungsi_berat(jk_label, jk_berat_0, jk_berat_1) {
            Highcharts.chart("container2", {
                chart: {
                    type: "column",
                },
                title: {
                    text: "Perbandingan Rata-rata Berat Taruna/Taruni",
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
                    name: "Berat Badan",
                    data: [jk_berat_0.berat_badan, jk_berat_1.berat_badan]
                },],
            });
        }
    </script>
@endpush
