@extends('template.index')

@push('master') active @endpush
@push('sub-master') show @endpush
@push('kamar') active @endpush

@push('style')
  <link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
        <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Master Data / Data Kamar</h2>
        </div>

        <div class="card mb-12">
            <div class="card-header">
              <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahkamar"><i class="fas fa-plus"></i> Tambah</a>
              <div class="modal fade" id="tambahkamar" tabindex="-1" role="dialog"
                  aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Tambah Kamar</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <form id="formtambah" action="{{ url('tambahkamar') }}" method="post">
                              @csrf
                              <input type="hidden" name="submit" value="tambahkamar">
                              <div class="modal-body">
                                  <div class="form-group">
                                      <label for="recipient-name" class="col-form-label">Nama Kamar</label>
                                      <input type="text" name="nama_kamar" class="form-control" required placeholder="nama kamar di dalam gedung asrama">
                                      @if (Session::get('submit') == 'tambahkamar' && $errors->data->first('nama_kamar'))
                                        <p class="text-danger">{{ $errors->data->first('nama_kamar') }}</p>
                                      @endif
                                    </div>
                                  <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Nama Asrama</label>
                                    <select name="nama_asrama" class="form-control" required>
                                      <option>Alpha</option>
                                      <option>Bravo</option>
                                      <option>Charlie</option>
                                      <option>Delta</option>
                                      <option>Echo</option>
                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label for="col-form-label">Kapasitas Kamar</label>
                                    <input type="number" name="batas_kamar" class="form-control" required placeholder="isi dengan angka">
                                      @if (Session::get('submit') == 'tambahkamar' && $errors->data->first('batas_kamar'))
                                        <p class="text-danger">{{ $errors->data->first('batas_kamar') }}</p>
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
                    @if (Session::get('submit') == 'tambahkamar' && count($errors->data) > 0)
                        $('#tambahkamar').modal('show');
                    @endif
                  </script>
              </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%" id="dataTable" cellspacing="0">
                      <thead>
                        <tr>
                          <th style="width: 20px">No</th>
                          <th>Nama Kamar</th>
                          <th>Nama Asrama</th>
                          <th>Kapasitas Kamar</th>
                          <th width="10"></th>
                          <th width="10"></th>
                        </tr>
                      </thead>
                      @foreach ($kamar as $k => $item)
                          <tr>
                            <td>{{ $k+1 }}</td>
                            <td>{{ $item->nama_kamar }}</td>
                            <td>{{ $item->nama_asrama }}</td>
                            <td>{{ $item->batas_kamar }}</td>
                            <td>
                              <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#editkamar{{ $item->id_kamar }}"><i class="fas fa-edit"></i></a>
                              <div class="modal fade" id="editkamar{{ $item->id_kamar }}" tabindex="-1" role="dialog"
                                  aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel">Tambah Kamar</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                              </button>
                                          </div>
                                          <form id="formtambah" action="{{ url('editkamar') }}" method="post">
                                              @csrf
                                              <input type="hidden" name="submit" value="kamar_{{$item->id_kamar}}">
                                              <input type="hidden" name="id_kamar" value="{{ $item->id_kamar }}" required>
                                              <div class="modal-body">
                                                  <div class="form-group">
                                                      <label for="recipient-name" class="col-form-label">Nama Kamar</label>
                                                      <input type="text" name="nama_kamar" value="{{ $item->nama_kamar }}" class="form-control" required placeholder="nama kamar di dalam gedung asrama">
                                                      @if (Session::get('submit') == 'kamar_'.$item->id_kamar && $errors->data->first('nama_kamar'))
                                                        <p class="text-danger">{{ $errors->data->first('nama_kamar') }}</p>
                                                      @endif
                                                    </div>
                                                  <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Nama Asrama</label>
                                                    <select name="nama_asrama" class="form-control" required>
                                                      <option {{ $item->nama_asrama == 'Alpha' ? 'selected' : ''}} >Alpha</option>
                                                      <option {{ $item->nama_asrama == 'Bravo' ? 'selected' : ''}}>Bravo</option>
                                                      <option {{ $item->nama_asrama == 'Charlie' ? 'selected' : ''}}>Charlie</option>
                                                      <option {{ $item->nama_asrama == 'Delta' ? 'selected' : ''}}>Delta</option>
                                                      <option {{ $item->nama_asrama == 'Echo' ? 'selected' : ''}}>Echo</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                  <label for="col-form-label">Kapasitas Kamar</label>
                                                  <input type="number" name="batas_kamar" class="form-control" value="{{ $item->batas_kamar }}" required placeholder="isi dengan angka">
                                                  @if (Session::get('submit') == 'kamar_'.$item->id_kamar && $errors->data->first('batas_kamar'))
                                                    <p class="text-danger">{{ $errors->data->first('batas_kamar') }}</p>
                                                  @endif
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
                              </div>
                              <script type="text/javascript">
                                @if (Session::get('submit') == 'kamar_'.$item->id_kamar && count($errors->data) > 0)
                                    $('#editkamar{{$item->id_kamar}}').modal('show');
                                @endif
                              </script>
                            </td>
                            <td>
                              <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapuskamar{{$item->id_kamar}}"><i class="fas fa-trash"></i></button>
                              <div class="modal fade" id="hapuskamar{{$item->id_kamar}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel">Hapus Kamar</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                              </button>
                                          </div>
                                          <div class="modal-body">
                                              <p>Yakin Ingin Menghapus Data Kamar {{$item->nama_kamar}} ?</p>
                                          </div>
                                          <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                              <a href="{{ url('hapuskamar') }}/{{ $item->id_kamar }}" class="btn btn-danger">Hapus</a>
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