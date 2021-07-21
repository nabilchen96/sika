@extends('template.index')

@push('master') active @endpush
@push('sub-master') show @endpush
@push('templatesurat') active @endpush


@push('style')
<link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
            <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Master Data / Data Template Surat</h2>
        </div>
        <div class="card mb-12">
            <div class="card-header">
                <a href="#" data-toggle="modal" data-target=".modal" data-array="" class="btn btn-sm btn-primary"><i
                        class="fas fa-plus"></i> Tambah</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%" id="dataTable" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 20px">No</th>
                                <th>Judul Template</th>
                                <th>File</th>
                                <th>Keterangan</th>
                                <th>Kategori</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        @foreach ($data as $k => $item)
                        <tr>
                            <td>{{ $k+1 }}</td>
                            <td>{{ $item->judul_template }}</td>
                            <td>
                                <a target="_blank" href="{{ asset('templatesurat') }}/{{ $item->template }}" class="badge badge-success">Lihat File</a>
                            </td>
                            <td>{{ $item->keterangan }}</td>
                            <td>
                                @if ($item->kategori == 1)
                                    Surat Izin
                                @elseif($item->kategori == 2)
                                    Surat Keterangan
                                @elseif ($item->kategori == 3)
                                    Template Penilaian
                                @endif
                            </td>
                            <td><a href="#" data-target=".modal" data-toggle="modal" data-array="{{ $data[$k] }}" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a></td>
                            <td><a href="{{ url('hapustemasurat') }}/{{ $item->id_template }}" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Data Template</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="formtemplate" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_template" id="id_template">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label">Judul Template</label>
                        <input type="text" name="judul_template" class="form-control" id="judul_template">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Kategori</label>
                        <select name="kategori" class="form-control" id="kategori">
                            <option value="">--Pilih Kategori--</option>
                            <option value="1">Surat Izin</option>
                            <option value="2">Surat Keterangan Kuliah</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" cols="30" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Template  <b class="text-danger">*Input file berekstensi .doc</b></label>
                        <input type="file" name="template" class="form-control" id="template">
                        <a href="" id="surat" class="badge badge-success">Lihat File</a>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
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

    $('.modal').on('show.bs.modal', function (event) {
    var button  = $(event.relatedTarget)
    var data    = button.data('array');
    var modal   = $(this)

    if(data === ''){
        $('#formtemplate').attr('action', "{{ url('simpantemplatesurat') }}").trigger('reset')
    }else{
        $('#formtemplate').attr('action', "{{ url('edittemplatesurat') }}")

        modal.find('#id_template').val(data.id_template)
        modal.find('#judul_template').val(data.judul_template)
        modal.find('#kategori').val(data.kategori)
        modal.find('#keterangan').val(data.keterangan)
        var surat = data.template

        $('#surat').attr('href', '{{ url('templatesurat') }}/'+surat)
    }

    })

</script>
@endpush