@extends('template.index')

@push('grupkordinasipengasuh') active @endpush

@push('style')
<link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
            <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Master Data / Grup Kordinasi Pengasuh
            </h2>
        </div>

        <div class="card mb-12">
            <div class="card-header">
                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".modal" data-array=""><i
                        class="fas fa-plus"></i> Tambah</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%" id="dataTable" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 20px">No</th>
                                <th>Kordinator</th>
                                <th>Daftar Pengasuh</th>
                                <th width="10"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $k => $item)
                            <tr>
                                <td>{{ $k+1 }}</td>
                                <td>{{ $item->kordinator_pengasuh }} | NIP: {{ $item->nip_kordinator }}</td>
                                <td>{{ $item->pengasuh }} | NIP: {{ $item->nip_pengasuh }}</td>
                                <td>
                                    <a href="{{ url('hapusgrupkordinasipengasuh') }}/{{ $item->id_grup_kordinasi_pengasuh }}" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </a>
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

<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Grup Pengasuh</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('simpangrupkordinasipengasuh') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Kordinator</label>
                        <select name="id_kordinator_pengasuh" class="form-control">
                            @foreach ($kordinator as $item)
                                <option value="{{ $item->id_kordinator_pengasuh }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Pilih Pengasuh</label>
                        <table class="table table-bordered table-striped" width="100%" id="dataTable1" cellspacing="0">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Simpan">
                </div>
            </form>
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
    @elseif($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}")
        @endforeach
    @endif
</script>
<script>
    $(document).ready(function () {
      $('#dataTable1').DataTable();
     })
</script>
@endpush