@extends('template.index')

@push('master') active @endpush
@push('sub-master') show @endpush
@push('pengasuh') active @endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
        <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Master Data / Tambah Data Pengasuh</h2>
        </div>

        <div class="card mb-12">
            <div class="card-header">
              <a href="{{url('pengasuh')}}" class="btn btn-sm btn-success"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
            <form action="{{ url('simpan-pengasuh') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">NIP</label>
                        <div class="col-sm-5">
                            <input class="form-control @error('nip') is-invalid @enderror" placeholder="nomor induk pegawai" name="nip" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Pengasuh</label>
                        <div class="col-sm-5">
                            <input class="form-control @error('nama_pengasuh') is-invalid @enderror" placeholder="nama lengkap pengasuh" name="nama_pengasuh" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-5">
                            <select name="jk" class="form-control" required>
                                <option value="1">Laki-laki</option>
                                <option value="0">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tempat, TGL Lahir</label>
                        <div class="col-sm-3">
                            <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" placeholder="tempat lahir" required>
                        </div>
                        <div class="col-sm-2">
                            <input type="date" name="tgl_lahir" class="form-control @error('tgl_lahir') is-invalid @enderror" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nomor Telpon</label>
                        <div class="col-sm-5">
                        <input class="form-control @error('notelp') is-invalid @enderror" name="notelp" required placeholder="nomor telpon/handphone">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Alamat</label>
                        <div class="col-sm-5">
                        <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" rows="10" required placeholder="alamat rumah"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-5">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" required placeholder="email aktif">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-5">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="password">
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
  <script>
    @if($message = Session::get('sukses'))
        toastr.success("{{ $message }}")
    @elseif($message = Session::get('gagal'))
        toastr.error("{{ $message }}")
    @endif
  </script>
@endpush