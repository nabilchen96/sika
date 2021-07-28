@extends('template.index')

@push('catatan') active @endpush
@push('sub-catatan') show @endpush
@push('catatanpelanggaran') active @endpush

@push('style')
<link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('select2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('select2theme4.css')}}">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
            <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Master Data / Data Catatan Pelanggaran
            </h2>
        </div>

        <div class="row">
            <div class="col-lg-9">
                <div class="card mb-12">
                    <div class="card-header">
                        @if (auth::user()->role != 'taruna')
                        <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahkamar"><i
                            class="fas fa-plus"></i> Tambah</a>    
                        @endif
                        
                        {{-- <a href="#" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> Export</a> --}}
                        <div class="modal fade" id="tambahkamar" role="dialog" aria-labelledby="myModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah Catatan Pelanggaran</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @if (@$taruna->id_mahasiswa)
                                    <form id="formtambah" action="{{ url('simpan-catatanpelanggaran') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" class="form-control"
                                            value="{{ auth::check() ? @auth::user()->id : ''}}" name="id_pencatat"
                                            readonly>
                                        <input type="hidden" value="{{ $taruna->id_mahasiswa }}" name="id_mahasiswa">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="recipient-name" class="col-form-label">Pengasuh</label>
                                                <input type="text" class="form-control"
                                                    value="{{ auth::check() ? @auth::user()->name : ''}}" readonly
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="col-form-label">Nama Taruna</label>
                                                <input type="text" class="form-control" disabled
                                                    value="{{ $taruna->nama_mahasiswa }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="col-form-label">Tanggal
                                                    Pelanggaran</label>
                                                <input type="date" class="form-control" name="tgl_pelanggaran"
                                                    value="{{ date('Y-m-d') }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="col-form-label">Jenis
                                                    Pelanggaran</label>
                                                <select name="id_pelanggaran" class="form-control pelanggaran">
                                                    @foreach ($pelanggaran as $item)
                                                    <option value=" {{$item->id_pelanggaran}} ">{{ $item->pelanggaran }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="col-form-label">Bukti
                                                    Pelanggaran</label>
                                                <input type="file" name="bukti_pelanggaran" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="col-form-label">Hukuman</label>
                                                <textarea name="hukuman" rows="3" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <input type="submit" class="btn btn-primary" value="Tambah">
                                        </div>
                                    </form>
                                    @else
                                    <div class="modal-body">
                                        <p>Pilih Taruna Terlebih Dahulu</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (auth::user()->role != 'taruna')
                        <form action="{{ url('catatanpelanggaran') }}" method="GET">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Pilih Taruna</label>
                                <div class="col-sm-3">
                                    <select data-allow-clear="true" name="id_mahasiswa" id="cari"
                                        class="form-control cari">

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
                            <table class="table table-bordered table-striped" width="100%" id="dataTable"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style="width: 20px">No</th>
                                        <th width="80">Tanggal</th>
                                        <th>Jenis Pelanggaran</th>
                                        <th>Poin</th>
                                        <th>Bukti Pelanggaran</th>
                                        <th width="10"></th>
                                        <th width="10"></th>
                                    </tr>
                                </thead>
                                @foreach ($data as $k => $item)
                                <tr>
                                    <td>{{ $k+1 }}</td>
                                    <td>{{ date("d-m-Y", strtotime($item->created_at)) }}</td>
                                    <td>{{ $item->pelanggaran }}</td>
                                    <td>{{ $item->poin_pelanggaran }}</td>
                                    <td>
                                        @if ($item->bukti_pelanggaran == null)
                                        bukti pelanggaran tidak diupload
                                        @else
                                        <a href="{{ asset('bukti_pelanggaran') }}/{{ $item->bukti_pelanggaran }}">Lihat
                                            Bukti
                                            Pelanggaran
                                        </a>
                                        @endif
                                    </td>
                                    <td>
                                        <button {{ auth::user()->role == 'taruna' ? "disabled" : '' }} href="#" class="btn btn-sm btn-success" data-toggle="modal"
                                            data-target="#edit{{ $item->id_catatan_pelanggaran }}"><i
                                                class="fas fa-edit"></i></button>
                                        <div class="modal fade" id="edit{{ $item->id_catatan_pelanggaran }}"
                                            role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Tambah Catatan
                                                            Pelanggaran</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    @if (@$taruna->id_mahasiswa)
                                                    <form action="{{ url('updatecatatanpelanggaran') }}" method="post"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="id_catatan_pelanggaran"
                                                            value="{{ $item->id_catatan_pelanggaran }}">
                                                        <input type="hidden" class="form-control"
                                                            value="{{ auth::check() ? @auth::user()->id : ''}}"
                                                            name="id_pencatat" readonly>
                                                        <input type="hidden" value="{{ $taruna->id_mahasiswa }}"
                                                            name="id_mahasiswa">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="recipient-name"
                                                                    class="col-form-label">Pengasuh</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ auth::check() ? @auth::user()->name : ''}}"
                                                                    readonly required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="col-form-label">Nama
                                                                    Taruna</label>
                                                                <input type="text" class="form-control" disabled
                                                                    value="{{ $taruna->nama_mahasiswa }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="recipient-name"
                                                                    class="col-form-label">Tanggal
                                                                    Pelanggaran</label>
                                                                <input type="date" name="tgl_pelanggaran"
                                                                    class="form-control" value="{{ $item->created_at }}"
                                                                    required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="col-form-label">Jenis
                                                                    Pelanggaran</label>
                                                                <select name="id_pelanggaran"
                                                                    class="form-control pelanggaran">
                                                                    @foreach ($pelanggaran as $p)
                                                                    <option
                                                                        {{ $item->id_pelanggaran == $p->id_pelanggaran ? 'selected' : ''}}
                                                                        value="{{$p->id_pelanggaran}} ">
                                                                        {{ $p->pelanggaran }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="col-form-label">Bukti
                                                                    Pelanggaran</label>
                                                                <input type="file" name="bukti_pelanggaran"
                                                                    class="form-control mb-2">
                                                                <a
                                                                    href="{{ asset('bukti_pelanggaran') }}/{{ $item->bukti_pelanggaran }}">Lihat
                                                                    Bukti Pelanggaran</a>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <input type="submit" class="btn btn-primary" value="Edit">
                                                        </div>
                                                    </form>
                                                    @else
                                                    <div class="modal-body">
                                                        <p>Pilih Taruna Terlebih Dahulu</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <button {{ auth::user()->role == 'taruna' ? "disabled" : '' }} class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#hapus{{ $item->id_catatan_pelanggaran }}"><i
                                                class="fas fa-trash"></i></button>
                                        <div class="modal fade" id="hapus{{ $item->id_catatan_pelanggaran }}"
                                            role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Hapus Catatan
                                                            Pelanggaran
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Yakin Ingin Menghapus Data Catatan Pelanggaran ini ?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <a href="{{ url('hapuscatatanpelanggaran') }}/{{ $item->id_catatan_pelanggaran }}"
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
            <div class="col-lg-3">
                <div class="">
                    <div class="card h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Taruna</div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                        {{ @$taruna->nama_mahasiswa}}
                                        <br>
                                        {{ @$taruna->nim }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <div class="card h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Total Poin Bulan Ini
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-danger">
                                        {{ @$poin_bulanan }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <div class="card h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Total Poin Semester Ini
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-danger">
                                        {{ @$poin_semester }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                                </div>
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
            url: 'catatanpelanggarantaruna-json',
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

    $(".pelanggaran").select2({
        theme: 'bootstrap4',
        placeholder: "Please Select"
    })
</script>


@endpush