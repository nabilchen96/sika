@extends('template.index')

@push('catatan') active @endpush
@push('sub-catatan') show @endpush
@push('catatanpenghargaan') active @endpush

@push('style')
<link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('select2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('select2theme4.css')}}">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
            <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Master Data / Data Catatan Penghargaan
            </h2>
        </div>

        <div class="card mb-12">
            <div class="card-header">
                @if (auth::user()->role != 'taruna')
                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambah"><i
                    class="fas fa-plus"></i> Tambah</a>
                    <a href="{{ url('penghargaantarunaexport') }}" class="btn btn-sm btn-success"><i
                        class="fas fa-file-excel"></i> Export</a>
                @endif
                <div class="modal fade" id="tambah" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Catatan Pelanggaran</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="formtambah" action="{{ url('tambah-catatanpenghargaan') }}" method="post">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="col-form-label">Nama Taruna</label>
                                        <select data-allow-clear="true" name="id_mahasiswa" class="form-control cari">

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">SK Penghargaan</label>
                                        <input type="text" class="form-control" name="sk_penghargaan" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Tanggal Penghargaan</label>
                                        <input type="date" class="form-control" name="tgl_penghargaan" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Penghargaan</label>
                                        <select name="id_penghargaan" class="id_penghargaan" data-allow-clear="true">
                                            @foreach ($penghargaan as $item)
                                            <option value="{{ $item->id_penghargaan }}">{{ $item->penghargaan }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Keterangan</label>
                                        <textarea name="keterangan" class="form-control" id="keterangan" cols="30" rows="5"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Template Penghargaan</label>
                                        <select class="form-control" id="form-control" name="template_penghargaan">
                                            <?php
                                                
                                                $template = DB::table('templates')->where('kategori', '3')->get();

                                            ?>
                                            <option value="">--Pilih Template Penghargaan--</option>
                                            @foreach ($template as $item)
                                                <option value="{{ $item->id_template }}">{{ $item->judul_template }}</option>
                                            @endforeach
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
                <form action="{{ url('catatanpenghargaan') }}" method="GET">
                    {{-- @csrf --}}
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Semester</label>
                        <div class="col-sm-3">
                            <?php
                                if (Auth::user()->role == 'taruna'){
                                    $semester = DB::table('semesters')
                                        ->orderBy('id_semester', 'DESC')
                                        ->where('is_semester_aktif', 1)
                                        ->take('10')->get();
                                }else{
                                    $semester = DB::table('semesters')->orderBy('id_semester', 'DESC')->take('10')->get();
                                }
                            ?>
                            <select name="id_semester" class="form-control" required>
                                <option value="">Pilih Semester</option>
                                @foreach ($semester as $item)
                                <option {{ @$_GET['id_semester'] == $item->id_semester ? 'selected' : '' }}
                                    value="{{ $item->id_semester }}">{{ $item->nama_semester }}</option>
                                @endforeach
                            </select>
                            <select name="id_prodi" id="id_prodi" class="mt-2 form-control" required>
                                <option value="">Pilih Prodi</option>
                                <option {{ @$_GET['id_prodi'] == 'c0d0034a-70ec-436d-b88f-b85182ba6fe1' ? 'selected' : '' }} value="c0d0034a-70ec-436d-b88f-b85182ba6fe1">TRBU</option>
                                <option {{ @$_GET['id_prodi'] == 'c40d9f90-2a98-4b08-9947-a02e660ef7ff' ? 'selected' : '' }} value="c40d9f90-2a98-4b08-9947-a02e660ef7ff">MBU</option>
                                <option {{ @$_GET['id_prodi'] == 'ed1f301a-f97d-4186-a8ea-647122b1f68e' ? 'selected' : '' }} value="ed1f301a-f97d-4186-a8ea-647122b1f68e">PPKP</option>
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
                    <br>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%" id="dataTable" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 20px">No</th>
                                <th>Penerima Penghargaan</th>
                                <th>Tanggal Penghargaan</th>
                                <th>Penghargaan</th>
                                <th>Bidang Penghargaan</th>
                                <th>Poin Penghargaan</th>
                                @if (auth::user()->role != 'taruna')
                                <th width="10"></th>
                                <th width="10"></th>
                                <th width="10"></th>
                                @endif
                            </tr>
                        </thead>
                        @foreach ($data as $key => $item)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $item->nim }}<br>{{ $item->nama_mahasiswa}}</td>
                            <td>{{ date('d-m-Y', strtotime($item->tgl_penghargaan)) }}</td>
                            <td>{{ $item->penghargaan }}</td>
                            <td>{{ $item->bidang_penghargaan }}</td>
                            <td>{{ $item->poin_penghargaan }}</td>
                            @if (auth::user()->role != 'taruna')
                            <td>
                                <a href="{{ url('sertifikat-penghargaan') }}/{{ $item->id_catatan_penghargaan }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-file-pdf text-white"></i>
                                </a>
                            </td>
                            <td>
                                <a href="#" data-toggle="modal" data-target="#edit" data-array="{{ $data }}"
                                    data-i="{{ $key }}" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>
                            </td>
                            <td>
                                <a href="#" data-toggle="modal" data-target="#hapus{{ $item->id_catatan_penghargaan }}"
                                    class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                                <div class="modal fade" id="hapus{{ $item->id_catatan_penghargaan }}" role="dialog"
                                    aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Hapus Catatan Penghargaan
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="GET"
                                                action="{{ url('hapus-catatanpenghargaan') }}/{{ $item->id_catatan_penghargaan }}">
                                                @csrf
                                                <div class="modal-body">
                                                    <p>Yakin Ingin Menghapus Data Catatan Penghargaan ini ?</p>
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
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Penghargaan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="POST" action="{{ url('edit-catatanpenghargaan') }}">
                                    @csrf
                                    <input type="hidden" name="id_catatan_penghargaan" id="id_catatan_penghargaan">
                                    <input type="hidden" name="id_mahasiswa" id="id_mahasiswa">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="col-form-label">Nama Mahasiswa</label>
                                            <input type="text" class="form-control" id="nama_mahasiswa" required
                                                disabled>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Tanggal Penghargaan</label>
                                            <input type="date" class="form-control" name="tgl_penghargaan"
                                                id="tgl_penghargaan" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">SK Penghargaan</label>
                                            <input type="text" class="form-control" name="sk_penghargaan"
                                                id="sk_penghargaan" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Penghargaan</label>
                                            <select class="form-control" name="id_penghargaan" id="id_penghargaan"
                                                required>
                                                @foreach ($penghargaan as $item)
                                                    <option value="{{ $item->id_penghargaan }}">{{ $item->penghargaan }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Keterangan</label>
                                            <textarea name="keterangan" class="form-control" id="keterangan" cols="30" rows="5"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Template Penghargaan</label>
                                            <select class="form-control" id="template_penghargaan" name="template_penghargaan">
                                                <?php
                                                    
                                                    $template = DB::table('templates')->where('kategori', '3')->get();
    
                                                ?>
                                                <option value="">--Pilih Template Penghargaan--</option>
                                                @foreach ($template as $item)
                                                    <option value="{{ $item->id_template }}">{{ $item->judul_template }}</option>
                                                @endforeach
                                            </select>
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
        modal.find('#tgl_penghargaan').val(array[i].tgl_penghargaan)
        modal.find('#sk_penghargaan').val(array[i].sk_penghargaan)
        modal.find('#id_penghargaan').val(array[i].id_penghargaan).trigger('change')
        modal.find('#template_penghargaan').val(array[i].template_penghargaan).trigger('change')
        modal.find('#id_catatan_penghargaan').val(array[i].id_catatan_penghargaan).trigger('change')
        modal.find('#keterangan').val(array[i].keterangan).trigger('change')
    })
</script>

@endpush