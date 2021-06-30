@extends('template.index')

@push('pengajuansurat') active @endpush

@push('style')
  <link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
        <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Pengajuan Surat</h2>
        </div>

        <div class="card mb-12">
            <div class="card-header">
              @if (auth::user()->role == 'taruna')
                <a href="{{ url('tambahpengajuansurat') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Tambah</a>
              @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%" id="dataTable" cellspacing="0">
                      <thead>
                        <tr>
                          <th style="width: 20px">No</th>
                          <th>Nama Taruna</th>
                          <th>Jenis Pengajuan</th>
                          <th>Tanggal Pengajuan</th>
                          <th>Keterangan</th>
                          <th style="width: 100px">Status Pengajuan</th>
                          <th>Download Surat</th>
                          <th width="10"></th>
                          <th width="10"></th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach ($data as $k => $item)
                              <tr>
                                  <td>{{ $k+1 }}</td>
                                  <td>{{ $item->nama_mahasiswa }}</td>
                                  <td>{{ $item->jenis_pengajuan }}</td>
                                  <td>{{ $item->created_at }}</td>
                                  <td>
                                    @if ($item->jenis_pengajuan == 'surat izin')
                                      <?php $jawaban = unserialize($item->keterangan); ?>
                                      Tujuan: {{ $jawaban[0] }} <br>
                                      Keperluan: {{ $jawaban[1] }}<br>
                                      Tanggal Keluar: {{ $jawaban[2] }}<br>
                                      Tanggal Kembali: {{ $jawaban[3] }}<br>
                                      Keterangan: {{ $jawaban[4] }}
                                    @else
                                      {{ $item->keterangan }}
                                    @endif
                                  </td>
                                  <td style="width: 100px">
                                    @if ($item->status_pengajuan == '1')
                                      <span class="badge badge-success text-left">Pengajuan diterima</span>
                                    @elseif ($item->status_pengajuan == '0')
                                      <span class="badge badge-warning">Pengajuan diproses</span>
                                    @elseif ($item->status_pengajuan == '2')
                                      <span class="badge badge-danger">Pengajuan Ditolak</span>
                                      {{ 'Alasan: '.$item->alasan_tolak }}
                                    @endif
                                  </td>
                                  <td>
                                    @if($item->surat == null) 
                                      <span class="badge badge-danger">Belum ada file</span> 
                                    @else 
                                      <a href="{{ asset('surat') }}/{{ $item->surat }}" target="_blank" class="badge badge-success">Download Surat</a> 
                                    @endif
                                  </td>
                                  <td>
                                    <a href="{{ url('editpengajuansurat') }}/{{ $item->id_pengajuan_surat }}" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>
                                  </td>
                                  <td>
                                    <a href="#" data-toggle="modal" data-target=".modalhapus" data-idpengajuan="{{ $item->id_pengajuan_surat }}" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
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
              <p>Yakin Ingin Menghapus Data Pengajuan Surat ini ?</p>
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
    @endif

    $('.modalhapus').on('show.bs.modal', function (event) {
      var button  = $(event.relatedTarget)
      var data    = button.data('idpengajuan');
      var modal   = $(this)

      $('#url').attr('href', "{{ url('hapuspengajuansurat') }}/"+data)
    })
  </script>
@endpush