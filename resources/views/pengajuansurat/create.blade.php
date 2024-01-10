@extends('template.index')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
                <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Tambah Pengajuan Surat</h2>
            </div>

            <div class="card mb-12">
                <div class="card-header">
                    <a href="{{ url('pengajuansurat') }}" class="btn btn-sm btn-success"><i class="fas fa-arrow-left"></i>
                        Kembali</a>
                </div>
                <div class="card-body">
                    <form action="{{ url('simpanpengajuansurat') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <?php $data = DB::table('tarunas')
                            ->where('nim', auth::user()->nip)
                            ->first(); ?>
                        <input type="hidden" name="id" value="{{ @$data->id_mahasiswa }}">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nama Taruna</label>
                            <div class="col-sm-5">
                                <input class="form-control" value="{{ @$data->nama_mahasiswa }}" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">NIT</label>
                            <div class="col-sm-5">
                                <input class="form-control" value="{{ @$data->nim }}" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Semester</label>
                            <div class="col-sm-5">
                                <input type="hidden" name="id_semester" value="{{ $semester->id_semester }}">
                                <input class="form-control" value="{{ $semester->nama_semester }}" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Jenis Surat Pengajuan</label>
                            <div class="col-sm-5">
                                <select name="jenis_pengajuan" id="jenis_pengajuan" class="form-control"
                                    onchange="pilihform()" required>
                                    <option value="">--Pilih Jenis Pengajuan--</option>
                                    <option value="surat izin">Surat Izin</option>
                                    <option value="surat keterangan">Surat Keterangan Kuliah</option>
                                </select>
                            </div>
                        </div>
                        <div id="form_izin">

                        </div>
                        <div id="form_waktu_izin">

                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Keterangan</label>
                            <div class="col-sm-5">
                                <textarea placeholder="Keterangan" name="keterangan" cols="30" rows="5" class="form-control" required></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"></label>
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
        @if ($message = Session::get('sukses'))
            toastr.success("{{ $message }}")
        @elseif ($message = Session::get('gagal'))
            toastr.error("{{ $message }}")
        @endif

        function pilihform() {
            var jenis_pengajuan = document.getElementById('jenis_pengajuan').value
            if (jenis_pengajuan == 'surat izin') {
                document.getElementById('form_izin').innerHTML = `
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Tempat Tujuan</label>
                    <div class="col-sm-5">
                        <input type="text" name="tempat_tujuan" placeholder="Tempat Tujuan" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Keperluan</label>
                    <div class="col-sm-5">
                        <input type="text" name="keperluan" placeholder="keperluan" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Berangkat Tanggal</label>
                    <div class="col-sm-5">
                        <input type="datetime-local" name="berangkat_tanggal" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Kembali Tanggal</label>
                    <div class="col-sm-5">
                        <input type="datetime-local" name="kembali_tanggal" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Waktu Izin</label>
                    <div class="col-sm-5">
                        <select onchange="waktuizin()" name="waktu_izin" id="waktu_izin" class="form-control">
                            <option value="">--Pilih Waktu Izin--</option>
                            <option>Jam Akademik</option>
                            <option>Bukan Jam Akademik</option>
                        </select>
                    </div>
                </div>
            `
            } else {
                document.getElementById('form_izin').innerHTML = ''
            }
        }

        function waktuizin() {
            var waktu_izin = document.getElementById('waktu_izin').value
            if (waktu_izin == 'Jam Akademik') {
                document.getElementById('form_waktu_izin').innerHTML = `
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Lampiran</label>
                    <div class="col-sm-5">
                        <input type="file" name="lampiran" placeholder="Lampiran" class="form-control" required>
                    </div>
                </div>
            `
            } else {
                document.getElementById('form_waktu_izin').innerHTML = ''
            }
        }
    </script>
@endpush
