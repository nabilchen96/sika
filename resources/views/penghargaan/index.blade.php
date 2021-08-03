@extends('template.index')

@push('master') active @endpush
@push('sub-master') show @endpush
@push('penghargaan') active @endpush

@push('style')
<link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
            <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Master Data / Data Penghargaan</h2>
        </div>

        <div class="card mb-12">
            <div class="card-header">
                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambah"><i
                        class="fas fa-plus"></i> Tambah</a>
                <div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Penghargaan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="formtambah" action="{{ url('tambahpenghargaan') }}" method="post">
                                @csrf
                                <input type="hidden" name="submit" value="tambah">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Penghargaan</label>
                                        <input type="text" name="penghargaan" class="form-control" required placeholder="nama penghargaan">
                                        @if (Session::get('submit') == 'tambah' && $errors->data->first('penghargaan'))
                                        <p class="text-danger">{{ $errors->data->first('penghargaan') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label"></label>
                                        <select name="bidang_penghargaan" class="form-control" required>
                                            <option>Akademik</option>
                                            <option>Olahraga dan Seni</option>
                                            <option>Organisasi</option>
                                            <option>Kerohanian</option>
                                            <option>Pengabdian Masyarakat</option>
                                            <option>Ekonomi</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Poin Penghargaan</label>
                                        <input type="text" name="poin_penghargaan" class="form-control" required placeholder="isi dengan angka">
                                        @if (Session::get('submit') == 'tambah' &&
                                        $errors->data->first('poin_penghargaan'))
                                        <p class="text-danger">{{ $errors->data->first('poin_penghargaan') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <input type="submit" class="btn btn-primary" value="Tambah">
                                </div>
                            </form>
                        </div>
                    </div>
                    <script type="text/javascript">
                        @if (Session::get('submit') == 'tambah' && count($errors->data) > 0)
                        $('#tambah').modal('show');
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
                                <th>Penghargaan</th>
                                <th>Bidang Penghargaan</th>
                                <th>Poin Penghargaan</th>
                                <th width="10"></th>
                                <th width="10"></th>
                            </tr>
                        </thead>
                        @foreach ($penghargaan as $k => $item)
                        <tr>
                            <td>{{ $k+1 }}</td>
                            <td>{{ $item->penghargaan }}</td>
                            <td>{{ $item->bidang_penghargaan }}</td>
                            <td>{{ $item->poin_penghargaan }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-success" data-toggle="modal"
                                    data-target="#edit{{ $item->id_penghargaan }}"><i class="fas fa-edit"></i></a>
                                <div class="modal fade" id="edit{{ $item->id_penghargaan }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Penghargaan</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form id="formtambah" action="{{ url('editpenghargaan') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="submit"
                                                    value="edit{{$item->id_penghargaan}}">
                                                <input type="hidden" name="id_penghargaan"
                                                    value="{{ $item->id_penghargaan }}" required>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="recipient-name"
                                                            class="col-form-label">Penghargaan</label>
                                                        <input type="text" name="penghargaan"
                                                            value="{{ $item->penghargaan }}" required class="form-control">
                                                        @if (Session::get('submit') == 'edit'.$item->id_penghargaan &&
                                                        $errors->data->first('penghargaan'))
                                                        <p class="text-danger">{{ $errors->data->first('penghargaan') }}
                                                        </p>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">Bidang
                                                            Penghargaan</label>
                                                        <select name="bidang_penghargaan" class="form-control" required>
                                                            <option
                                                                {{ $item->bidang_penghargaan == 'Akademik' ? 'selected' : ''}}>
                                                                Akademik</option>
                                                            <option
                                                                {{ $item->bidang_penghargaan == 'Olahraga dan Seni' ? 'selected' : ''}}>
                                                                Olahraga dan Seni</option>
                                                            <option
                                                                {{ $item->bidang_penghargaan == 'Organisasi' ? 'selected' : ''}}>
                                                                Organisasi</option>
                                                            <option
                                                                {{ $item->bidang_penghargaan == 'Kerohanian' ? 'selected' : ''}}>
                                                                Kerohanian</option>
                                                            <option
                                                                {{ $item->bidang_penghargaan == 'Pengabdian Masyarakat' ? 'selected' : ''}}>
                                                                Pengabdian Masyarakat</option>
                                                            <option
                                                                {{ $item->bidang_penghargaan == 'Ekonomi' ? 'selected' : ''}}>
                                                                Ekonomi</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">Poin Penghargaan</label>
                                                        <input type="text" name="poin_penghargaan" required class="form-control" value="{{ $item->poin_penghargaan }}">
                                                        @if (Session::get('submit') == 'edit'.$item->id_penghargaan && $errors->data->first('poin_penghargaan'))
                                                        <p class="text-danger">
                                                            {{ $errors->data->first('poin_penghargaan') }}</p>
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
                                    @if (Session::get('submit') == 'edit'.$item->id_penghargaan && count($errors->data) > 0)
                                    $('#edit{{$item->id_penghargaan}}').modal('show');
                                @endif
                                </script>
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus{{$item->id_penghargaan}}"><i class="fas fa-trash"></i></button>
                                <div class="modal fade" id="hapus{{$item->id_penghargaan}}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Hapus Penghargaan</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Yakin Ingin Menghapus Data Penghargaan ?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <a href="{{ url('hapuspenghargaan') }}/{{ $item->id_penghargaan }}"
                                                    class="btn btn-danger">Hapus</a>
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