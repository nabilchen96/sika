@extends('layouts.mobile')
@section('content')
    <div
        style="height: 300px; background: linear-gradient(360deg, black, transparent), url('{{ asset('pushup.jpg') }}'); background-position: center; background-size: cover;">

    </div>
    <div class="container">
        <div class="ps-2" style="margin-top: -270px;">
            <h2 class="text-white">Test Samapta</h2>
            <h4 class="text-white">Push Up 1 Menit</h4>
            <form action="{{ url('mobile/pushup') }}">
                <div class="d-flex justify-content-between p-0">
                    <div class="d-flex flex-row align-items-center me-2 mt-3 border rounded bg-white"
                        style="width: 80%; border-radius: 25px !important;">
                        <i class="bi bi-search me-1 ms-4" style="color: #c5c9d2;"></i>
                        <input type="text" name="cari" class="form-control search me-3"
                            style="border: none; height: 46px;" value="{{ request('cari') }}" placeholder="Cari Taruna">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm me-3 mt-3"
                        style="height: 46px; width: 20%; border-radius: 25px;">
                        <i class="bi bi-sliders2" style="font-size: 20px"></i>
                    </button>
                </div>
            </form>

            <ul class="nav nav-lt-tab mt-3" style="border: 0;" role="tablist">
                <li class="nav-item" style="margin-right: 5px;">
                    <a href="{{ url('mobile/pelanggaran') }}" class="btn btn-primary"
                        style="border-radius: 20px; padding-left: 25px; padding-right: 25px;">Add or Edit</a>
                </li>
                <li class="nav-item" style="margin-right: 5px;">
                    <a href="{{ url('mobile/lari') }}" class="btn btn-primary"
                        style="border-radius: 20px; padding-left: 25px; padding-right: 25px;">Lari</a>
                </li>
                <li class="nav-item" style="margin-right: 5px;">
                    <a href="{{ url('mobile/pushup') }}" class="btn btn-primary position-relative" onclick="getData(0)"
                        id="0" style="border-radius: 25px; padding-left: 25px; padding-right: 25px;">Push Up</span>
                    </a>
                </li>
                <li class="nav-item" style="margin-right: 5px;">
                    <a href="{{ url('mobile/situp') }}" class="btn btn-primary" onclick="getData(1)" id="1"
                        style="border-radius: 25px; padding-left: 25px; padding-right: 25px;">Sit Up</a>
                </li>
                <li class="nav-item" style="margin-right: 5px;">
                    <a href="{{ url('mobile/shuttlerun') }}" class="btn btn-primary" onclick="getData(1)" id="1"
                        style="border-radius: 25px; padding-left: 25px; padding-right: 25px;"> Shuttle Run</a>
                </li>
                <li class="nav-item" style="margin-right: 5px;">
                    <a href="{{ url('mobile/bbi') }}" class="btn btn-primary" onclick="getData(1)" id="1"
                        style="border-radius: 25px; padding-left: 25px; padding-right: 25px;"> BBI</a>
                </li>
            </ul>
        </div>
        <div class="" style="margin-top: -20px; border-radius: 15px;">
            <div class="">
                {{-- <button class="btn btn-primary btn-sm" style="border-radius: 15px;">Tambah</button> --}}

                <div class="table-responsive">
                    <table class="table table-borderless" style="width: 100%;" id="dataTable" cellspacing="0">
                        <thead>
                            <tr>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $k => $item)
                                <tr>
                                    <td>
                                        <div class="card shadow" style="border-radius: 15px;">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="div"
                                                            style="border-radius: 15px; 
                                                            width: 100%; 
                                                            background: #6c63ff;
                                                            aspect-ratio: 1/1;">
                                                            @if ($item->jenis_kelamin == 'L')
                                                                <img style="object-fit: cover; width: 100%;"
                                                                    src="{{ asset('male.svg') }}" alt="">
                                                            @else
                                                                <img style="object-fit: cover; width: 100%;"
                                                                    src="{{ asset('female.svg') }}" alt="">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-8">
                                                        {{ $item->nama_mahasiswa }}<br>
                                                        <span class="badge bg-primary">{{ $item->nim }}</span> <br>
                                                        <span class="badge bg-primary">
                                                            @if ($item->nama_program_studi == 'Teknologi Rekayasa Bandar Udara')
                                                                TRBU
                                                            @elseif($item->nama_program_studi == 'Manajemen Bandar Udara')
                                                                MBU
                                                            @elseif($item->nama_program_studi == 'Penyelamatan dan Pemadam Kebakaran Penerbangan')
                                                                PPKP
                                                            @endif
                                                        </span>
                                                        <div class="row mt-3">
                                                            <div class="col-6">
                                                                Jumlah <br>
                                                                <h4>{{ $item->jumlah_push_up }}</h4>
                                                            </div>
                                                            <div class="col-6">
                                                                Nilai <br>
                                                                <h4>{{ $item->nilai_push_up }}</h4>
                                                            </div>
                                                        </div>
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
