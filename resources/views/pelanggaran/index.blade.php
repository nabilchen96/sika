@extends('template.index')

@push('master') active @endpush
@push('sub-master') show @endpush
@push('pelanggaran') active @endpush

@push('style')
  <link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
        <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Master Data / Data Pelanggaran</h2>
        </div>

        <div class="card mb-12">
            <div class="card-header">
              <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Tambah</a>
              <div class="modal fade" id="tambah" tabindex="-1" role="dialog"
                  aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Tambah Pelanggaran</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <form id="formtambah" action="{{ url('tambahpelanggaran') }}" method="post">
                              @csrf
                              <input type="hidden" name="submit" value="tambahpelanggaran">
                              <div class="modal-body">
                                  <div class="form-group">
                                      <label for="recipient-name" class="col-form-label">Pelanggaran</label>
                                      <textarea name="pelanggaran" rows="3" class="form-control"></textarea>
                                      @if (Session::get('submit') == 'tambahpelanggaran' && $errors->data->first('pelanggaran'))
                                        <p class="text-danger">{{ $errors->data->first('pelanggaran') }}</p>
                                      @endif
                                    </div>
                                  <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Kategori Pelanggaran</label>
                                    <select name="kategori_pelanggaran" class="form-control" >
                                      <option>Pelanggaran Ringan</option>
                                      <option>Pelanggaran Sedang</option>
                                      <option>Pelanggaran Berat</option>
                                      <option>Pelanggaran Khusus</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Poin Pelanggaran</label>
                                    <input type="number" class="form-control" name="poin_pelanggaran">
                                    @if (Session::get('submit') == 'tambahpelanggaran' && $errors->data->first('poin_pelanggaran'))
                                      <p class="text-danger">{{ $errors->data->first('poin_pelanggaran') }}</p>
                                    @endif
                                </div>
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary"
                                      data-dismiss="modal">Close</button>
                                  <input type="submit" class="btn btn-primary" value="Tambah">
                              </div>
                          </form>
                      </div>
                  </div>
                  <script type="text/javascript">
                    @if (Session::get('submit') == 'tambahpelanggaran' && count($errors->data) > 0)
                        $('#tambah').modal('show');
                    @endif
                  </script>
              </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%" id="table-pelanggaran" cellspacing="0">
                      <thead>
                        <tr>
                          <th style="width: 20px">No</th>
                          <th>Pelanggaran</th>
                          <th>Kategori Pelanggaran</th>
                          <th>Poin Pelanggaran</th>
                          <th width="10"></th>
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
        let id_pelanggaran, pelanggaran
        $('#table-pelanggaran').DataTable({
            processing: true,
            serverSide: true,
            ajax: 'pelanggaran-json',
            columns: [
                { data: 'id_pelanggaran', name:'id_pelanggaran', render: function (data, type, row, meta) {
                    id_pelanggaran = data
                    return meta.row + meta.settings._iDisplayStart + 1;
                }},
                { data: 'pelanggaran', name:'pelanggaran'},
                { data: 'kategori_pelanggaran', name:'kategori_pelanggaran'},
                { data: 'poin_pelanggaran', name:'poin_pelanggaran'},
                { data: null, name: 'edit', render: function(data, type, row, meta){
                  var edit = 'edit'+id_pelanggaran
                  return `<a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#edit`+id_pelanggaran+`"><i class="fas fa-edit"></i></a>
              <div class="modal fade" id="edit`+id_pelanggaran+`" tabindex="-1" role="dialog"
                  aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Tambah Pelanggaran</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <form action="{{ url('editpelanggaran') }}" method="post">
                              @csrf
                              <input type="hidden" name="submit" value="edit`+id_pelanggaran+`">
                              <input type="hidden" name="id_pelanggaran" value="`+id_pelanggaran+`">
                              <div class="modal-body">
                                  <div class="form-group">
                                      <label class="col-form-label">Pelanggaran</label>
                                      <textarea name="pelanggaran" rows="3" class="form-control" required>`+row.pelanggaran+`</textarea>
                                    </div>
                                  <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Kategori Pelanggaran</label>
                                    <select name="kategori_pelanggaran" class="form-control" >
                                      <option `+( row.kategori_pelanggaran == 'Pelanggaran Ringan' ? 'selected' : '')+`>Pelanggaran Ringan</option>
                                      <option `+( row.kategori_pelanggaran == 'Pelanggaran Sedang' ? 'selected' : '')+`>Pelanggaran Sedang</option>
                                      <option `+( row.kategori_pelanggaran == 'Pelanggaran Berat' ? 'selected' : '')+`>Pelanggaran Berat</option>
                                      <option `+( row.kategori_pelanggaran == 'Pelanggaran Khusus' ? 'selected' : '')+`>Pelanggaran Khusus</option>
                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Poin Pelanggaran</label>
                                    <input type="number" class="form-control" value="`+row.poin_pelanggaran+`" name="poin_pelanggaran" required>
                                  </div>
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary"
                                      data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary">Edit</button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>`
                }},
                { name: 'hapus', render: function(data, type, row, meta){
                  return `<button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus`+id_pelanggaran+`"><i class="fas fa-trash"></i></button>
                              <div class="modal fade" id="hapus`+id_pelanggaran+`" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel">Hapus Pelanggaran</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                              </button>
                                          </div>
                                          <div class="modal-body">
                                              <p>Yakin Ingin Menghapus Data Pelanggaran `+row.pelanggaran+` ?</p>
                                          </div>
                                          <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                              <a href="{{ url('hapuspelanggaran') }}/`+id_pelanggaran+`" class="btn btn-danger">Hapus</a>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                  `
                }},
            ]
        });
    });
  </script>
@endpush