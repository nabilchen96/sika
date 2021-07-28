@extends('template.index')

@push('nilai') active @endpush
@push('sub-nilai') show @endpush
@push('penilaiansamapta') active @endpush

@push('style')
<link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
            <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Penilaian / Penilaian Jasmani
            </h2>
        </div>

        <div class="card mb-12">
            <div class="card-header">
                @if (auth::user()->role != 'taruna')
                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".modal" data-array=""><i
                        class="fas fa-plus"></i> Tambah</a>
                @endif
            </div>
            <div class="card-body">

                <form action="{{ url('penilaiansamapta') }}" method="GET">
                    {{-- @csrf --}}
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Semester</label>
                        <div class="col-sm-3">
                            <?php
                                $semester = DB::table('semesters')->orderBy('id_semester', 'DESC')->take('10')->get();    
                            ?>
                            <select name="id_semester" class="form-control">
                                <option value="">Pilih Semester</option>
                                @foreach ($semester as $item)
                                    <option {{ @$_GET['id_semester'] == $item->id_semester ? 'selected' : '' }} value="{{ $item->id_semester }}">{{ $item->nama_semester }}</option>
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
                                <th width="120">Taruna</th>
                                <th>Nilai Samapta A</th>
                                <th>Nilai Samapta B</th>
                                <th width="70">Nilai Samapta</th>
                                <th>Nilai BMI</th>
                                <th>Nilai BBI</th>
                                <th>Nilai Jasmani</th>
                                @if (auth::user()->role != 'taruna')
                                <th width="10"></th>
                                <th width="10"></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $k => $item)
                            <tr>
                                <td>{{ $k+1 }}</td>
                                <td>
                                    {{ $item->nama_mahasiswa }}<br>
                                    {{ $item->nim }}
                                </td>
                                <td>
                                    <li>Nilai Lari: {{ $item->nilai_lari }}</li>
                                    <li>Jarak Lari: {{ $item->jarak_lari }}</li>
                                </td>
                                <td>
                                    <li>Nilai Push Up: {{ $item->nilai_push_up }}</li>
                                    <li>Jumlah Push Up: {{ $item->jumlah_push_up }}</li>
                                    <hr>
                                    <li>Nilai Sit Up: {{ $item->nilai_sit_up }}</li>
                                    <li>Jumlah Sit Up: {{ $item->jumlah_sit_up }}</li>
                                    <hr>
                                    <li>Nilai Shuttle Run: {{ $item->nilai_shuttle_run }}</li>
                                    <li>Jumlah Shuttle Run: {{ $item->jumlah_shuttle_run }}</li>
                                </td>
                                <td>
                                    {{ ($item->nilai_lari + (($item->nilai_push_up + $item->nilai_sit_up + $item->nilai_shuttle_run) / 3)) / 2 }}
                                </td>
                                <td>
                                    <li>Tinggi Badan: {{ $item->tinggi_badan }}</li>
                                    <li>Berat Badan: {{ $item->berat_badan }}</li>
                                    <li>Nilai BMI: {{ round($item->berat_badan / pow(($item->tinggi_badan/100), 2)) }}
                                    </li>
                                    <li>Stakes: {{ $item->stakes }} </li>
                                </td>
                                <td>
                                    {{ $item->nilai_bbi }}
                                </td>
                                <td>
                                    {{ $item->nilai_samapta }}
                                </td>
                                @if (auth::user()->role != 'taruna')
                                <td>
                                    <a href="#" data-toggle="modal" data-target=".modal"
                                        data-array="{{ json_encode($data[$k]) }}" class="btn btn-sm btn-success"><i
                                            class="fas fa-edit"></i></a>
                                </td>
                                <td>
                                    <form action="{{ route('penilaiansamapta.destroy', [$item->id_nilai_samapta]) }}"
                                        method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Penilaian Samapta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post">
                @csrf
                <input type="hidden" name="id_nilai_samapta" id="id_nilai_samapta">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Taruna</label>
                        <select name="id_mahasiswa" class="form-control" id="id_mahasiswa">
                            @foreach ($taruna as $item)
                            <option value="{{ $item->id_mahasiswa }}">{{ $item->nama_mahasiswa }} | {{ $item->nim }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Jarak Lari (meter)</label>
                        <input type="number" class="form-control" id="lari" name="lari">
                    </div>
                    <div class="form-group">
                        <label for="">Push Up (JML)</label>
                        <input type="number" class="form-control" id="pushup" name="pushup">
                    </div>
                    <div class="form-group">
                        <label for="">Sit Up (JML)</label>
                        <input type="number" class="form-control" id="situp" name="situp">
                    </div>
                    <div class="form-group">
                        <label for="">Shuttle Run (DTK)</label>
                        <input type="number" step="0.01" class="form-control" id="shuttlerun" name="shuttlerun">
                    </div>
                    <div class="form-group">
                        <label for="">Tinggi Badang</label>
                        <input type="number" step="0.01" class="form-control" id="tinggibadan" name="tinggibadan">
                    </div>
                    <div class="form-group">
                        <label for="">Berat Badan</label>
                        <input type="number" step="0.01" class="form-control" id="beratbadan" name="beratbadan">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Simpan">
                </div>
            </form>
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
<script>
    @if($message = Session::get('sukses'))
        toastr.success("{{ $message }}")
    @elseif($message = Session::get('gagal'))
        toastr.error("{{ $message }}")
    @elseif($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}")
        @endforeach
    @endif

    $('.modal').on('show.bs.modal', function (event) {
        var button  = $(event.relatedTarget)
        var data    = button.data('array')
        var hapus   = button.data('hapus')
        var modal   = $(this)

        if(data === ''){
            $('.form').attr('action', "{{ route('penilaiansamapta.store') }}").trigger('reset')

        }else{
            $('.form').attr('action', "{{ url('updatepenilaiansamapta') }}")
            
            modal.find('#id_nilai_samapta').val(data.id_nilai_samapta)
            modal.find('#id_mahasiswa').val(data.id_mahasiswa)
            modal.find('#lari').val(data.jarak_lari)
            modal.find('#pushup').val(data.jumlah_push_up)
            modal.find('#situp').val(data.jumlah_sit_up)
            modal.find('#shuttlerun').val(data.jumlah_shuttle_run)
            modal.find('#beratbadan').val(data.berat_badan)
            modal.find('#tinggibadan').val(data.tinggi_badan)
        }
    })
    
</script>
@endpush