@extends('template.index')

@push('catatan') active @endpush
@push('sub-catatan') show @endpush
@push('catatanhukuman') active @endpush

@push('style')
<link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('select2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('select2theme4.css')}}">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
            <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Catatan / Data Catatan Hukuman
            </h2>
        </div>

        <div class="card mb-12">
            <div class="card-header">
                <a href="{{ url('catatanhukumanexport') }}" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> Export</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%" id="dataTable" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 20px">No</th>
                                <th>Penerima Hukuman</th>
                                <th>Tanggal Hukuman</th>
                                <th>Keterangan Hukuman</th>
                                <th>Status</th>
                                @if (auth::user()->role != 'taruna')
                                <th width="10"></th>
                                <th width="10"></th>
                                @endif
                            </tr>
                        </thead>
                        @foreach ($data as $k => $item)
                        <tr>
                            <td>{{ $k+1 }}</td>
                            <td>{{ $item->nim }}<br>{{ $item->nama_mahasiswa}}</td>
                            <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                            <td>{{ $item->keterangan }}</td>
                            <td>
                                @if ($item->is_dikerjakan == 0)
                                    <span class="badge badge-danger">Belum Dikerjakan</span>
                                @else
                                    <span class="badge badge-success">Sudah Dikerjakan</span>
                                @endif
                            </td>
                            @if (auth::user()->role != 'taruna')
                            <td>
                                @if ($item->is_dikerjakan == 0)
                                <a href="{{ url('status-catatanhukuman') }}/{{ $item->id_catatan_hukuman}}"
                                    class="btn btn-sm btn-success btn-sm"><i class="fas fa-check"></i></a>
                                @else
                                <button disabled class="btn btn-sm btn-success btn-sm"><i class="fas fa-check"></i></button>
                                @endif
                            </td>
                            <td>
                                @if ($item->is_dikerjakan == 0)
                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                    data-target="#exampleModal" data-id="{{ $item->id_catatan_hukuman }}"
                                    data-hukuman="{{ $item->keterangan }}"><i class="fas fa-edit"></i></button>
                                @else
                                    <button type="button" class="btn btn-success btn-sm" disabled><i class="fas fa-edit"></i></button>
                                @endif
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </table>

                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Hukuman</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="POST" action="{{ url('update-hukuman') }}">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" id="id_catatan_hukuman" name="id_catatan_hukuman">
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Hukuman</label>
                                            <textarea name="keterangan" rows="3" class="form-control"
                                                id="keterangan"></textarea>
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

    $("#pelanggaran").select2({
        theme: 'bootstrap4',
        placeholder: "Please Select"
    })
</script>

<script>
    $('#exampleModal').on('show.bs.modal', function (event) {
        var button      = $(event.relatedTarget)
        var id          = button.data('id')
        var keterangan  = button.data('hukuman')
        var modal = $(this)
        modal.find('.modal-body #keterangan').val(keterangan)
        modal.find('.modal-body #id_catatan_hukuman').val(id)
    })
</script>
@endpush