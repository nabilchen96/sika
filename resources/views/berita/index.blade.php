@extends('template.index')

@push('style')
<link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
            <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Pengumuman & Berita
            </h2>
        </div>

        <div class="card mb-12">
            <div class="card-header">
                <a href="{{ url('tambahberita') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Tambah</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%" id="dataTable" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Judul Berita</th>
                                <th>Kategori</th>
                                <th>Tgl Publish</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $k => $item)
                                <tr>
                                    <td>{{ $k+1 }}</td>
                                    <td><img src="{{ asset('gambar_berita') }}/{{ $item->gambar_utama }}" width="50px"></td>
                                    <td>{{ $item->judul_berita }}</td>
                                    <td>
                                        @if ($item->kategori == "1")
                                            pendidikan
                                        @elseif ($item->kategori == '2')
                                            Lowongan Kerja
                                        @elseif ($item->kategori == '3')
                                            Layanan
                                        @else
                                            Lainnya
                                        @endif
                                    </td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>
                                        <a href="{{ url('editberita') }}/{{ $item->id_berita }}" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>
                                    </td>
                                    <td>
                                        <a href="#" data-toggle="modal" data-target=".modalhapus" data-idberita="{{ $item->id_berita }}" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
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

<div class="modal fade modalhapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Data Pengajuan Surat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Yakin Ingin Menghapus Berita ini ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a id="url" href="" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
  </div>

@endsection

@push('scripts')
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

    $('.modalhapus').on('show.bs.modal', function (event) {
      var button  = $(event.relatedTarget)
      var data    = button.data('idberita');
      var modal   = $(this)

      $('#url').attr('href', "{{ url('hapusberita') }}/"+data)
    })
  </script>

@endpush