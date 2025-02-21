@extends('template.index')

@push('master') active @endpush
@push('sub-master') show @endpush
@push('komponensoftskill') active @endpush

@push('style')
    <link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
                <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Master Data / Komponen Softskill
                </h2>
            </div>

            <div class="card mb-12">
                <div class="card-header">
                    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".modalform" data-array=""><i
                            class="fas fa-plus"></i> Tambah</a>
                </div>

                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ Request('status') == '1' ? 'active' : '' }}" href="{{ url('komponensoftskill') }}?status=1"
                                aria-controls="home" aria-selected="true">
                                Komponen Aktif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request('status') == '0' ? 'active' : '' }}" href="{{ url('komponensoftskill') }}?status=0"
                                aria-controls="profile" aria-selected="false">
                                Komponen Tidak Aktif
                            </a>
                        </li>
                    </ul>
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered table-striped" width="100%" id="dataTable" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="width: 20px">No</th>
                                    <th>Evaluasi Softskill</th>
                                    <th>Uraian Softskill</th>
                                    <th>Status</th>
                                    <th width="10"></th>
                                    <th width="10"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $k => $item)
                                    <tr>
                                        <td>{{ $k + 1 }}</td>
                                        <td>{{ $item->jenis_softskill }}</td>
                                        <td>{{ $item->keterangan_softskill }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>
                                            <a href="#" data-array="{{ json_encode($data[$k]) }}" data-target=".modalform"
                                                data-toggle="modal" class="btn btn-sm btn-success">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                        <td>
                                            {{-- <a
                                                href="{{ url('hapuskomponensoftskill') }}/{{ $item->id_komponen_softskill }}"
                                                class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </a> --}}
                                            <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#hapus{{ $item->id_komponen_softskill }}" data-array="hapus"><i
                                                    class="fas fa-trash"></i></button>
                                            <div class="modal fade" id="hapus{{ $item->id_komponen_softskill }}" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Hapus Komponen
                                                                Softskill</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Yakin Ingin Menghapus Data Komponen Softskill ini ?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <a href="{{ url('hapuskomponensoftskill') }}/{{ $item->id_komponen_softskill }}"
                                                                class="btn btn-danger">Hapus</a>
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

    <div class="modal fade modalform" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Komponen Softskill</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form" method="post">
                    @csrf
                    <input type="hidden" name="id_komponen_softskill" id="id_komponen_softskill">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Evaluasi Softskill</label>
                            <textarea name="jenis_softskill" id="jenis_softskill" cols="30" rows="2" class="form-control"
                                placeholder="evaluasi softskill" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Uraian Softskill</label>
                            <textarea name="keterangan_softskill" id="keterangan_softskill" cols="30" rows="5"
                                class="form-control" placeholder="uraian softskill" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option>AKTIF</option>
                                <option>TIDAK AKTIF</option>
                            </select>
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

        $('.modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var data = button.data('array')
            var modal = $(this)

            if (data === '') {
                $('.form').attr('action', "{{ url('tambahkomponensoftskill') }}").trigger('reset')
            } else if (data == 'hapus') {

            } else {
                $('.form').attr('action', "{{ url('editkomponensoftskill') }}")

                modal.find('#id_komponen_softskill').val(data.id_komponen_softskill)
                modal.find('#jenis_softskill').val(data.jenis_softskill)
                modal.find('#keterangan_softskill').val(data.keterangan_softskill)
                modal.find('#status').val(data.status)
            }
        })

    </script>
@endpush