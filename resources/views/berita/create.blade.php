@extends('template.index')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
            <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Tambah Berita</h2>
        </div>

        <div class="card mb-12">
            <div class="card-header">
                <a href="{{url('berita')}}" class="btn btn-sm btn-success"><i class="fas fa-arrow-left"></i>
                    Kembali</a>
            </div>
            <div class="card-body">
                <form action="{{ url('simpanberita') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Judul Berita</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="judul_berita" value="{{ old('judul_berita') }}" required>
                            @error('judul_berita')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Isi Berita</label>
                        <div class="col-sm-10">
                            <textarea id="editor" name="isi_berita" cols="5" rows="10" class="form-control" required>{{ old('isi_berita') }}</textarea>
                            @error('isi_berita')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Gambar Utama</label>
                        <div class="col-sm-10">
                            <input type="file" name="gambar_utama" class="form-control" required>
                            @error('gambar_utama')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Kategori</label>
                        <div class="col-sm-10">
                            <select name="kategori" class="form-control" required>
                                <option value="1">Pendidikan</option>
                                <option value="2">Lowongan Kerja</option>
                                <option value="3">Layanan</option>
                                <option value="4">Lainnya</option>
                            </select>
                            @error('kategori')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-5">
                            <button type="submit" class="btn btn-sm btn-success">Tambah</button>
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
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
    // Replace the <textarea id="editor1"> with a CKEditor 4
    // instance, using default configuration.
    CKEDITOR.replace( 'editor' );
</script>
@endpush