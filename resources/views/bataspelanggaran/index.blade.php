@extends('template.index')

@push('master') active @endpush
@push('sub-master') show @endpush
@push('bataspelanggaran') active @endpush

@push('style')
<link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<?php //dd(@$data); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
            <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Master Data / Data Batas Pelanggaran</h2>
        </div>

        <div class="card mb-12">
            <div class="card-header">
                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahkamar"><i
                        class="fas fa-plus"></i> Tambah</a>
                <div class="modal fade" id="tambahkamar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Batas Pelanggaran</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="formtambah" action="{{ url('tambahbataspelanggaran') }}" method="post">
                                @csrf
                                <input type="hidden" name="submit" value="tambah">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Tingkat</label>
                                        <select name="tingkat" class="form-control" required>
                                            <option>Tingkat I</option>
                                            <option>Tingkat II</option>
                                            <option>Tingkat III</option>
                                            <option>Tingkat IV</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Periode</label>
                                        <select name="periode" class="form-control" required>
                                            <option>Bulanan</option>
                                            <option>Semester</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="col-form-label">Batas Kritis</label>
                                        <input type="number" name="batas_kritis" class="form-control" required
                                            placeholder="isi dengan angka">
                                    </div>
                                    <div class="form-group">
                                        <label for="col-form-label">Batas Maksimal</label>
                                        <input type="number" name="batas_maksimal" class="form-control" required
                                            placeholder="isi dengan angka">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <input type="submit" class="btn btn-primary" value="Tambah">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%" id="dataTable" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 20px">No</th>
                                <th>Tingkat</th>
                                <th>Periode</th>
                                <th>Batas Kritis</th>
                                <th>Batas Maksimal</th>
                                <th width="10"></th>
                                <th width="10"></th>
                            </tr>
                        </thead>
                        @foreach ($data as $k => $item)
                        <tr>
                            <td>{{ $k+1 }}</td>
                            <td>{{ $item->tingkat }}</td>
                            <td>{{ $item->periode }}</td>
                            <td>{{ $item->batas_kritis }}</td>
                            <td>{{ $item->batas_maksimal }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-success" data-toggle="modal"
                                    data-target="#edit{{ $item->id_batas_pelanggaran }}"><i class="fas fa-edit"></i></a>
                                <div class="modal fade" id="edit{{ $item->id_batas_pelanggaran }}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Batas Pelanggaran
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form id="formtambah" action="{{ url('editbataspelanggaran') }}"
                                                method="post">
                                                @csrf
                                                <input type="hidden" name="id_batas_pelanggaran"
                                                    value="{{ $item->id_batas_pelanggaran }}" required>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="recipient-name"
                                                            class="col-form-label">Tingkat</label>
                                                        <select name="tingkat" class="form-control" required>
                                                            <option
                                                                {{ $item->tingkat == 'Tingkat I' ? 'selected' : '' }}>
                                                                Tingkat I</option>
                                                            <option
                                                                {{ $item->tingkat == 'Tingkat II' ? 'selected' : '' }}>
                                                                Tingkat II</option>
                                                            <option
                                                                {{ $item->tingkat == 'Tingkat III' ? 'selected' : '' }}>
                                                                Tingkat III</option>
                                                            <option
                                                                {{ $item->tingkat == 'Tingkat IV' ? 'selected' : '' }}>
                                                                Tingkat IV</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name"
                                                            class="col-form-label">Periode</label>
                                                        <select name="periode" class="form-control" required>
                                                            <option {{ $item->periode == 'Bulanan' ? 'selected' : '' }}>
                                                                Bulanan</option>
                                                            <option
                                                                {{ $item->periode == 'Semester' ? 'selected' : '' }}>
                                                                Semester</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="col-form-label">Batas Kritis</label>
                                                        <input type="number" name="batas_kritis" class="form-control"
                                                            value="{{ $item->batas_kritis }}" required
                                                            placeholder="isi dengan angka">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="col-form-label">Batas Maksimal</label>
                                                        <input type="number" name="batas_maksimal" class="form-control"
                                                            value="{{ $item->batas_maksimal }}" required
                                                            placeholder="isi dengan angka">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <input type="submit" class="btn btn-primary" value="Edit">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#hapus{{ $item->id_batas_pelanggaran }}"><i
                                        class="fas fa-trash"></i></button>
                                <div class="modal fade" id="hapus{{ $item->id_batas_pelanggaran }}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Hapus Hukuman</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Yakin Ingin Menghapus Data Batas Pelanggaran ini ?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <a href="{{ url('hapusbataspelanggaran') }}/{{ $item->id_batas_pelanggaran }}"
                                                    class="btn btn-danger">Hapus</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
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
<script>
    @if($message = Session::get('sukses'))
        toastr.success("{{ $message }}")
    @elseif($message = Session::get('gagal'))
        toastr.error("{{ $message }}")
    @endif
</script>
@endpush