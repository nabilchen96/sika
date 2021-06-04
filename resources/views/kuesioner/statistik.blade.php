@extends('template.index')

@push('kuesioner') active @endpush

@push('style')
<link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
            <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Data Statistik Kuesioner</h2>
        </div>

        <div class="card mb-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                        aria-controls="home" aria-selected="true"><i class="fas fa-chart-bar"></i> Statistik</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                        aria-controls="profile" aria-selected="false"><i class="fas fa-database"></i> Data</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"></h6>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <canvas id="bar-chart-horizontal" height="120px"></canvas>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="card-header">

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" width="100%" id="dataTable"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style="width: 20px">No</th>
                                        <th>Nama Alumni</th>
                                        <th>Jawaban</th>
                                        <th>Tanggal Pengisian</th>
                                        <th style="width: 20px"></th>
                                        <th style="width: 20px"></th>
                                        <th style="width: 20px"></th>
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
<script>
    @if($message = Session::get('sukses'))
        toastr.success("{{ $message }}")
    @elseif($message = Session::get('gagal'))
        toastr.error("{{ $message }}")
    @endif
</script>
{{-- <script src="{{ asset('template/vendor/chart.js/Chart.min.js') }}"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    var ctx = document.getElementById('bar-chart-horizontal').getContext('2d');
  var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: ['<?php echo @implode("','", $label[0]); ?>'],
          datasets: [{
              label: '<?php echo $data[0]->soal; ?>',
              data: [<?php echo implode(",", $jawaban); ?>],
              fill: false,
              backgroundColor: [
                '#4e73df', '#1cc88a', '#36b9cc',
                  '#e74a3b',
                  '#f6c23e',
                  '#858796'
              ],
            //   borderColor: [
            //       'rgba(255, 99, 132, 1)',
            //       'rgba(54, 162, 235, 1)',
            //       'rgba(255, 206, 86, 1)',
            //       'rgba(75, 192, 192, 1)',
            //       'rgba(153, 102, 255, 1)',
            //       'rgba(255, 159, 64, 1)'
            //   ],
              borderWidth: 1
          }]
      },
      options: {
        indexAxis: 'y',
        scales: {
            y: {
                beginAtZero: true
            }
        }
      }
  });
</script>

@endpush