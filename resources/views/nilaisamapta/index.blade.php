@extends('template.index')

@push('nilai') active @endpush
@push('sub-nilai') show @endpush
@push('penilaiansamapta') active @endpush

@push('style')
<link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('select2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('select2theme4.css')}}">
@endpush

@section('content')
<div class="row" style="zoom: 90%;">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
            <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Penilaian / Penilaian Jasmani
            </h2>
        </div>

        <div class="card mb-12">
            <div class="card-header">
                @if (auth::user()->role != 'taruna')
                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".modalform" data-array=""><i
                        class="fas fa-plus"></i> Tambah</a>

                <a href="{{ url('nilaisamaptaexport') }}/{{ @$_GET['id_semester'] }}" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> Export</a>
                @endif
            </div>
            <div class="card-body">

                <form action="{{ url('penilaiansamapta') }}" method="GET">
                    {{-- @csrf --}}
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Semester</label>
                        <div class="col-sm-3">
                            <?php $semester = DB::table('semesters')->orderBy('id_semester', 'DESC')->take('10')->get(); ?>
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
                    <table class="table table-bordered table-striped" width="100%" id="dataTable" cellspacing="0" style="font-size: 12px">
                        <thead>
                            <tr>
                                <th style="width: 20px; vertical-align: middle; text-align: center;" rowspan="2">No</th>
                                <th style="width: 100px; vertical-align: middle; text-align: center;" rowspan="2">Taruna</th>
                                <th style="width: 120px; text-align: center">Samapta A</th>
                                <th style="width: 160px; text-align: center">Samapta B</th>
                                <th style="text-align: center" width="120">Samapta</th>
                                <th style="width: 100px; vertical-align: middle; text-align: center;" rowspan="2">Nilai BMI</th>
                                <th style="text-align: center;">Nilai BBI</th>
                                <th style="text-align: center;">
                                    Nilai Jasmani
                                </th>
                                @if (auth::user()->role != 'taruna')
                                <th style="text-align: center" rowspan="2" width="10"></th>
                                @endif
                            </tr>
                            <tr>
                                <th style="text-align: center;">(A)</th>
                                <th style="text-align: center;">(B)</th>
                                <th style="text-align: center;">S = ( A + B) / 2</th>
                                <th style="text-align: center;">BBI = BB / (TB / 100) <sup>2</sup></th>
                                <th style="text-align: center;">(S * 70 / 100) + (BBI * 30 / 100) / 2</th>
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
                                    {{ round(($item->nilai_lari + (($item->nilai_push_up + $item->nilai_sit_up + $item->nilai_shuttle_run) / 3)) / 2, 2) }}
                                </td>
                                <td>
                                    <li>Tinggi Badan: {{ @$item->tinggi_badan }}</li>
                                    <li>Berat Badan: {{ @$item->berat_badan }}</li>
                                    <li>Nilai BMI:
                                        @if (@$item->berat_badan)
                                            {{ round(@$item->berat_badan / pow((@$item->tinggi_badan/100), 2), 2) }}
                                        @endif
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
                                    <a href="#" data-toggle="modal" data-target=".modalform"
                                        data-array="{{ json_encode($data[$k]) }}" class="btn btn-sm btn-success btn-block"><i
                                            class="fas fa-edit"></i></a>
                                    <a class="btn btn-sm btn-primary btn-block mt-1" href="{{ url('nilaisamaptaexportpdf') }}/{{ $item->id_nilai_samapta }}">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm btn-block mt-1" data-toggle="modal"
                                        data-target="#hapus{{ $item->id_nilai_samapta }}" data-array="hapus"><i
                                            class="fas fa-trash"></i></button>
                                    <div class="modal fade" id="hapus{{ $item->id_nilai_samapta }}" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form
                                                    action="{{ route('penilaiansamapta.destroy', [$item->id_nilai_samapta]) }}"
                                                    method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Hapus Template
                                                            Surat
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Yakin Ingin Menghapus Data Nilai ini ?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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

<div class="modal fade modalform" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Penilaian Jasmani</h5>
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
                        <select name="id_mahasiswa" class="form-control mahasiswa" id="id_mahasiswa" required>
                            @foreach ($taruna as $item)
                            <option value="{{ $item->id_mahasiswa }}">{{ $item->nama_mahasiswa }} | {{ $item->nim }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Semester</label>
                        <?php 
                            use App\Semester; 
                        ?>
                        <input readonly value="{{ Semester::where('is_semester_aktif', '1')->value('nama_semester') }}"
                            class="form-control">
                    </div>
                    <?php $aturan = DB::table('aturan_nilai_samaptas')->get(); ?>
                    <div class="form-group">
                        <label for="">Jarak Lari (meter)</label>
                        <input type="number" class="form-control" id="lari" name="lari" required placeholder="isi dengan angka tanpa koma">
                        <div class="mt-2 mb-4" style="font-size: 12px;">
                            <p><i class="fas fa-info-circle"></i>&nbsp; 
                                max jarak lari taruna: {{ $aturan->where('untuk', 'Taruna')->where('jenis_samapta', 'Lari')->max('jumlah') }}, 
                                max jarak lari taruni: {{ $aturan->where('untuk', 'Taruni')->where('jenis_samapta', 'Lari')->max('jumlah') }}
                                <br>
                                <i class="fas fa-info-circle"></i>&nbsp; 
                                min jarak lari taruna: {{ $aturan->where('untuk', 'Taruna')->where('jenis_samapta', 'Lari')->min('jumlah') }}, 
                                min jarak lari taruni: {{ $aturan->where('untuk', 'Taruni')->where('jenis_samapta', 'Lari')->min('jumlah') }}
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Push Up (JML)</label>
                        <input type="number" class="form-control" id="pushup" name="pushup" required placeholder="isi dengan angka tanpa koma">
                        <div class="mt-2 mb-4" style="font-size: 12px;">
                            <p><i class="fas fa-info-circle"></i>&nbsp; 
                                max push up taruna: {{ $aturan->where('untuk', 'Taruna')->where('jenis_samapta', 'Push-up')->max('jumlah') }}, 
                                max push up taruni: {{ $aturan->where('untuk', 'Taruni')->where('jenis_samapta', 'Push-up')->max('jumlah') }}
                                <br>
                                <i class="fas fa-info-circle"></i>&nbsp; 
                                min push up taruna: {{ $aturan->where('untuk', 'Taruna')->where('jenis_samapta', 'Push-up')->min('jumlah') }}, 
                                min push up taruni: {{ $aturan->where('untuk', 'Taruni')->where('jenis_samapta', 'Push-up')->min('jumlah') }}
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Sit Up (JML)</label>
                        <input type="number" class="form-control" id="situp" name="situp" required placeholder="isi dengan angka tanpa koma">
                        <div class="mt-2 mb-4" style="font-size: 12px;">
                            <p><i class="fas fa-info-circle"></i>&nbsp; 
                                max sit up taruna: {{ $aturan->where('untuk', 'Taruna')->where('jenis_samapta', 'Sit-up')->max('jumlah') }}, 
                                max sit up taruni: {{ $aturan->where('untuk', 'Taruni')->where('jenis_samapta', 'Sit-up')->max('jumlah') }}
                                <br>
                                <i class="fas fa-info-circle"></i>&nbsp; 
                                min sit up taruna: {{ $aturan->where('untuk', 'Taruna')->where('jenis_samapta', 'Sit-up')->min('jumlah') }}, 
                                min sit up taruni: {{ $aturan->where('untuk', 'Taruni')->where('jenis_samapta', 'Sit-up')->min('jumlah') }}
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Shuttle Run (DTK)</label>
                        <input type="number" step="0.01" class="form-control" id="shuttlerun" name="shuttlerun" required placeholder="isi dengan angka, gunakan titik untuk koma">
                        <div class="mt-2 mb-4" style="font-size: 12px;">
                            <p><i class="fas fa-info-circle"></i>&nbsp; 
                                max shuttle run taruna: {{ $aturan->where('untuk', 'Taruna')->where('jenis_samapta', 'Shuttle Run')->max('jumlah') }}, 
                                max shuttle run taruni: {{ $aturan->where('untuk', 'Taruni')->where('jenis_samapta', 'Shuttle Run')->max('jumlah') }}
                                <br>
                                <i class="fas fa-info-circle"></i>&nbsp; 
                                min shuttle run taruna: {{ $aturan->where('untuk', 'Taruna')->where('jenis_samapta', 'Shuttle Run')->min('jumlah') }}, 
                                min shuttle run taruni: {{ $aturan->where('untuk', 'Taruni')->where('jenis_samapta', 'Shuttle Run')->min('jumlah') }}
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Tinggi Badan</label>
                        <input type="number" step="0.01" class="form-control" id="tinggibadan" name="tinggibadan"
                            required placeholder="isi dengan angka, gunakan titik untuk koma">
                    </div>
                    <div class="form-group">
                        <label for="">Berat Badan</label>
                        <input type="number" step="0.01" class="form-control" id="beratbadan" name="beratbadan"
                            required placeholder="isi dengan angka, gunakan titik untuk koma">
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
<script src="{{ asset('select2.min.js') }}"></script>
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

        }else if(data == 'hapus'){

        }else if(data == 'export'){

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
<script>
    $(".mahasiswa").select2({
        theme: 'bootstrap4',
        placeholder: "Please Select"
    })
</script>
@endpush