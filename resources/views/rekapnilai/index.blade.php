@extends('template.index')

@push('nilai') active @endpush
@push('sub-nilai') show @endpush
@push('rekapnilai') active @endpush

@push('style')
<link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('select2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('select2theme4.css')}}">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
            <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Penilaian / Rekap Nilai Taruna</h2>
        </div>

        <div class="card mb-12">
            <div class="card-header">
                <a href="#" class=""></a>
            </div>
            <div class="card-body">
                @if(auth::user()->role != 'taruna')
                <form action="{{ route('rekapnilai.index') }}" method="GET">
                    {{-- @csrf --}}
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nama Taruna</label>
                        <div class="col-sm-3">
                            <select name="id_mahasiswa" class="form-control mahasiswa">
                                <option value="">----</option>
                                @foreach ($data as $d)
                                <option value="{{ $d->id_mahasiswa }}">{{ $d->nama_mahasiswa }} | {{ $d->nim }}</option>
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
                @else
                <form action="{{ route('rekapnilai.index') }}" method="GET">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Semester</label>
                        <div class="col-sm-3">
                            <?php
                                  $semester = DB::table('semesters')->orderBy('id_semester', 'DESC')->take('10')->get();    
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
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%" id="dataTable" cellspacing="0">
                        <thead>
                            <tr>
                                <td rowspan=2 width="300">Taruna</td>
                                <td rowspan="2" width="150">Nilai Jasmani (40%)</td>
                                <td colspan="3" width="390" class="text-center">Nilai Softskill (60%)</td>
                                <td rowspan="2" width="63">Nilai Akhir</td>
                                <td rowspan="2" width="20"></td>
                            </tr>
                            <tr>
                                <td width="130">Nilai Softskill Competency (50%)</td>
                                <td width="130">Nilai Pelanggaran (25%)</td>
                                <td width="130">Nilai Penghargaan (25%)</td>
                            </tr>

                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ @$data_nilai->nama_mahasiswa == null ? @$data_nilai[0]['nama_mahasiswa'] : @$data_nilai->nama_mahasiswa }}<br>
                                    {{ @$data_nilai->nim == null ? @$data_nilai[0]['nim'] : @$data_nilai->nim }}
                                </td>
                                <td>{{ $nilai1 = @$data_nilai->nilai_samapta == null ? round(@$data_nilai[0]['nilai_jasmani'], 2) : round(@$data_nilai->nilai_samapta, 2) }}
                                </td>

                                <td>{{ $nilai2 = @$data_nilai->nilai_softskill == null ? round(@$data_nilai[0]['nilai_softskill'], 2) : round(@$data_nilai->nilai_softskill, 2) }}
                                </td>

                                <td>{{ $nilai3 = @$data_nilai->nilai_pelanggaran == null ? round(@$data_nilai[0]['nilai_pelanggaran'], 2) : round(@$data_nilai->nilai_pelanggaran, 2) }}
                                </td>
                                <td>{{ $nilai4 = @$data_nilai->nilai_penghargaan == null ? round(@$data_nilai[0]['nilai_penghargaan'], 2) : round(@$data_nilai->nilai_penghargaan, 2) }}
                                </td>
                                <td>
                                    <?php
                                        $nilai1 = $nilai1 * 40 / 100;
                                        $nilai2 = $nilai2 * 50 / 100;
                                        $nilai3 = $nilai3 * 25 / 100;
                                        $nilai4 = $nilai4 * 25 / 100;
                                    ?>
                                    {{ 
                                        round(@$nilai1 + (($nilai2 + $nilai3 + $nilai4) * 60 / 100), 2)
                                    }}
                                </td>
                                <td>
                                    @if (@$data_nilai->id_rekap_nilai != null)
                                    <a href="{{ url('rapot') }}/{{ @$data_nilai->id_mahasiswa }}" class="btn btn-sm btn-success">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    @else
                                    @if (auth::user()->role == 'pengasuh')
                                    <?php $kordinator = DB::table('kordinator_pengasuhs')->where('id', auth::user()->id)->first(); ?>
                                        @if($kordinator)
                                            <a href="#" data-toggle="modal"
                                                data-target="#modal{{ @$data_nilai->nim == null ? @$data_nilai[0]['nim'] : @$data_nilai->nim }}"
                                                class="btn btn-sm btn-success">
                                                Sahkan Nilai!
                                            </a>
                                        @else
                                            <button disabled class="btn btn-sm btn-success">
                                                Sahkan Nilai!
                                            </button>
                                        @endif
                                    @else
                                    <button disabled class="btn btn-sm btn-success">
                                        Sahkan Nilai!
                                    </button>
                                    @endif
                                    <div class="modal fade"
                                        id="modal{{ @$data_nilai->nim == null ? @$data_nilai[0]['nim'] : @$data_nilai->nim }}"
                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Dialog Konfirmasi
                                                        Nilai</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                @if (
                                                @$data_nilai[0]['nilai_jasmani'] == 0 ||
                                                @$data_nilai[0]['nilai_softskill'] == 0
                                                // @$data_nilai[0]['nilai_pelanggaran'] == 0 ||
                                                // @$data_nilai[0]['nilai_penghargaan'] == 0
                                                )
                                                <div class="modal-body">
                                                    Ada Nilai yang Belum Diisi, Harap isi Nilai Kosong Terlebih Dahulu!
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="button" disabled
                                                        class="btn btn-primary">Simpan</button>
                                                </div>

                                                @else
                                                <form action="{{ url('simpanrekapnilai') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id_mahasiswa"
                                                        value="{{ @$data_nilai[0]['id_mahasiswa'] }}">
                                                    <input type="hidden" name="id_semester"
                                                        value="{{ @$data_nilai[0]['id_semester'] }}">
                                                    <input type="hidden" name="nilai_samapta"
                                                        value="{{ @$data_nilai[0]['nilai_jasmani'] }}">
                                                    <input type="hidden" name="nilai_softskill"
                                                        value="{{ @$data_nilai[0]['nilai_softskill'] }}">
                                                    <input type="hidden" name="nilai_pelanggaran"
                                                        value="{{ @$data_nilai[0]['nilai_pelanggaran'] }}">
                                                    <input type="hidden" name="nilai_penghargaan"
                                                        value="{{ @$data_nilai[0]['nilai_penghargaan'] }}">
                                                    <div class="modal-body">
                                                        Yakin Ingin Mensahkan Nilai ini?

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </td>
                            </tr>
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

<!-- Page level custom scripts -->
<script src="{{ asset('template/js/demo/datatables-demo.js') }}"></script>
<script src="{{ asset('select2.min.js') }}"></script>
<script>
    @if($message = Session::get('sukses'))
        toastr.success("{{ $message }}")
    @elseif($message = Session::get('gagal'))
        toastr.error("{{ $message }}")
    @endif
</script>
<script>
    $(document).ready(function() {
        $('#carisemester').select2({
            theme: 'bootstrap4'
        })
    })
</script>
<script>
    $(".mahasiswa").select2({
        theme: 'bootstrap4',
        placeholder: "Please Select"
    })
</script>
@endpush