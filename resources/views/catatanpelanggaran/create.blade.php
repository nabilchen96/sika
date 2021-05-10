@extends('template.index')

@push('catatan') active @endpush
@push('sub-catatan') show @endpush
@push('catatanpelanggaran') active @endpush

@push('style')
<link href="{{ asset('select2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('select2theme4.css')}}">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
            <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Catatan / Tambah Catatan Pelanggaran</h2>
        </div>

        <div class="card mb-12">
            <div class="card-header">
                <a href="{{url()->previous()}}" class="btn btn-sm btn-success"><i class="fas fa-arrow-left"></i>
                    Kembali</a>
            </div>
            <form action="{{ url('simpan-catatanpelanggaran') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">NIT</label>
                        <div class="col-sm-5">
                            <input class="form-control" disabled value="{{ $mahasiswa->nim }}">
                            <input type="hidden" name="id_mahasiswa" value="{{ $mahasiswa->id_mahasiswa }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Taruna</label>
                        <div class="col-sm-5">
                            <input class="form-control" disabled value="{{ $mahasiswa->nama_mahasiswa }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Pencatat</label>
                        <div class="col-sm-5">
                            <input class="form-control" disabled value="{{ auth()->user()->name }}">
                            <input type="hidden" name="id_pencatat" value="{{ auth()->id() }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Pelanggaran</label>
                        <div class="col-sm-5">
                            <select data-allow-clear="true" onchange="detailpelanggaran()"
                                id="cari" class="form-control">
                                <option value="">----</option>
                                @foreach ($pelanggaran as $item)
                                <option value="{{ $item->poin_pelanggaran }}/{{ $item->kategori_pelanggaran }}/{{ $item->id_pelanggaran}}">
                                    {{ $item->pelanggaran}}</option>

                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Poin</label>
                        <div class="col-sm-5">
                            <input class="form-control" disabled id="poin">
                            <input type="hidden" name="id_pelanggaran" id="id_pelanggaran">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jenis Pelanggaran</label>
                        <div class="col-sm-5">
                            <input class="form-control" disabled id="jenis">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tgl Pelanggaran</label>
                        <div class="col-sm-5">
                            <input type="date" class="form-control" name="tgl_pelanggaran" value="{{ date("Y-m-d") }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Bukti Pelanggaran</label>
                        <div class="col-sm-5">
                            <input type="file" class="form-control" name="bukti_pelanggaran">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Hukuman</label>
                        <div class="col-sm-5">
                            <textarea name="hukuman" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-5">
                            <button class="btn btn-sm btn-success" type="submit">
                                <i class="fas fa-plus"></i> Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<br>
@endsection

@push('scripts')
<script src="{{ asset('select2.min.js') }}"></script>
<script>
    @if($message = Session::get('sukses'))
        toastr.success("{{ $message }}")
    @elseif($message = Session::get('gagal'))
        toastr.error("{{ $message }}")
    @endif


    $("#cari").select2({
        theme: 'bootstrap4',
        placeholder: "Please Select"
    })

    function detailpelanggaran(){

        var str = document.getElementById('cari').value
        var res = str.split('/')

        document.getElementById('poin').value = res[0]
        document.getElementById('jenis').value = res[1]
        document.getElementById('id_pelanggaran').value = res[2]
    }
</script>
@endpush