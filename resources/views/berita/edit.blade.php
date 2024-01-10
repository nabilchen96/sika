@extends('template.index')

@push('style')
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
                <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Edit Berita</h2>
            </div>

            <div class="card mb-12">
                <div class="card-header">
                    <a href="{{ url('berita') }}" class="btn btn-sm btn-success"><i class="fas fa-arrow-left"></i> Kembali</a>
                </div>
                <div class="card-body">
                    <form action="{{ url('updateberita') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_berita" value="{{ $data->id_berita }}">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Judul Berita</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="judul_berita"
                                    value="{{ $data->judul_berita }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Isi Berita</label>
                            <div class="col-sm-10">
                                <textarea id="editor" name="isi_berita" cols="5" rows="10" class="form-control" required>{{ $data->isi_berita }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Gambar Utama</label>
                            <div class="col-sm-10">
                                <input type="file" name="gambar_utama" class="form-control">
                                <br>
                                <img src="{{ asset('gambar_berita') }}/{{ $data->gambar_utama }}" width="100px"
                                    alt="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Kategori</label>
                            <div class="col-sm-10">
                                <select onchange="applyorno()" id="kategori" name="kategori" class="form-control" required>
                                    <option value="">--Pilih Kategori--</option>
                                    <option {{ $data->kategori == '1' ? 'selected' : '' }} value="1">Pendidikan
                                    </option>
                                    <option {{ $data->kategori == '2' ? 'selected' : '' }} value="2">Lowongan Kerja
                                    </option>
                                    <option {{ $data->kategori == '3' ? 'selected' : '' }} value="3">Layanan</option>
                                    <option {{ $data->kategori == '4' ? 'selected' : '' }} value="4">Lainnya</option>
                                </select>
                            </div>
                        </div>
                        <div id="inputlamaran">

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
        document.addEventListener('DOMContentLoaded', function() {
            applyorno()
        })

        @if ($message = Session::get('sukses'))
            toastr.success("{{ $message }}")
        @elseif ($message = Session::get('gagal'))
            toastr.error("{{ $message }}")
        @endif
    </script>
    <script>
        // Replace the <textarea id="editor1"> with a CKEditor 4
        // instance, using default configuration.
        CKEDITOR.replace('editor');

        function applyorno() {

            var kategori = document.getElementById('kategori').value
            var html = ''

            if (kategori == '2') {

                html = `
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Upload Lamaran</label>
                            <div class="col-sm-10">
                                <select id="input_lamaran" name="input_lamaran" class="form-control" required>
                                    <option value="">--Pilih Apakah Upload Lamaran?--</option>
                                    <option {{ @$data->input_lamaran == 'Ya' ? 'selected' : '' }}>Ya</option>
                                    <option {{ @$data->input_lamaran == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                </select>
                            </div>
                        </div>
                        `

            } else {

                html = ``
            }

            document.getElementById('inputlamaran').innerHTML = html
        }
    </script>
@endpush
