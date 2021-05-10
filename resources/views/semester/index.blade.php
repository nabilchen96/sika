@extends('template.index')

@push('master') active @endpush
@push('sub-master') show @endpush
@push('semester') active @endpush

@push('style')
  <link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<?php //dd(@$data); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
        <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Master Data / Data Semester</h2>
        </div>

        <div class="card mb-12">
            <div class="card-header">
              <a href="{{ url('update-semester-server') }}" class="btn btn-sm btn-success"><i class="fas fa-cloud-download-alt"></i> Sinkron</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%" id="dataTable" cellspacing="0">
                      <thead>
                        <tr>
                          <th style="width: 20px">No</th>
                          <th>Periode Semester</th>
                          <th>Tanggal Mulai</th>
                          <th>Tanggal Selesai</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      @foreach ($semester as $k => $item)
                          <tr>
                              <td>{{ $k+1 }}</td>
                              <td>{{ $item->nama_semester }}</td>
                              <td>{{ $item->tanggal_mulai }}</td>
                              <td>{{ $item->tanggal_selesai }}</td>
                              <td>
                                  {{ $item->is_semester_aktif == "1" ? 'Aktif' : 'Tidak Aktif'}}
                              </td>
                          </tr>
                      @endforeach
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
    @if($message = Session::get('sukses'))
        toastr.success("{{ $message }}")
    @elseif($message = Session::get('gagal'))
        toastr.error("{{ $message }}")
    @endif
  </script>
@endpush