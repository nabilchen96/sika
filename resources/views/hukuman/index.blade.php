@extends('template.index')

@push('master') active @endpush
@push('sub-master') show @endpush
@push('hukuman') active @endpush

@push('style')
<link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
            <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Master Data / Data Hukuman</h2>
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
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Hukuman</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="formtambah" action="{{ url('tambahhukuman') }}" method="post">
                                @csrf
                                <input type="hidden" name="submit" value="tambahhukuman">
                                <div class="modal-body">
                                    <div class="form-group after-add-more">
                                        <label for="recipient-name" class="col-form-label">Hukuman</label>
                                        <textarea name="hukuman" rows="3" class="form-control" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Kategori Hukuman</label>
                                        <select name="kategori_hukuman" class="form-control">
                                            <option>Pelanggaran Ringan</option>
                                            <option>Pelanggaran Sedang</option>
                                            <option>Pelanggaran Berat</option>
                                            <option>Pelanggaran Khusus</option>
                                            {{-- <option>Hukuman Batas Kritis Bulanan</option>
                                            <option>Hukuman Batas Maksimal Bulanan</option>
                                            <option>Hukuman Batas Kritis Semester</option>
                                            <option>Hukuman Batas Maksimal Semester</option> --}}
                                        </select>
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
                    <table class="table table-bordered table-striped" width="100%" id="table-taruna" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 20px">No</th>
                                <th>Hukuman</th>
                                <th>Kategori Hukuman</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
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
<script>
    $(function() {
        let id
        $('#table-taruna').DataTable({
            processing: true,
            serverSide: true,
            ajax: 'hukuman-json',
            columns: [
                { data: 'id_hukuman', name:'id_hukuman', render: function (data, type, row, meta) {
                    id = data
                    return meta.row + meta.settings._iDisplayStart + 1;
                }},
                { data: 'hukuman', name:'hukuman'},
                { data: 'kategori_hukuman', name:'kategori_hukuman'},
                { name: 'edit', render:function(data, type, row, meta){
                    return `<a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#edit`+row.id_hukuman+`"><i
                        class="fas fa-edit"></i></a>
                <div class="modal fade" id="edit`+row.id_hukuman+`" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Hukuman</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="formtambah" action="{{ url('edithukuman') }}" method="post">
                                @csrf
                                <input type="hidden" name="id_hukuman" class="form-control" value="`+row.id_hukuman+`">
                                <div class="modal-body">
                                    <div class="form-group after-add-more">
                                        <label for="recipient-name" class="col-form-label">Hukuman</label>
                                        <textarea name="hukuman" rows="3" class="form-control" required>`+row.hukuman+`</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Kategori Hukuman</label>
                                        <select name="kategori_hukuman" class="form-control">
                                            <option `+( row.kategori_hukuman == 'Hukuman Ringan' ? 'selected' : '')+`>Hukuman Ringan</option>
                                            <option `+( row.kategori_hukuman == 'Hukuman Sedang' ? 'selected' : '')+`>Hukuman Sedang</option>
                                            <option `+( row.kategori_hukuman == 'Hukuman Berat' ? 'selected' : '')+`>Hukuman Berat</option>
                                            <option `+( row.kategori_hukuman == 'Hukuman Khusus' ? 'selected' : '')+`>Hukuman Khusus</option>
                                            <option `+( row.kategori_hukuman == 'Hukuman Batas Kritis Bulanan' ? 'selected' : '')+`>Hukuman Batas Kritis Bulanan</option>
                                            <option `+( row.kategori_hukuman == 'Hukuman Batas Maksimal Bulanan' ? 'selected' : '')+`>Hukuman Batas Maksimal Bulanan</option>
                                            <option `+( row.kategori_hukuman == 'Hukuman Batas Kritis Semester' ? 'selected' : '')+`>Hukuman Batas Kritis Semester</option>
                                            <option `+( row.kategori_hukuman == 'Hukuman Maksimal Semester' ? 'selected' : '')+`>Hukuman Batas Maksimal Semester</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <input type="submit" class="btn btn-primary" value="Edit">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>`
                }},
                { name: 'hapus', render:function(data, type, row, meta){
                    return `<button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus`+row.id_hukuman+`"><i class="fas fa-trash"></i></button>
                                <div class="modal fade" id="hapus`+row.id_hukuman+`" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                <p>Yakin Ingin Menghapus Data Hukuman ini ?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <a href="{{ url('hapushukuman') }}/`+row.id_hukuman+`"
                                                    class="btn btn-danger">Hapus</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>`
                }}
            ]
        });
    });
</script>
@endpush