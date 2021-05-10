@extends('template.index')

@push('master') active @endpush
@push('sub-master') show @endpush
@push('taruna') active @endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
        <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Master Data / Detail Data Taruna</h2>
        </div>

        <div class="card mb-12">
            <div class="card-header">
              <a href="{{url('taruna')}}" class="btn btn-sm btn-success"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">NIT</label>
                    <div class="col-sm-5">
                      <input class="form-control" disabled value="{{ $taruna->nim }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama Taruna</label>
                    <div class="col-sm-5">
                      <input class="form-control" disabled value="{{ $taruna->nama_mahasiswa }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
                    <div class="col-sm-5">
                      <input class="form-control" disabled value="{{ $taruna->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Tempat, TGL Lahir</label>
                    <div class="col-sm-3">
                      <input class="form-control" disabled value="{{ $taruna->tempat_lahir }}">
                    </div>
                    <div class="col-sm-2">
                        <input class="form-control" disabled value="{{ $taruna->tanggal_lahir }}">
                      </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Agama</label>
                    <div class="col-sm-5">
                      <input class="form-control" disabled value="{{ $taruna->agama }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Agama</label>
                    <div class="col-sm-5">
                      <input class="form-control" disabled value="{{ $taruna->agama }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Kelas</label>
                    <div class="col-sm-5">
                      <input class="form-control" disabled value="{{ $taruna->nama_kelas }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Program Studi</label>
                    <div class="col-sm-5">
                      <input class="form-control" disabled value="{{ $taruna->nama_program_studi }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Semester</label>
                    <div class="col-sm-5">
                      <input class="form-control" disabled value="{{ $taruna->semester }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Alamat</label>
                    <div class="col-sm-5">
                      <textarea class="form-control" disabled rows="10">{{ $taruna->alamat }}</textarea>
                    </div>
                </div>
                <form action="{{ url('updatetaruna') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_mahasiswa" value="{{$taruna->id_mahasiswa}}">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Foto</label>
                        <div class="col-sm-5">
                            <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto">
                            @error('foto')
                                <p style="margin-top: 5px;" class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-5">
                            <img width="100" src="{{ asset('file_upload') }}/{{ $taruna->foto }}" class="img-fluid img-thumbnail">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Wali yang Dihubungi</label>
                        <div class="col-sm-5">
                            <input class="form-control @error('wali_dihubungi') is-invalid @enderror" name="wali_dihubungi" value="{{ $taruna->wali_dihubungi }}">
                            @error('wali_dihubungi')
                                <p style="margin-top: 5px;" class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nomor Wali</label>
                        <div class="col-sm-5">
                            <input class="form-control @error('no_wali_dihubungi') is-invalid @enderror" name="no_wali_dihubungi" value="{{ $taruna->no_wali_dihubungi }}">
                            @error('no_wali_dihubungi')
                                <p style="margin-top: 5px;" class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Hubungan Wali</label>
                        <div class="col-sm-5">
                            <input class="form-control @error('hubungan_wali') is-invalid @enderror" name="hubungan_wali" value="{{$taruna->hubungan_wali}}">
                            @error('hubungan_wali')
                                <p style="margin-top: 5px;" class="text-danger">{{ $message }}</p>
                            @enderror
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
@endpush