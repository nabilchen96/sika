@extends('template.index')

@push('tarunakamar') active @endpush

@push('style')
<link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('select2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('select2theme4.css')}}">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
            <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Master Data / Data Taruna Kamar</h2>
        </div>
        <div class="card mb-12">
            <div class="card-header">
                <a href="{{ url('tambah-tarunakamar') }}" class="btn btn-sm btn-primary"><i
                        class="fas fa-plus"></i> Tambah</a>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Pilih Nama Kamar</label>
                    <div class="col-sm-3">
                        <select data-allow-clear="true" name="cari" id="cari" class="form-control cari">

                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-2">
                        <button onclick="getdata()" class="btn btn-sm btn-success">
                            <i class="fas fa-search"></i> Tampilkan
                        </button>
                    </div>
                </div>
                <br>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%" id="table-taruna" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 20px">No</th>
                                <th>NIP</th>
                                <th>Nama Taruna</th>
                                <th>Program Studi</th>
                                <th>Kelas</th>
                                <th>Kamar</th>
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
        allowClear: true,
        theme: 'bootstrap4',
        placeholder: 'Cari...',
        ajax: {
            url: 'tarunakamar-json',
            dataType: 'json',
            processResults: function (data) {
                return {
                    results:  $.map(data, function (item) {
                        return {
                            text: item.nama_kamar,
                            id: item.id_kamar,
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
                    url: 'kelompokkamartaruna-json',
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
                { data: 'nama_program_studi', name:'nama_program_studi'},
                { data: 'nama_kelas', name: 'nama_kelas'},
                { data: 'nama_kamar', name: 'nama_kamar'},
                { name: 'hapus', render:function(data, type, row, meta){
                    return `<button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus`+row.id_taruna_kamar+`"><i class="fas fa-trash"></i></button>
                              <div class="modal fade" id="hapus`+row.id_taruna_kamar+`" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                              <a href="{{ url('hapustarunakamar') }}/`+row.id_taruna_kamar+`" class="btn btn-danger">Hapus</a>
                                          </div>
                                      </div>
                                  </div>
                              </div>`
                }}
            ]
        });
    }
</script>
@endpush