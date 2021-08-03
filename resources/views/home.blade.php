@extends('template.index')

@section('content')

@if (@$_GET['aplikasi'] == null or @$_GET['aplikasi'] == 'ketarunaan')
<div class="row">

  <div class="col-lg-12">
    <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
      <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Dashboard Ketarunaan</h2>
    </div>
  </div>

  <!-- Earnings (Monthly) Card Example -->
  @if (auth::user()->role != 'taruna')
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Taruna</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $taruna }}</div>
          </div>
          <div class="col-auto">
            <i class="fas fa-user fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Jumlah Pengasuh</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pengasuh }}</div>
          </div>
          <div class="col-auto">
            <i class="fas fa-user fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif

  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Semester Aktif</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $semester->nama_semester }}</div>
          </div>
          <div class="col-auto">
            <i class="fas fa-calendar fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Pending Requests Card Example -->
  {{-- <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Hukuman Belum Selesai</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $hukuman }}</div>
          </div>
          <div class="col-auto">
            <i class="fas fa-tasks fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div> --}}
</div>

{{-- <div class="row">
  <div class="col-xl-6 col-lg-6">
    <div class="card shadow mb-4">
      <!-- Card Header - Dropdown -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Taruna Paling Teladan Semester Ini</h6>
      </div>
      <!-- Card Body -->
      <div class="card-body">
        <table class="table table-striped text-center">
          <tr>
            <td>No</td>
            <td>Nama</td>
            <td>NIT</td>
            <td>Penghargaan</td>
            <td>Pelanggaran</td>
          </tr>
          <tr>
            <td>
              <div class="alert alert-primary p-2 m-0" role="alert">
                1
              </div>
            </td>
            <td>
              <div class="alert alert-primary p-2 m-0" role="alert">
                Jhon Due
              </div>
            </td>
            <td>
              <div class="alert alert-primary p-2 m-0" role="alert">
                021160128
              </div>
            </td>
            <td>
              <div class="alert alert-primary p-2 m-0" role="alert">
                100 Poin
              </div>
            </td>
            <td>
              <div class="alert alert-primary p-2 m-0" role="alert">
                0 Poin
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <div class="alert alert-success p-2 m-0" role="alert">
                2
              </div>
            </td>
            <td>
              <div class="alert alert-success p-2 m-0" role="alert">
                Jane Due
              </div>
            </td>
            <td>
              <div class="alert alert-success p-2 m-0" role="alert">
                021160128
              </div>
            </td>
            <td>
              <div class="alert alert-success p-2 m-0" role="alert">
                75 Poin
              </div>
            </td>
            <td>
              <div class="alert alert-success p-2 m-0" role="alert">
                0 Poin
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <div class="alert alert-danger p-2 m-0" role="alert">
                3
              </div>
            </td>
            <td>
              <div class="alert alert-danger p-2 m-0" role="alert">
                Jane Due
              </div>
            </td>
            <td>
              <div class="alert alert-danger p-2 m-0" role="alert">
                021160128
              </div>
            </td>
            <td>
              <div class="alert alert-danger p-2 m-0" role="alert">
                75 Poin
              </div>
            </td>
            <td>
              <div class="alert alert-danger p-2 m-0" role="alert">
                0 Poin
              </div>
            </td>
          </tr>
          <tr>
            <td>4</td>
            <td>Bill Gates</td>
            <td>02769803</td>
            <td>50 Poin</td>
            <td>5 Poin</td>
          </tr>
          <tr>
            <td>5</td>
            <td>Melinda Gates</td>
            <td>098969803</td>
            <td>45 Poin</td>
            <td>5 Poin</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div> --}}
@else
<div class="row">

  <div class="col-lg-12">
    <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
      <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Dashboard Alumni</h2>
    </div>
  </div>

  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Alumni</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
          </div>
          <div class="col-auto">
            <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Jumlah Kuesioner</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
          </div>
          <div class="col-auto">
            <i class="fas fa-question fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Alumni Bekerja</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
          </div>
          <div class="col-auto">
            <i class="fas fa-briefcase fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Pending Requests Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Lowongan Tersedia</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
          </div>
          <div class="col-auto">
            <i class="fas fa-briefcase fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endif
@endsection