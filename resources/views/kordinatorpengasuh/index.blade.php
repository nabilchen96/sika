@extends('template.index')
@push('master') active @endpush
@push('sub-master') show @endpush
@push('kordinatorpengasuh') active @endpush
@push('style')
<link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
            <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Master Data / Data Kordinator Pengasuh
            </h2>
        </div>

        <div class="card mb-12">
            <div class="card-header">
                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal"
                    data-target="#tambahkordinatorpengasuh"><i class="fas fa-plus"></i>Tambah</a>
                <div class="modal fade" id="tambahkordinatorpengasuh" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Pilih Kordinator</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ url('simpankordinatorpengasuh') }}" method="POST">
                                <div class="modal-body">
                                    @csrf
                                    <table class="table table-bordered table-striped" width="100%" id="dataTable1"
                                        cellspacing="0">
                                        <thead>
                                            <tr>
                                                <td></td>
                                                <td>No</td>
                                                <td>NIP</td>
                                                <td>Nama Pengasuh</td>
                                                <td>Jenis Kelamin</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pengasuh as $k => $item)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="id[]" value="{{ $item->id }}">
                                                </td>
                                                <td>{{ $k+1 }}</td>
                                                <td>{{ $item->nip }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->jk == 1 ? 'Laki-laki' : 'Perempuan' }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                                <th>NIP</th>
                                <th>Kordinator Pengasuh</th>
                                <th>Jenis Kelamin</th>
                                <th>Nomor Telpon</th>
                                <th>
                                    
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $k => $item)
                            <tr>
                                <td>{{ $k+1 }}</td>
                                <td>{{ $item->nip }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->jk == 1 ? 'Laki-laki' : 'Perempuan' }}</td>
                                <td>{{ $item->no_telp }}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus{{$item->id_kordinator_pengasuh}}"><i class="fas fa-trash"></i></button>
                                    <div class="modal fade" id="hapus{{$item->id_kordinator_pengasuh}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Hapus Kordinator Pengasuh</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Yakin Ingin Menghapus Data Ini?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <a href="{{ url('hapuskordinatorpengasuh') }}/{{ $item->id_kordinator_pengasuh }}" class="btn btn-danger">Hapus</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
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
    $(document).ready(function () {
      $('#dataTable1').DataTable();
     })
</script>
@endpush