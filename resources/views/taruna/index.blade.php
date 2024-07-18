@extends('template.index')

@push('master')
    active
@endpush
@push('sub-master')
    show
@endpush
@push('taruna')
    active
@endpush

@push('style')
    <link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
                <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Master Data / Data Taruna</h2>
            </div>

            <div class="card mb-12">
                <div class="card-header">
                    <a href="{{ url('update-taruna-server') }}" class="btn btn-sm btn-success"><i
                            class="fas fa-cloud-download-alt"></i> Update</a>
                    <a href="{{ url('exporttaruna') }}" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i>
                        Export</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" width="100%" id="table-taruna" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="width: 20px">No</th>
                                    <th>Foto</th>
                                    <th>Nama Taruna</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Tempat Lahir</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Agama</th>
                                    <th>Program Studi</th>
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
    <script>
        @if ($message = Session::get('sukses'))
            toastr.success("{{ $message }}")
        @elseif ($message = Session::get('gagal'))
            toastr.error("{{ $message }}")
        @endif
    </script>
    <script>
        $(function() {
            let id
            $('#table-taruna').DataTable({
                processing: true,
                serverSide: true,
                ajax: 'taruna-json',
                columns: [{
                        data: 'id_mahasiswa',
                        name: 'id_mahasiswa',
                        render: function(data, type, row, meta) {
                            id = data
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        name: 'nim',
                        render: function(data, type, row, meta) {

                            return `<a href="${row.foto}" target="_blank" title="Buka gambar di tab baru">
                              <img src="${row.foto}" style="
                                              width: 50px;
                                              height: 50px;
                                              object-position: center;
                                              object-fit: cover;
                                              " />
                            </a>`
                        }
                    },
                    {
                        name: 'nama_mahasiswa',
                        render: function(data, type, row, meta) {
                          return `${row.nim} <br> ${row.nama_mahasiswa}`
                        }
                    },
                    {
                        data: 'jenis_kelamin',
                        name: 'jenis_kelamin',
                        render: function(data) {
                            return (data == 'L' ? 'Laki-laki' : 'Perempuan')
                        }
                    },
                    {
                        data: 'tempat_lahir',
                        name: 'tempat_lahir'
                    },
                    {
                        data: 'tanggal_lahir',
                        name: 'tanggal_lahir'
                    },
                    {
                        data: 'agama',
                        name: 'agama'
                    },
                    {
                        data: 'nama_program_studi',
                        name: 'nama_program_studi'
                    },
                    {
                        name: 'detail',
                        render: function(data) {
                            return '<a href={{ url('taruna') }}/' + id +
                                ' class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>'
                        }
                    },
                ]
            });
        });
    </script>
@endpush
