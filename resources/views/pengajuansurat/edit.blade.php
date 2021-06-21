@extends('template.index')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
            <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Tambah Pengajuan Surat</h2>
        </div>

        <div class="card mb-12">
            <div class="card-header">
                <a href="{{url('pengajuansurat')}}" class="btn btn-sm btn-success"><i
                        class="fas fa-arrow-left"></i> Kembali</a>
            </div>
            <div class="card-body">
                <form action="@if(auth::user()->role != 'taruna') {{ url('jawabpengajuan    ') }} @else {{ url('updatepengajuansurat') }} @endif" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_pengajuan_surat" value="{{ $data->id_pengajuan_surat }}">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Taruna</label>
                        <div class="col-sm-5">
                            <input class="form-control" value="{{ $data->nama_mahasiswa }}" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">NIT</label>
                        <div class="col-sm-5">
                            <input class="form-control" value="{{ $data->nim }}" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Semester</label>
                        <div class="col-sm-5">
                            <input class="form-control" value="{{ $data->nama_semester }}" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jenis Surat Pengajuan</label>
                        <div class="col-sm-5">
                            <input type="text" name="jenis_pengajuan" value="{{ $data->jenis_pengajuan }}" class="form-control" readonly>
                        </div>
                    </div>
                    @if ($data->jenis_pengajuan == 'surat izin')
                    <?php $keterangan = unserialize($data->keterangan); ?>
                    <div id="form_izin">
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Tempat Tujuan</label>
                            <div class="col-sm-5">
                                <input type="text" name="tempat_tujuan" class="form-control" value="{{ $keterangan[0] }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Keperluan</label>
                            <div class="col-sm-5">
                                <input type="text" name="keperluan" class="form-control" value="{{ $keterangan[1] }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Berangkat Tanggal</label>
                            <div class="col-sm-5">
                                <input type="date" name="berangkat_tanggal" class="form-control" value="{{ $keterangan[2] }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Kembali Tanggal</label>
                            <div class="col-sm-5">
                                <input type="date" name="kembali_tanggal" class="form-control" value="{{ $keterangan[3] }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Keterangan</label>
                        <div class="col-sm-5">
                            <textarea name="keterangan" cols="30" rows="5" class="form-control" required>{{ $keterangan[4] }}</textarea>
                        </div>
                    </div>
                    @else
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Keterangan</label>
                        <div class="col-sm-5">
                            <textarea name="keterangan" cols="30" rows="5" class="form-control" required>{{ $data->keterangan }}</textarea>
                        </div>
                    </div>
                    @endif

                    @if (auth::user()->role != 'taruna')
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">ACC/Tolak Pengajuan</label>
                        <div class="col-sm-5">
                            <select name="status_pengajuan" id="status_pengajuan" onchange="pilihstatuspengajuan()" class="form-control">
                                <option value="0">Sedang Diproses</option>
                                <option value="1">Pengajuan Diterima</option>
                                <option value="2">Pengajuan Ditolak</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-none" id="input_file_pengajuan">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Input File</label>
                            <div class="col-sm-5">
                                <input type="file" class="form-control" name="surat">
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-5">
                            <button type="submit" class="btn btn-success">Edit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<br>
@endsection

@push('scripts')
<script>
    @if($message = Session::get('sukses'))
        toastr.success("{{ $message }}")
    @elseif($message = Session::get('gagal'))
        toastr.error("{{ $message }}")
    @endif

    document.addEventListener("DOMContentLoaded", function() {
        pilihform()
    });

    function pilihstatuspengajuan(){
        var status_pengajuan = document.getElementById('status_pengajuan').value
        if(status_pengajuan == '1'){
            document.getElementById('input_file_pengajuan').removeAttribute('class')
        }else{
            document.getElementById('input_file_pengajuan').setAttribute('class', 'd-none')
        }
    }
</script>
@endpush