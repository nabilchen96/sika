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
                
            </div>
            <div class="card-body">
                <form action="{{ route('rekapnilai.index') }}" method="GET">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Semester</label>
                        <div class="col-sm-3">
                            <?php
                                if (Auth::user()->role == 'taruna'){
                                    $semester = DB::table('semesters')
                                        ->orderBy('id_semester', 'DESC')
                                        ->where('is_semester_aktif', 1)
                                        ->take('10')->get();
                                }else{
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
                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="fas fa-search"></i> Tampilkan
                            </button>
                            @if(@$_GET['id_semester'])
                                <a href="{{ url('rekapnilaiexport') }}/{{ $_GET['id_semester'] }}" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> Export</a>
                            @endif
                        </div>
                    </div>
                    <br>
                </form>

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                          Nilai Sudah Disahkan
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                          Nilai Belum Disahkan
                      </a>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered table-striped" width="100%" id="dataTable" cellspacing="0">
                                <thead>
                                    <tr>
                                        <td rowspan="2" width="10">No</td>
                                        <td rowspan=2 width="300">Taruna</td>
                                        <td rowspan="2" width="150">Nilai Jasmani (40%)</td>
                                        <td colspan="3" width="390" class="text-center">Nilai Softskill (60%)</td>
                                        <td rowspan="2" width="63">Nilai Akhir</td>
                                        <td rowspan="2" width="63">Status</td>
                                        <td rowspan="2" width="20"></td>
                                    </tr>
                                    <tr>
                                        <td width="130">Nilai Softskill Competency (50%)</td>
                                        <td width="130">Nilai Pelanggaran (25%)</td>
                                        <td width="130">Nilai Penghargaan (25%)</td>
                                    </tr>
    
                                </thead>
                                <tbody>
                                    @foreach ($nilai_sah as $k => $n)
                                     <tr>
                                        <td>{{ $k+1 }}</td>
                                        <td>{{ $n->nama_mahasiswa }} <br> {{ $n->nim }}</td>
                                        <td>{{ $nilai1 = round(@$n->nilai_samapta, 2)}}</td>
                                        <td>{{ $nilai2 = round(@$n->nilai_softskill, 2) }}</td>
                                        <td>{{ $nilai3 = round(@$n->nilai_pelanggaran, 2) }}</td>
                                        <td>{{ $nilai4 = round(@$n->nilai_penghargaan, 2) }}</td>
                                        <td>
                                            <?php
                                                $nilai1 = $nilai1 * 40 / 100;
                                                $nilai2 = $nilai2 * 50 / 100;
                                                $nilai3 = $nilai3 * 25 / 100;
                                                $nilai4 = $nilai4 * 25 / 100;
                                            ?>
                                            {{ 
                                                $nilai_akhir = round(@$nilai1 + (($nilai2 + $nilai3 + $nilai4) * 60 / 100), 2)
                                            }}
                                        </td>
                                        <td>
                                            @if($nilai_akhir >= 75)
                                                <span class="badge badge-success">Lulus</span>
                                            @else
                                                <span class="badge badge-danger">Tidak Lulus</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('rapot') }}/{{ @$n->id_mahasiswa }}" class="btn btn-sm btn-success">
                                                <i class="fas fa-print"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered table-striped" width="100%" id="dataTable2" cellspacing="0">
                                <thead>
                                    <tr>
                                        <td rowspan="2" width="10">No</td>
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
                                    @foreach ($data_nilai as $k => $item)
                                     <tr>
                                        <td>{{ $k+1 }}</td>
                                        <td>{{ $item['nama_mahasiswa'] }} <br> {{ $item['nim'] }}</td>
                                        <td>{{ $nilai1 = round(@$item['nilai_jasmani'], 2)}}</td>
                                        
                                        <td>
                                            @php
                                                // $total = 0;
                                                // $jumlah = count($item['perevaluasi'] ?? []);
                                                // foreach ($item['perevaluasi'] ?? [] as $pe) {
                                                //     $total += $pe['nilai'];
                                                //     echo $pe['nilai'];
                                                // }
                                                // $nilai2 = round($total, 2);
                                                $nilai2 = round(collect($item['perevaluasi'] ?? [])->sum('nilai'), 2);
                                                @endphp
                                                {{ $nilai2 }}
                                            {{-- {{ $nilai2 }} --}}
                                        </td>

                                        <td>{{ $nilai3 = round(@$item['nilai_pelanggaran'], 2) }}</td>
                                        <td>{{ $nilai4 = round(@$item['nilai_penghargaan'], 2) }}</td>
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
                                            @if (auth::user()->role == 'pengasuh')
                                            <?php $kordinator = DB::table('kordinator_pengasuhs')->where('id', auth::user()->id)->first(); ?>
                                                @if($kordinator || auth::user()->role == 'pusbangkar')
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#modal{{ @$item['nim'] }}"
                                                        class="btn btn-sm btn-success">
                                                        Sahkan Nilai!
                                                    </a>
                                                @else
                                                    <button disabled class="btn btn-sm btn-success">
                                                        Sahkan Nilai!
                                                    </button>
                                                @endif
                                            @elseif(auth::user()->role == 'pusbangkar')
                                                <a href="#" data-toggle="modal"
                                                    data-target="#modal{{ @$item['nim'] }}"
                                                    class="btn btn-sm btn-success">
                                                    Sahkan Nilai!
                                                </a>
                                            @else
                                            <button disabled class="btn btn-sm btn-success">
                                                Sahkan Nilai!
                                            </button>
                                            @endif
                                            <div class="modal fade"
                                                id="modal{{ @$item['nim'] }}"
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
                                                        @$item['nilai_jasmani'] == 0 ||
                                                        @$nilai2 == 0
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
                                                                value="{{ @$item['id_mahasiswa'] }}">
                                                            <input type="hidden" name="id_semester"
                                                                value="{{ @$_GET['id_semester'] }}">
                                                            <input type="hidden" name="nilai_samapta"
                                                                value="{{ @$item['nilai_jasmani'] }}">
                                                            <input type="hidden" name="nilai_softskill"
                                                                value="{{ @$nilai2 }}">
                                                            <input type="hidden" name="nilai_pelanggaran"
                                                                value="{{ @$item['nilai_pelanggaran'] }}">
                                                            <input type="hidden" name="nilai_penghargaan"
                                                                value="{{ @$item['nilai_penghargaan'] }}">
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
<script>
    $(document).ready( function () {
        $('#dataTable2').DataTable();
    } );
</script>
@endpush