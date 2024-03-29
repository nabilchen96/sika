@extends('template.index')

@push('catatan') active @endpush
@push('sub-catatan') show @endpush
@push('catatanpelanggaran') active @endpush

@push('style')
<link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
            <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Catatan / Data Catatan Pelanggaran</h2>
        </div>
        <div class="card mb-12">
            <div class="card-header">
                <a href="{{ url('catatanpelanggaranexportall') }}" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> Export</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%" id="data-pelanggaran"
                        cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 20px">No</th>
                                <th>NIT</th>
                                <th>Nama Taruna</th>
                                <th>Jenis Kelamin</th>
                                <th>Program Studi</th>
                                <th>Poin Bulan Ini</th>
                                <th>Poin Semester Ini</th>
                                <th width="10"></th>
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
      $('#data-pelanggaran').DataTable({
          processing: true,
          serverSide: true,
          ajax:{
            url: '{!! url()->current() !!}'
        },
          columns: [
              { data: 'id_mahasiswa', name:'id_mahasiswa', render: function (data, type, row, meta) {
                  id = data
                  return meta.row + meta.settings._iDisplayStart + 1;
              }},
              { data: 'nim', name:'nim'},
              { data: 'nama_mahasiswa', name:'nama_mahasiswa'},
              { data: 'jenis_kelamin', name:'jenis_kelamin', render: function(data){
                return (data == 'L' ? 'Laki-laki' : 'Perempuan')
              }},
              { data: 'nama_program_studi', name:'nama_program_studi'},
              { data: 'poin_bulan_ini', name:'poin_bulan_ini'},
              { data: 'poin_semester_ini', name:'poin_semester_ini'},
              { name:'detail', render: function(data){
                return '<a href={{ url("catatanpelanggarandetail") }}/'+id+' class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>'
              }},
          ]
      });
  });
</script>
@endpush