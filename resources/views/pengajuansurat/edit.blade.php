@extends('template.index')

@push('style')
{{-- <link rel="stylesheet" href="{{ asset('signature_pad/signature-pad.css') }}"> --}}
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
            <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Tambah Pengajuan Surat</h2>
        </div>

        <div class="card mb-12">
            <div class="card-header">
                <a href="{{url('pengajuansurat')}}" class="btn btn-sm btn-success"><i class="fas fa-arrow-left"></i>
                    Kembali</a>
            </div>
            <div class="card-body">
                <form
                    action="@if(auth::user()->role != 'taruna' and auth::user()->role != 'pusbangkar') 
                                {{ url('jawabpengajuan') }} 
                            @elseif(auth::user()->role == 'pusbangkar')  
                                {{ url('terbitkansurat') }}
                            @else 
                                {{ url('updatepengajuansurat') }} 
                            @endif"
                    method="POST" enctype="multipart/form-data">
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
                            <input type="text" name="jenis_pengajuan" value="{{ $data->jenis_pengajuan }}"
                                class="form-control" readonly>
                        </div>
                    </div>
                    @if ($data->jenis_pengajuan == 'surat izin')
                    <?php $keterangan = unserialize($data->keterangan); ?>
                    <div id="form_izin">
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Tempat Tujuan</label>
                            <div class="col-sm-5">
                                <input type="text" {{ auth::user()->role == 'pengasuh' ? 'readonly' : '' }}
                                    name="tempat_tujuan" class="form-control" value="{{ $keterangan[0] }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Keperluan</label>
                            <div class="col-sm-5">
                                <input type="text" {{ auth::user()->role == 'pengasuh' ? 'readonly' : '' }}
                                    name="keperluan" class="form-control" value="{{ $keterangan[1] }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Berangkat Tanggal</label>
                            <div class="col-sm-5">
                                <input type="date" {{ auth::user()->role == 'pengasuh' ? 'readonly' : '' }}
                                    name="berangkat_tanggal" class="form-control" value="{{ $keterangan[2] }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Kembali Tanggal</label>
                            <div class="col-sm-5">
                                <input type="date" {{ auth::user()->role == 'pengasuh' ? 'readonly' : '' }}
                                    name="kembali_tanggal" class="form-control" value="{{ $keterangan[3] }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Keterangan</label>
                        <div class="col-sm-5">
                            <textarea name="keterangan" {{ auth::user()->role == 'pengasuh' ? 'readonly' : '' }}
                                cols="30" rows="5" class="form-control" required>{{ $keterangan[4] }}</textarea>
                        </div>
                    </div>
                    @else
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Keterangan</label>
                        <div class="col-sm-5">
                            <textarea name="keterangan" {{ auth::user()->role == 'pengasuh' ? 'readonly' : '' }}
                                cols="30" rows="5" class="form-control" required>{{ $data->keterangan }}</textarea>
                        </div>
                    </div>
                    @endif

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">ACC/Tolak Pengajuan</label>
                        <div class="col-sm-5">
                            <select name="status_pengajuan" id="status_pengajuan" onchange="statuspengajuan()"
                                {{ auth::user()->role == 'pusbangkar' ? 'disabled' : '' }}
                                onchange="pilihstatuspengajuan()" class="form-control">
                                <option {{ $data->status_pengajuan == '0' ? 'selected' : '' }} value="0">Sedang Diproses
                                </option>
                                <option {{ $data->status_pengajuan == '1' ? 'selected' : '' }} value="1">Pengajuan
                                    Diterima</option>
                                <option {{ $data->status_pengajuan == '2' ? 'selected' : '' }} value="2">Pengajuan
                                    Ditolak</option>
                            </select>
                        </div>
                    </div>

                    <div id="form_alasan" class="d-none">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Alasan Ditolak</label>
                            <div class="col-sm-5">
                                <textarea name="alasan" id="alasan" class="form-control" cols="30" rows="5">{{ $data->alasan_tolak }}</textarea>
                            </div>
                        </div>
                    </div>

                    @if (auth::user()->role == 'pusbangkar' || auth::user()->role == 'admin')
                    @if ($data->status_pengajuan == '1')
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Tanda Tangan <br>Kepala Pusbangkar</label>
                            <div class="col-lg-4">
                                <canvas height="250" style="border: 1px solid #ced4da; border-radius: 8px;" id="ttd"></canvas>
                                <input type="hidden" name="ttd" id="nilaittd">
                            </div>
                            <div class="col-lg-1">
                                <div class="">
                                    <button type="button" class="btn btn-block btn-sm btn-danger" onclick="hapusttd()"
                                        data-action="clear"><i class="fas fa-trash"></i> Clear</button>
                                    <button type="button" class="btn btn-block btn-sm btn-primary" onclick="undottd()"
                                        data-action="clear"><i class="fas fa-undo"></i> Undo</button>
                                </div>
                            </div>
                        </div>
                    @endif
                    @endif

                    {{-- area untuk pusbangkar --}}
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-5">
                            <button type="submit" 
                            @if (auth::user()->role == 'pusbangkar' and $data->status_pengajuan != '1')
                                disabled
                            @endif 
                            class="btn btn-success">Simpan</button>
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
</script>
<script>
    $( document ).ready(function() {
        statuspengajuan()
    })

    function statuspengajuan(){
        var status_pengajuan = document.getElementById('status_pengajuan').value

        if(status_pengajuan == 2){
            document.getElementById('form_alasan').removeAttribute('class')
        }else{
            document.getElementById('form_alasan').setAttribute("class", "d-none");
        }
    }
</script>
<script src="{{ asset('signature_pad/signaturepad.js') }}"></script>
<script>
    var canvas = document.querySelector("canvas");

    var signaturePad = new SignaturePad(canvas);

    // signaturePad.minWidth = 5;
    // signaturePad.maxWidth = 10;

    signaturePad.toDataURL(); // save image as PNG


    // Returns signature image as an array of point groups
    const data = signaturePad.toData();

    // Draws signature image from an array of point groups
    signaturePad.fromData(data);

    // Returns true if canvas is empty, otherwise returns false
    signaturePad.isEmpty();

    // Unbinds all event handlers
    signaturePad.off();

    // Rebinds all event handlers
    signaturePad.on();


    function hapusttd(){
        // Clears the canvas
        signaturePad.clear();
    }

function undottd(){
    if (data) {
    data.pop(); // remove the last dot or line
    signaturePad.fromData(data);
  }
}

$(document).on('click','.btn',function(){
    $( "#nilaittd" ).val(signaturePad.toDataURL())

})

</script>

@endpush