@extends('template.index')
@push('alumni')
    active
@endpush
@push('style')
    <link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
                <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Data Alumni</h2>
            </div>

            <div class="card mb-12">
                <div class="card-header">
                    <a href="{{ url('tambah-alumni') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i>
                        Tambah</a>
                    {{-- <a href="#" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> Export</a> --}}
                </div>
                <div class="card-body">
                    <form action="{{ url('/alumni') }}">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Pilih Tahun Lulus</label>
                            <div class="col-sm-3">
                                <?php
                                    
                                    $alumniByYear = DB::table('alumnis')->select(DB::raw('YEAR(tgl_lulus) as year'))
                                    ->groupBy('year')
                                    ->get();
                                ?>
                                <select name="tahun_lulus" id="tahun_lulus" class="form-control">
                                    <option>Pilih Tahun Lulus</option>
                                    @foreach ($alumniByYear as $item)
                                        <option {{ Request('tahun_lulus') == $item->year ? 'selected' : '' }} value="{{ $item->year }}">Tahun {{ $item->year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-2">
                                <button class="btn btn-sm btn-success">
                                    <i class="fas fa-search"></i> Tampilkan
                                </button>
                            </div>
                        </div>
                    </form>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" width="100%" id="table-alumni" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="width: 20px">No</th>
                                    <th>Foto</th>
                                    <th>NIT</th>
                                    <th>Nama Alumni</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Program Studi</th>
                                    <th>Tahun Lulus</th>
                                    <th>No Wali</th>
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
    <script src="https://unpkg.com/axios@1.1.2/dist/axios.min.js"></script>
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
            $('#table-alumni').DataTable({
                processing: true,
                serverSide: true,
                ajax: 'alumni-json?tahun_lulus={{ Request("tahun_lulus") }}',
                columns: [{
                        data: 'id_alumni',
                        name: 'id_alumni',
                        render: function(data, type, row, meta) {
                            id = data
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
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
                        data: 'nim',
                        name: 'nim'
                    },
                    {
                        data: 'nama_mahasiswa',
                        name: 'nama_mahasiswa'
                    },
                    {
                        data: 'jenis_kelamin',
                        name: 'jenis_kelamin',
                        render: function(data) {
                            return (data == 'L' ? 'Laki-laki' : 'Perempuan')
                        }
                    },
                    {
                        data: 'tanggal_lahir', 
                        name: 'tanggal_lahir'
                    },
                    {
                        data: 'nama_program_studi',
                        name: 'nama_program_studi'
                    },
                    {
                        data: 'tgl_lulus',
                        name: 'tgl_lulus'
                    },
                    {
                        data: 'no_wali_dihubungi',
                        name: 'no_wali'
                    },
                    {
                        render: function(data, type, row, meta) {
                            return '<a href="javascript:void(0)" onclick="hapusData(' + (row
                                    .id_alumni) +
                                ')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>'
                        }
                    },
                ]
            });
        });

        hapusData = (id) => {
            if (window.confirm('Apakah ingin menghapus Data?')) {
                axios.post('/hapus-alumni', {
                        id
                    })
                    .then((response) => {
                        if (response.data.responCode == 1) {
                            location.reload();
                        } else {
                            alert('Data gagal dihapus');
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }
    </script>
@endpush
