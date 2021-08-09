@extends('template.index')

@push('catatan') active @endpush
@push('sub-catatan') show @endpush
@push('catatansakit') active @endpush

@push('style')
<link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('select2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('select2theme4.css')}}">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
            <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Master Data / Data Catatan Sakit
            </h2>
        </div>

        <div class="card mb-12">
            <div class="card-header">
                @if (auth::user()->role != 'taruna')
                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambah"><i
                        class="fas fa-plus"></i> Tambah</a>

                {{-- <a href="#" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> Export</a> --}}
                <div class="modal fade" id="tambah" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Catatan Sakit</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @if (@$taruna->id_mahasiswa)
                            <form id="formtambah" action="{{ url('tambah-catatansakit') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="col-form-label">Nama Taruna</label>
                                        <input type="text" class="form-control" disabled
                                            value="{{ @$taruna->nama_mahasiswa }}">
                                        <input type="hidden" name="id_mahasiswa" value="{{ @$taruna->id_mahasiswa }}"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Tanggal Sakit</label>
                                        <input type="date" class="form-control" name="tgl_sakit" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Keterangan Sakit</label>
                                        <textarea name="keterangan_sakit" class="form-control" rows="3"
                                            required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Surat Sakit</label>
                                        <input type="file" class="form-control" name="surat_sakit" required>
                                        <p class="text-danger">Upload File png atau jpg</p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <input type="submit" class="btn btn-primary" value="Tambah">
                                </div>
                            </form>
                            @else
                            <div class="modal-body">
                                <p>Pilih Taruna Terlebih Dahulu</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="card-body">
                @if (auth::user()->role != 'taruna')
                <form action="{{ url('catatansakit') }}" method="GET">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Pilih Taruna</label>
                        <div class="col-sm-3">
                            <select data-allow-clear="true" name="id_mahasiswa" id="cari" class="form-control cari">

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="fas fa-search"></i> Tampilkan
                            </button>
                        </div>
                    </div>
                </form>
                <br>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%" id="dataTable" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 20px">No</th>
                                <th>Nama Taruna</th>
                                <th>Tanggal Sakit</th>
                                <th>Keterangan Sakit</th>
                                <th>Surat Sakit</th>
                                @if (auth::user()->role != 'taruna')
                                    <th width="10"></th>
                                    <th width="10"></th>
                                @endif
                            </tr>
                        </thead>
                        @foreach ($data as $key => $item)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $item->nim }}<br>{{ $item->nama_mahasiswa}}</td>
                            <td>{{ date('d-m-Y', strtotime($item->tgl_sakit)) }}</td>
                            <td>{{ $item->keterangan_sakit }}</td>
                            <td><a href="{{ asset('surat_sakit') }}/{{ $item->surat_sakit }}">Lihat File</a></td>
                            @if (auth::user()->role != 'taruna')
                            <td>
                                <a href="#" data-toggle="modal" data-target="#edit" data-array="{{ $data }}"
                                    data-i="{{ $key }}" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>
                            </td>
                            <td>
                                <a href="#" data-toggle="modal" data-target="#hapus{{ $item->id_catatan_sakit }}"
                                    class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                                <div class="modal fade" id="hapus{{ $item->id_catatan_sakit }}" role="dialog"
                                    aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Hapus Catatan Sakit</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="GET"
                                                action="{{ url('hapus-catatansakit') }}/{{ $item->id_catatan_sakit }}">
                                                @csrf
                                                <div class="modal-body">
                                                    <p>Yakin Ingin Menghapus Data Catatan Sakit ini ?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </table>

                    <div class="modal fade" id="edit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Catatan Sakit</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="POST" action="{{ url('edit-catatansakit') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id_catatan_sakit" id="id_catatan_sakit" required>
                                    <input type="hidden" name="id_mahasiswa" id="id_mahasiswa" required>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="col-form-label">Nama Mahasiswa</label>
                                            <input type="text" class="form-control" id="nama_mahasiswa" required
                                                disabled>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Tanggal Sakit</label>
                                            <input type="date" class="form-control" name="tgl_sakit" id="tgl_sakit"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Keterangan Sakit</label>
                                            <textarea class="form-control" name="keterangan_sakit" id="keterangan_sakit"
                                                rows="3" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="col-form-label">Surat Sakit <div id="link"></div></label>
                                            <input type="file" name="surat_sakit" class="form-control" required>
                                            <p class="text-danger">Upload File png atau jpg</p>
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
<script src="{{ asset('select2.min.js') }}"></script>

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
<script type="text/javascript">
    $('.cari').select2({
        allowClear: true,
        theme: 'bootstrap4',
        placeholder: 'Cari...',
        ajax: {
            url: 'catatanpenghargaan-json',
            dataType: 'json',
            processResults: function (data) {
                return {
                    results:  $.map(data, function (item) {
                        return {
                            text: item.nama_mahasiswa,
                            id: item.id_mahasiswa,
                        }
                    })
                };
            },
            cache: true
        }
    })

    $(".id_penghargaan").select2({
        theme: 'bootstrap4',
        placeholder: "Please Select"
    })

    $('#edit').on('show.bs.modal', function (event) {
        var button  = $(event.relatedTarget)
        var array   = button.data('array');
        var i       = button.data('i');
        var modal   = $(this)

        modal.find('#nama_mahasiswa').val(array[i].nama_mahasiswa)
        modal.find('#id_mahasiswa').val(array[i].id_mahasiswa)
        modal.find('#tgl_sakit').val(array[i].tgl_sakit)
        modal.find('#surat_sakit').val(array[i].surat_sakit)
        modal.find('#keterangan_sakit').val(array[i].keterangan_sakit)
        modal.find('#id_catatan_sakit').val(array[i].id_catatan_sakit)

        document.getElementById('link').innerHTML = '<a class="badge badge-success" href="{{ asset("surat_sakit") }}/'+array[i].surat_sakit+'">Lihat Surat</a>'
    })
</script>
@endpush