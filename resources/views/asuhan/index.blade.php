@extends('template.index')
@push('tarunapengasuh') active @endpush

@push('style')
<link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('select2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('select2theme4.css')}}">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
            <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Master Data / Data Pengasuh</h2>
        </div>

        <div class="card mb-12">
            <div class="card-header">
                @if (auth::user()->role == 'admin' || auth::user()->role == 'pusbangkar')
                <a href="{{url('tambah-tarunapengasuh')}}" class="btn btn-sm btn-primary"><i
                    class="fas fa-plus"></i>Tambah</a>
                @endif
                <a href="{{ url('tarunapengasuhexport') }}" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> Export</a>
            </div>
            <div class="card-body">
                <div class="div @if(auth::user()->role != 'admin') d-none @endif">

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Pilih Nama Pengasuh</label>
                    <div class="col-sm-3">
                        <select name="cari" id="cari" class="form-control cari">

                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-3">
                        <button onclick="getdata()" class="btn btn-sm btn-success">
                            <i class="fas fa-search"></i> Tampilkan
                        </button>
                    </div>
                </div>
                <br>
            </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%" id="table-taruna" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 20px">No</th>
                                <th>NIT</th>
                                <th>Nama Taruna</th>
                                <th>Jenis Kelamin</th>
                                <th>Program Studi</th>
                                <th>Pengasuh</th>
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
<script src="{{ asset('select2.min.js') }}"></script>
<script>
    @if($message = Session::get('sukses'))
        toastr.success("{{ $message }}")
    @elseif($message = Session::get('gagal'))
        toastr.error("{{ $message }}")
    @endif
</script>
<script type="text/javascript">
    $('.cari').select2({
        theme: 'bootstrap4',
        placeholder: 'Cari...',
        ajax: {
            url: 'tarunapengasuh-json',
            dataType: 'json',
            processResults: function (data) {
                return {
                    results:  $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id,
                        }
                    })
                };
            },
            cache: true
        }
    })
</script>
<script type="text/javascript">
    $( document ).ready(function() {
        getdata()
    });
    function getdata() {
        var id = document.getElementById('cari').value

        $('#table-taruna').DataTable({
            bDestroy: true,
            processing: true,
            serverSide: true,
            ajax: {
                    url: 'kelompoktarunapengasuh-json',
                    data: {
                        'cari' : id
                    }
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
                { data: 'name', name: 'name'},
                { name: 'hapus', render:function(data, type, row, meta){
                    @if(auth::user()->role == 'admin' || auth::user()->role == 'pusbangkar')
                    return ` 
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus`+row.id_asuhan+`"><i class="fas fa-trash"></i></button>

                              <div class="modal fade" id="hapus`+row.id_asuhan+`" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel">Hapus Pelanggaran</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                              </button>
                                          </div>
                                          <div class="modal-body">
                                              <p>Yakin Ingin Menghapus Data ini ?</p>
                                          </div>
                                          <div class="modal-footer">
                                         
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                              <a href="{{ url('hapustarunapengasuh') }}/`+row.id_asuhan+`" class="btn btn-danger">Hapus</a>
                                          </div>
                                      </div>
                                  </div>
                              </div>`
                              @else
                              return `<button class="btn btn-danger btn-sm" disabled><i class="fas fa-trash"></i></button>`
                              @endif
                }}
            ]
        });
    }
</script>
@endpush