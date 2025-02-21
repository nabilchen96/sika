@extends('template.index')

@push('nilai')
    active
@endpush
@push('sub-nilai')
    show
@endpush
@push('penilaiansoftskill')
    active
@endpush

@push('style')
    <link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('select2theme4.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
                <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Penilaian / Penilaian SoftSkill</h2>
            </div>

            <div class="card mb-12">
                <div class="card-header">
                    <a href="#" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> Export</a>
                </div>
                <div class="card-body">
                    <form action="{{ url('penilaiansoftskill') }}" method="GET">

                        {{-- @csrf --}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Semester</label>
                            <div class="col-sm-3">
                                <?php
                                if (Auth::user()->role == 'taruna') {
                                    $semester = DB::table('semesters')->orderBy('id_semester', 'DESC')->where('is_semester_aktif', 1)->take('10')->get();
                                } else {
                                    $semester = DB::table('semesters')->orderBy('id_semester', 'DESC')->take('10')->get();
                                }
                                ?>
                                <select name="id_semester" class="form-control">
                                    <option value="">Pilih Semester</option>
                                    @foreach ($semester as $item)
                                        <option {{ @$_GET['id_semester'] == $item->id_semester ? 'selected' : '' }}
                                            value="{{ $item->id_semester }}">{{ $item->nama_semester }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-2">
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="fas fa-search"></i> Tampilkan
                                </button>
                            </div>
                        </div>
                        <br>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" width="100%" id="dataTable" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="width: 20px">No</th>
                                    <th>Taruna</th>
                                    <th width="50%">Nilai Per-evaluasi</th>
                                    <th width="100">Nilai SoftSkill</th>
                                    <th width="10px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($nilai as $k => $item)
                                    <?php $total_nilai = 0; ?>
                                    <tr>
                                        <td>{{ $k + 1 }}</td>
                                        <td>{{ $item['nama_mahasiswa'] }} <br> {{ $item['nim'] }}</td>
                                        <td>
                                            @foreach ($item['perevaluasi'] as $p)
                                                <li>
                                                    {{ substr($p['jenis_softskill'], 0, 50) }}... :
                                                    {{ round($p['nilai'], 2) }}
                                                    {{-- <a href="{{ url('editpenilaiansoftskill') }}/{{ $item['id_mahasiswa'] }}/{{ $p['jenis_softskill'] }}?id_semester={{ @$_GET['id_semester'] }}">
                                                    <i class="fas fa-edit"></i></a> --}}
                                                </li>
                                                <?php
                                                $total_nilai = $total_nilai + round($p['nilai'], 2);
                                                ?>
                                            @endforeach
                                        </td>
                                        <td>{{ count($item['perevaluasi']) > 0 ? round($total_nilai / count($item['perevaluasi']), 2) : 0 }}</td>
                                        <td>
                                            <a href="{{ url('editpenilaiansoftskill') }}/{{ $item['id_mahasiswa'] }}?id_semester={{ Request('id_semester') }}"
                                                class="btn btn-block btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ url('nilaisoftskillexport') }}/{{ $item['id_mahasiswa'] }}"
                                                class="btn btn-block btn-sm btn-success mt-1">
                                                <i class="fas fa-file-excel"></i>
                                            </a>
                                            <a href="{{ url('nilaisoftskillexportpdf') }}/{{ $item['id_mahasiswa'] }}/{{ @$_GET['id_semester'] }}"
                                                class="btn btn-block btn-sm btn-primary mt-1">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                        </td>
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
    <script src="{{ asset('select2.min.js') }}"></script>

    <script src="{{ asset('template/js/demo/datatables-demo.js') }}"></script>
    <!-- Page level custom scripts -->
    <script>
        @if ($message = Session::get('sukses'))
            toastr.success("{{ $message }}")
        @elseif ($message = Session::get('gagal'))
            toastr.error("{{ $message }}")
        @endif
    </script>
    <script>
        $(".mahasiswa").select2({
            theme: 'bootstrap4',
            placeholder: "Please Select"
        })
    </script>
@endpush
