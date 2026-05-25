@extends('template.index')

@push('kuesioner')
    active
@endpush

@push('style')
    <link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
                <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Data Kuesioner</h2>
            </div>

            <div class="card mb-12">
                <div class="card-header">
                    {{-- <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahkuesioner"><i
                            class="fas fa-plus"></i> Tambah</a> --}}
                    {{-- <a href="#" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> Export</a> --}}
                    <div class="modal fade" id="tambahkuesioner" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Testimoni</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="formtambah" action="{{ url('tambah-kuesioner') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="col-form-label">Judul Kuesioner</label>
                                            <input type="text" placeholder="Judul Kuesioner" name="judul_kuesioner"
                                                class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="col-form-label">Status Kuesioner</label>
                                            <select name="status" class="form-control" id="status">
                                                <option value="1">Aktif</option>
                                                <option value="0">Tidak Aktif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <input type="submit" class="btn btn-primary" value="Tambah">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" width="100%" id="dataTable" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="width: 20px">No</th>
                                    <th width="70px">Foto</th>
                                    <th style="width: 15%;">User</th>
                                    <th>Testimoni</th>
                                    <th>Tempat Kerja</th>
                                    <th>Status</th>
                                    <th style="width: 10px">Ubah</th>
                                    <th style="width: 10px">Hapus</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $k => $item)
                                    <tr>
                                        <td>{{ $k + 1 }}</td>
                                        <td>
                                            <div class="bg-secondary d-flex align-items-center justify-content-center text-white mr-3"
                                                style="background-image: url('uploads/testimoni/{{ $item->foto }}'); 
                                                    width: 60px; 
                                                    height: 60px; 
                                                    background-size: cover; 
                                                    background-position: center; 
                                                    border-radius: 8%;">
                                                {{-- 200x200 --}}
                                            </div>
                                        </td>
                                        <td>{{ $item->nama_mahasiswa }}<br><b>NIM. {{ $item->nim }}</b></td>
                                        <td>
                                            {{ $item->testimoni }}
                                        </td>
                                        <td>
                                            {{ @$item->tempat_kerja }}
                                        </td>
                                        <td>
                                            {{ @$item->status }}
                                        </td>
                                        <td>
                                            <a href="{{ url('ubahstatustestimoni') }}/{{ $item->id }}"
                                                class="btn btn-sm btn-info"><i class="fas fa-check"></i></a>
                                        </td>
                                        <td>
                                            <a href="{{ url('hapustestimoni') }}/{{ $item->id }}"
                                                class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
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
        @if ($message = Session::get('sukses'))
            toastr.success("{{ $message }}")
        @elseif ($message = Session::get('gagal'))
            toastr.error("{{ $message }}")
        @endif
    </script>
@endpush
