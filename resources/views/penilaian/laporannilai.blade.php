@extends('template.index')

@push('nilai') active @endpush
@push('sub-nilai') show @endpush
@push('laporannilaitaruna') active @endpush

@push('style')
  <link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
  <link href="{{ asset('select2.min.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('select2theme4.css')}}">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
          <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Penilaian / Laporan Nilai Pertaruna</h2>
        </div>

        <div class="card mb-12">
            <div class="card-header">
              <a href="#" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> Export</a>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Pilih Taruna</label>
                    <div class="col-sm-3">
                        <select data-allow-clear="true" name="id_semester" id="carisemester" class="form-control cari">

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
                <hr>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama Taruna</label>
                    <div class="col-sm-3">
                        <input type="text" disabled class="form-control">
                    </div>
                    <label class="col-sm-1 col-form-label">NIT</label>
                    <div class="col-sm-3">
                        <input type="text" disabled class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Program Studi</label>
                    <div class="col-sm-3">
                        <input type="text" disabled class="form-control">
                    </div>
                    <label class="col-sm-1 col-form-label">Kelas</label>
                    <div class="col-sm-3">
                        <input type="text" disabled class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Semester</label>
                    <div class="col-sm-3">
                        <input type="text" disabled class="form-control">
                    </div>
                    <label class="col-sm-1 col-form-label">Asrama</label>
                    <div class="col-sm-3">
                        <input type="text" disabled class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Pengasuh</label>
                    <div class="col-sm-3">
                        <input type="text" disabled class="form-control">
                    </div>
                </div>
                <br><br>

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Pelanggaran</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Penghargaan</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Sakit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#izin" role="tab" aria-controls="contact" aria-selected="false">Perizinan</a>
                      </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered table-striped" width="100%" id="dataTable" cellspacing="0">
                              <thead>
                                <tr>
                                  <th style="width: 20px">No</th>
                                  <th>Tgl Pelanggaran</th>
                                  <th>Pelanggaran</th>
                                  <th>Kategori Pelanggaran</th>
                                  <th>Poin Pelanggaran</th>
                                </tr>
                              </thead>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered table-striped" width="100%" id="dataTable1" cellspacing="0">
                              <thead>
                                <tr>
                                  <th style="width: 20px">No</th>
                                  <th>Tgl Penghargaan</th>
                                  <th>Penghargaan</th>
                                  <th>Bidang Penghargaan</th>
                                  <th>Poin Penghargaan</th>
                                </tr>
                              </thead>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered table-striped" width="100%" id="dataTable2" cellspacing="0">
                              <thead>
                                <tr>
                                  <th style="width: 20px">No</th>
                                  <th>Tgl Sakit</th>
                                  <th>Keterangan Sakit</th>
                                </tr>
                              </thead>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="izin" role="tabpanel" aria-labelledby="contact-tab">
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered table-striped" width="100%" id="dataTable3" cellspacing="0">
                              <thead>
                                <tr>
                                  <th style="width: 20px">No</th>
                                  <th>Tgl Izin</th>
                                  <th>Tanggal Kembali</th>
                                  <th>Tujuan Izin</th>
                                  <th>Keperluan</th>
                                  <th>Keterangan</th>
                                </tr>
                              </thead>
                            </table>
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
<script>
    $(document).ready(function() {
        $('#carisemester').select2({
            theme: 'bootstrap4'
        })

        $('#dataTable1').DataTable();
        $('#dataTable2').DataTable();
        $('#dataTable3').DataTable();
    })
</script>
@endpush