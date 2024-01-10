@extends('template.index')

@push('nilai') active @endpush
@push('sub-nilai') show @endpush
@push('penilaiansoftskill') active @endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
            <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Penilaian / Detail Penilaian SoftSkill</h2>
        </div>

        <div class="card mb-12">
            <div class="card-header">
                <a href="{{ url('penilaiansoftskill') }}?id_mahasiswa={{ $taruna->id_mahasiswa }}&id_semester={{ $id_semester }}" class="btn btn-sm btn-success"><i
                        class="fas fa-arrow-left"></i> Kembali</a>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama Taruna</label>
                    <div class="col-sm-3">
                        <input type="text" readonly value="{{ $taruna->nama_mahasiswa }}" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">NIT</label>
                    <div class="col-sm-3">
                        <input type="text" readonly value="{{ $taruna->nim }}" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Jenis Softskill</label>
                    <div class="col-sm-3">
                        <textarea class="form-control" rows="5" readonly>{{ $soal[0]->jenis_softskill }}</textarea>
                    </div>
                </div>
                <div class="table-responsive">
                    <form action="{{ url('updatepenilaiansoftskill') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_mahasiswa" value="{{ $taruna->id_mahasiswa }}">
                        <table class="table table-bordered table-striped" width="100%" id="dataTable" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="width: 20px">No</th>
                                    <th>Uraian</th>
                                    <th width="120px;">Pilihan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($soal as $k => $item)
                                <tr>
                                    <td>{{ $k+1 }}</td>
                                    <td>{{ $item->keterangan_softskill }}</td>
                                    <td>
                                        <?php
                                            $nilai = DB::table('penilaian_soft_skills')
                                                        ->join('semesters', 'semesters.id_semester', '=', 'penilaian_soft_skills.id_semester')
                                                        ->where('id_komponen_softskill', $item->id_komponen_softskill)
                                                        ->where('id_mahasiswa', $taruna->id_mahasiswa)
                                                        ->where('semesters.id_semester', @$_GET['id_semester'])
                                                        ->first();
                                        ?>
                                        <select name="nilai[]" class="form-control">
                                            <option {{ @$nilai === null ? 'selected' : '' }} value="">----</option>
                                            <option {{ @$nilai->nilai == 100 ? 'selected' : '' }} value=100>Ya</option>
                                            <option {{ @$nilai->nilai === 0.00 ? 'selected' : '' }} value=0>Tidak</option>
                                        </select>
                                        <input type="hidden" value="{{ $item->id_komponen_softskill }}"
                                            name="id_komponen_softskill[]">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
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