@extends('layouts.mobile')
@section('content')
    <div
        style="height: 300px; background: linear-gradient(360deg, black, transparent), url('{{ asset('poltekbang.jpg') }}'); background-position: center; background-size: cover;">

    </div>
    <div class="container">
        <div class="ps-2" style="margin-top: -270px;">
            <h2 class="text-white">Nilai Softskill</h2>
            <h4 class="text-white">{{ @$data[0]->nama_semester }}</h4>
            <ul class="nav nav-lt-tab mt-3" style="border: 0;" role="tablist">
                <li class="nav-item" style="margin-right: 5px;">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modal" class="btn btn-primary"
                        style="border-radius: 20px; padding-left: 25px; padding-right: 25px;">Cari</a>
                </li>
                <li class="nav-item" style="margin-right: 5px;">
                    <a href="{{ url('mobile/nilai') }}" class="btn btn-primary"
                        style="border-radius: 20px; padding-left: 25px; padding-right: 25px;">Nilai Jasmani</a>
                </li>
                <li class="nav-item" style="margin-right: 5px;">
                    <a href="{{ url('mobile/nilai-pelanggaran') }}" class="btn btn-primary position-relative"
                        onclick="getData(0)" id="0"
                        style="border-radius: 25px; padding-left: 25px; padding-right: 25px;">Nilai Pelanggaran</span>
                    </a>
                </li>
                <li class="nav-item" style="margin-right: 5px;">
                    <a href="{{ url('mobile/nilai-penghargaan') }}" class="btn btn-primary" onclick="getData(1)"
                        id="1" style="border-radius: 25px; padding-left: 25px; padding-right: 25px;">Nilai
                        Penghargaan</a>
                </li>
                <li class="nav-item" style="margin-right: 5px;">
                    <a href="{{ url('mobile/nilai-softskill') }}" class="btn btn-primary" onclick="getData(1)"
                        id="1" style="border-radius: 25px; padding-left: 25px; padding-right: 25px;">Nilai
                        Softskill</a>
                </li>
            </ul>
        </div>
        <div style="margin-top: -20px; border-radius: 15px;">
            <div>
                <div class="table-responsive">
                    <table class="table table-borderless" style="width: 100%;" id="dataTable" cellspacing="0">
                        <thead>
                            <tr>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $taruna = '';
                                $softskill = '';
                            @endphp
                            @foreach ($data as $k => $item)
                                @if ($item->id_mahasiswa != $taruna)
                                    <tr>
                                        <td>
                                            <div class="card shadow" style="border-radius: 15px;">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="div"
                                                                style="border-radius: 15px; 
                                                            width: 100%; 
                                                            background: #6c63ff;
                                                            aspect-ratio: 1/1;">
                                                                @if ($item->foto != null)
                                                                    <img style="border-radius: 15px; height: 100%; object-fit: cover; width: 100%;"
                                                                        src="{{ $item->foto }}" alt="">
                                                                @else
                                                                    <img style="border-radius: 15px; object-fit: cover; width: 100%;"
                                                                        src="{{ asset('male.svg') }}" alt="">
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-8">
                                                            {{ $item->nama_mahasiswa }}<br>
                                                            <span class="badge bg-primary">{{ $item->nim }}</span>
                                                            <span class="badge bg-primary">
                                                                @if ($item->nama_program_studi == 'Teknologi Rekayasa Bandar Udara')
                                                                    TRBU
                                                                @elseif($item->nama_program_studi == 'Manajemen Bandar Udara')
                                                                    MBU
                                                                @elseif($item->nama_program_studi == 'Penyelamatan dan Pemadam Kebakaran Penerbangan')
                                                                    PPKP
                                                                @endif
                                                            </span>
                                                            @php
                                                                $komponen = $data->where('id_mahasiswa', $item->id_mahasiswa)->sortDesc();
                                                            @endphp
                                                            <div class="row mt-2">
                                                                <div class="col-12">
                                                                    <b>Nilai Softskill</b><br>
                                                                    <h4> {{ round($komponen->sum('total_nilai') / $komponen->sum('jumlah_keterangan'), 2) }} <a style="font-size: 14px;" role="button"
                                                                            aria-expanded="false"
                                                                            aria-controls="collapseExample"
                                                                            data-bs-toggle="collapse"
                                                                            href="#data{{ $item->id_mahasiswa }}">Detail</a>
                                                                    </h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="collapse" style="font-size: 12px;"
                                                        id="data{{ $item->id_mahasiswa }}">
                                                        <div class="card" style="border-radius: 15px;">
                                                            <div class="card-body">
                                                                <table class="table table-borderless">
                                                                    @foreach ($komponen as $item)
                                                                        <tr>
                                                                            <td class="p-0" style="height: 25px;">
                                                                                <a href="{{ url('/mobile/detail-softskill') }}/{{ $item->id_mahasiswa }}/{{ $item->jenis_softskill }}">
                                                                                    <b>{{ $item->jenis_softskill }}</b>
                                                                                </a>    
                                                                            </td>
                                                                            <td class="p-0">
                                                                                {{ round($item->total_nilai / $item->jumlah_keterangan, 2) }}
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                @php
                                    $taruna = $item->id_mahasiswa;
                                    $softskill = $item->jenis_softskill;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cari Taruna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('mobile/nilai-pelanggaran') }}">
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            @php
                                $taruna = DB::table('tarunas')->get();
                            @endphp
                            <select class="select2 form-control" name="id_mahasiswa" id="id_mahasiswa" required>
                                <option value="all">Tampilan Semua</option>
                                @foreach ($taruna as $item)
                                    <option value="{{ $item->id_mahasiswa }}">{{ $item->nama_mahasiswa }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Semester</label>
                            @php
                                $semester = DB::table('semesters')
                                    ->orderBy('id_semester', 'DESC')
                                    ->take('10')
                                    ->get();
                            @endphp
                            <select class="select2 form-control" name="id_semester" id="id_semester" required>
                                @foreach ($semester as $item)
                                    <option value="{{ $item->id_semester }}">{{ $item->nama_semester }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" style="border-radius: 25px;" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://unpkg.com/axios@0.27.2/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: "bootstrap",
                dropdownParent: $(".select2").parent()
            });
        });

        $(document).ready(function() {
            $('#dataTable').DataTable({
                "ordering": false,
                "searching": false,
                language: {
                    paginate: {
                        next: '&#8594;', // or '→'
                        previous: '&#8592;' // or '←' 
                    }
                }
            });
        });

        $('#modal').on('show.bs.modal', function(event) {
            // var button = $(event.relatedTarget) // Button that triggered the modal
            // var recipient = button.data('bs-id') // Extract info from data-* attributes
            // var cok = $("#myTable").DataTable().rows().data().toArray()

            // let cokData = cok.filter((dt) => {
            //     return dt.id == recipient;
            // })

            // document.getElementById("form").reset();
            // document.getElementById('id').value = ''
            // $('.error').empty();

            // if (recipient) {
            //     var modal = $(this)
            //     modal.find('#id').val(cokData[0].id)
            //     modal.find('#awal').val(cokData[0].awal)
            //     modal.find('#akhir').val(cokData[0].akhir)
            //     modal.find('#status').val(cokData[0].status)
            // }
        })
    </script>
@endpush
