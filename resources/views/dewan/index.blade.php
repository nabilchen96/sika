@extends('template.index')

@push('master') active @endpush
@push('sub-master') show @endpush
@push('dewan') active @endpush

@push('style')
  <link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
        <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Master Data / Data dewan</h2>
        </div>

        <div class="card mb-12">
            <div class="card-header">
              <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahdewan"><i class="fas fa-plus"></i> Tambah</a>
              <div class="modal fade" id="tambahdewan" tabindex="-1" role="dialog"
                  aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Tambah dewan</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <form id="formtambah" action="{{ url('tambahdewan') }}" method="post">
                              @csrf
                              <input type="hidden" name="submit" value="tambahdewan">
                              <div class="modal-body">
                                  <div class="form-group">
                                      <label for="recipient-name" class="col-form-label">Nama Pejabat</label>
                                      <input type="text" name="nama_pejabat" class="form-control" required placeholder="Nama Pejabat">
                                    </div>
                                  <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Jabatan</label>
                                    <input type="text" name="jabatan" class="form-control" required placeholder="Jabatan">
                                  </div>
                                  <div class="form-group">
                                    <label for="col-form-label">Jabatan Kepanitiaan</label>
                                    <input type="text" name="jabatan_kepanitiaan" class="form-control" required placeholder="Jabatan Kepanitiaan">
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
                    @if (Session::get('submit') == 'tambahdewan' && count($errors->data) > 0)
                        $('#tambahdewan').modal('show');
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
                          <th>Pejabata</th>
                          <th>Jabatan</th>
                          <th>Jabatan Kepanitiaan</th>
                          <th width="10"></th>
                          <th width="10"></th>
                        </tr>
                      </thead>
                      @foreach ($dewan as $k => $item)
                          <tr>
                            <td>{{ $k+1 }}</td>
                            <td>{{ $item->nama_pejabat }}</td>
                            <td>{{ $item->jabatan }}</td>
                            <td>{{ $item->jabatan_kepanitiaan }}</td>
                            <td>
                              <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#editdewan{{ $item->id }}"><i class="fas fa-edit"></i></a>
                              <div class="modal fade" id="editdewan{{ $item->id }}" tabindex="-1" role="dialog"
                                  aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel">Tambah dewan</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                              </button>
                                          </div>
                                          <form id="formtambah" action="{{ url('editdewan') }}" method="post">
                                              @csrf
                                              <input type="hidden" name="submit" value="dewan_{{$item->id}}">
                                              <input type="hidden" name="id" value="{{ $item->id }}" required>
                                              <div class="modal-body">
                                                  <div class="form-group">
                                                      <label for="recipient-name" class="col-form-label">Nama Pejabatn</label>
                                                      <input type="text" name="nama_pejabat" value="{{ $item->nama_pejabat }}" class="form-control" required placeholder="Nama Pejabat">
                                                    </div>
                                                  <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Jabatan</label>
                                                    <input type="text" name="jabatan" value="{{ $item->jabatan }}" class="form-control" required placeholder="Jabatan">
                                                </div>
                                                <div class="form-group">
                                                  <label for="col-form-label">Jabatan Kepanitiaan</label>
                                                  <input type="text" name="jabatan_kepanitiaan" value="{{ $item->jabatan_kepanitiaan }}" class="form-control" required placeholder="Jabatan Kepanitiaan">
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
                                @if (Session::get('submit') == 'dewan_'.$item->id && count($errors->data) > 0)
                                    $('#editdewan{{$item->id}}').modal('show');
                                @endif
                              </script>
                            </td>
                            <td>
                              <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapusdewan{{$item->id}}"><i class="fas fa-trash"></i></button>
                              <div class="modal fade" id="hapusdewan{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel">Hapus dewan</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                              </button>
                                          </div>
                                          <div class="modal-body">
                                              <p>Yakin Ingin Menghapus Data {{$item->nama_pejabat}} ?</p>
                                          </div>
                                          <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                              <a href="{{ url('hapusdewan') }}/{{ $item->id }}" class="btn btn-danger">Hapus</a>
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