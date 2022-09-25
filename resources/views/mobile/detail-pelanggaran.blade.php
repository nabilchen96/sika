@extends('layouts.mobile')
@section('content')
    <div
        style="height: 300px; background: linear-gradient(360deg, black, transparent), url('{{ asset('law.jpg') }}'); background-position: center; background-size: cover;">
        <a href="{{ url('mobile/pelanggaran') }}">
            <i class="p-3 bi bi-arrow-left-circle text-white" style="font-size: 2rem;"></i>
        </a>
    </div>
    <div class="container">
        <div class="ps-2" style="margin-top: -240px;">
            {{-- <h2 class="text-white">Catatan</h2> --}}
            <h4 class="text-white">Pelanggaran Taruna </h4>
            <h4 class="text-white">{{ $data[0]->nama_mahasiswa }} | {{ $data[0]->nim }}</h4>
        
            <ul class="nav nav-lt-tab mt-3" style="border: 0;" role="tablist">
                <li class="nav-item" style="margin-right: 5px;">
                    <a href="#" class="btn btn-primary"
                        style="border-radius: 20px; padding-left: 25px; padding-right: 25px;">Tambah</a>
                </li>
                <li class="nav-item" style="margin-right: 5px;">
                    <a href="{{ url('mobile/pelanggaran') }}" class="btn btn-primary"
                        style="border-radius: 20px; padding-left: 25px; padding-right: 25px;">Pelanggaran</a>
                </li>
                <li class="nav-item" style="margin-right: 5px;">
                    <a href="{{ url('mobile/penghargaan') }}" class="btn btn-primary position-relative" onclick="getData(0)"
                        id="0" style="border-radius: 25px; padding-left: 25px; padding-right: 25px;">Penghargaan</span>
                    </a>
                </li>
                <li class="nav-item" style="margin-right: 5px;">
                    <a href="{{ url('mobile/pembinaan') }}" class="btn btn-primary" onclick="getData(1)" id="1"
                        style="border-radius: 25px; padding-left: 25px; padding-right: 25px;">Pembinaan</a>
                </li>
            </ul>
        </div>
        <div style="margin-top: -20px; border-radius: 15px;">
            <div>
                <div class="table-responsive">
                    <table class="table table-borderless" style="width: 100%;" id="dataTable" cellspacing="0">
                        <thead>
                            <tr>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (@$data as $k => $item)
                                <tr>
                                    <td>
                                        <div class="card shadow" style="border-radius: 15px;">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <b>Pelanggaran:</b> {{ $item->pelanggaran }} <br><br>
                                                        <b>Poin Pelanggaran: </b> {{ $item->poin_pelanggaran }} <br>
                                                        <b>Tanggal: </b> {{ $item->created_at }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "ordering": false,
                "searching": false,
                language: {
                    paginate: {
                        next: '&#8594;', // or '→'
                        previous: '&#8592;' // or '←' 
                    }
                }
            });
        });
    </script>
@endpush
