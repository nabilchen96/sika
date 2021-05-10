@extends('template.index')
@push('master') active @endpush
@push('sub-master') show @endpush
@push('pengasuh') active @endpush

@push('style')
<link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
            <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Master Data / Data Pengasuh</h2>
        </div>

        <div class="card mb-12">
            <div class="card-header">
                <a href="{{url('tambah-pengasuh')}}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i>
                    Tambah</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%" id="table-taruna" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 20px">No</th>
                                <th>NIP</th>
                                <th>Nama Pengasuh</th>
                                <th>Jenis Kelamin</th>
                                <th>Nomor Telpon</th>
                                <th>Alamat</th>
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
          ajax: 'pengasuh-json',
          columns: [
            { data: 'id', name:'id', render: function (data, type, row, meta) {
                id = data
                return meta.row + meta.settings._iDisplayStart + 1;
            }},
            { data: 'nip', name: 'nip'},
            { data: 'name', name: 'name'},
            { data: 'jk', name:'jk', render: function(data){
            return data == 1 ? 'Laki-laki' : 'Perempuan'
            }},
            { data: 'no_telp', name: 'no_telp'},
            { data: 'alamat', name: 'alamat'},
            { name: 'edit', render: function(data, type, row, meta){
                return '<a class="btn btn-sm btn-success" href="{{ url("pengasuh") }}/'+row.id+'"><i class="fas fa-edit"></i></a>'
            }},
            { name: 'hapus', render: function(data, type, row, meta){
                return `<button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus`+row.id+`"><i class="fas fa-trash"></i></button>
                        <div class="modal fade" id="hapus`+row.id+`" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Hapus Pengasuh</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Yakin Ingin Menghapus Data Pengasuh ?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <a href="{{ url('hapuspengasuh') }}/`+id+`"
                                            class="btn btn-danger">Hapus</a>
                                    </div>
                                </div>
                            </div>
                        </div>`
            }},
              
          ]
      });
  });
</script>
@endpush