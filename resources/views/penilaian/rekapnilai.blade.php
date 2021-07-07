@extends('template.index')

@push('nilai') active @endpush
@push('sub-nilai') show @endpush
@push('rekapnilai') active @endpush

@push('style')
  <link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
  <link href="{{ asset('select2.min.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('select2theme4.css')}}">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
          <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Penilaian / Rekap Nilai Taruna</h2>
        </div>

        <div class="card mb-12">
            <div class="card-header">
              <a href="#" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> Export</a>
            </div>
            <div class="card-body">
              <form action="{{ url('rekapnilai') }}" method="GET">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Pilih Semester</label>
                  <div class="col-sm-2">
                      <select data-allow-clear="true" name="id_semester" id="carisemester" class="form-control cari" required>
                        <option value="">-----</option>
                        @foreach ($semester as $item)
                          <option value="{{ $item->id_semester }}">{{ $item->nama_semester }}</option>
                        @endforeach
                      </select>
                  </div>
              </div>
              <div class="form-group row">
                  <label class="col-sm-2 col-form-label"></label>
                  <div class="col-sm-2">
                      <button onclick="getdata()" class="btn btn-sm btn-success">
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
                          <th>NIT</th>
                          <th>Nama Taruna</th>
                          <th>Poin Penghargaan</th>
                          <th>Poin Pelanggaran</th>
                          <th>Nilai Kondite</th>
                          <th>Keterangan</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($data as $k => $d)
                            <tr>
                              <td>{{ $k+1 }}</td>
                              <td>{{ $d->nim }}</td>
                              <td>{{ $d->nama_mahasiswa }}</td>
                              <td>{{ $d->poin_penghargaan != null ? $d->poin_penghargaan : 0 }}</td>
                              <td>{{ $d->poin_pelanggaran != null ? $d->poin_pelanggaran : 0 }}</td>
                              <td></td>
                              <td></td>
                            </tr>
                        @endforeach
                      </tbody>
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
  <script src="{{ asset('select2.min.js') }}"></script>
  <script>
    @if($message = Session::get('sukses'))
        toastr.success("{{ $message }}")
    @elseif($message = Session::get('gagal'))
        toastr.error("{{ $message }}")
    @endif
  </script>
<script>
    $(document).ready(function() {
        $('#carisemester').select2({
            theme: 'bootstrap4'
        })
    })
</script>
@endpush