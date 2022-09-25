@extends('layouts.mobile')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-center mt-4">
            <h4>SIKA MOBILE</h4>
        </div>
        <form action="#">
            <div class="d-flex justify-content-between p-0">
                <div class="d-flex flex-row align-items-center mt-3 me-2 border rounded bg-white"
                    style="width: 80%; border-radius: 25px !important;">
                    <i class="bi bi-search me-1 ms-4" style="color: #c5c9d2;"></i>
                    <input type="text" name="cari" class="form-control search me-3" style="border: none; height: 46px;"
                        placeholder="Cari Taruna">
                </div>
                <button type="submit" class="btn btn-primary btn-sm mt-3"
                    style="height: 46px; width: 20%; border-radius: 25px;">
                    <i class="bi bi-sliders2" style="font-size: 20px"></i>
                </button>
            </div>
        </form>
        <ul class="nav nav-lt-tab mt-4" style="border: 0;" role="tablist">
            <li class="nav-item" style="margin-right: 5px;">
                <a href="{{ url('mobile/pelanggaran') }}" class="btn btn-primary mb-3"
                    style="border-radius: 20px; padding-left: 25px; padding-right: 25px;">Pelanggaran</a>
            </li>
            {{-- <li class="nav-item" style="margin-right: 5px;">
                <a href="{{ url('mobile/hukuman') }}" class="btn btn-primary mb-3"
                    style="border-radius: 20px; padding-left: 25px; padding-right: 25px;">Hukuman</a>
            </li> --}}
            <li class="nav-item" style="margin-right: 5px;">
                <a href="{{ url('mobile/penghargaan') }}" class="btn btn-primary position-relative" onclick="getData(0)"
                    id="0" style="border-radius: 25px; padding-left: 25px; padding-right: 25px;">Penghargaan</span>
                </a>
            </li>
            <li class="nav-item" style="margin-right: 5px;">
                <a href="{{ url('mobile/berita') }}" class="btn btn-primary" onclick="getData(1)" id="1"
                    style="border-radius: 25px; padding-left: 25px; padding-right: 25px;">Berita</a>
            </li>
            <li class="nav-item" style="margin-right: 5px;">
                <a href="{{ url('mobile/taruna') }}" class="btn btn-primary" onclick="getData(1)" id="1"
                    style="border-radius: 25px; padding-left: 25px; padding-right: 25px;"> Taruna</a>
            </li>
        </ul>
        <div class="mb-3">
            <h3 style="margin-bottom: 0;">Kejasmanian</h3>
            <a href="#">
                <span style="font-size: 12px;">Lihat Penilaian <i class="bi bi-arrow-right"></i></span>
            </a>
        </div>

        <ul class="nav nav-lt-tab" style="border: 0;" role="tablist">
            <li class="nav-item" style="margin-right: 5px;">
                <a href="{{ url('mobile/lari') }}">
                    <div class="card"
                        style="
                    background-image: linear-gradient(360deg, black, transparent), url('{{ asset('running.jpg') }}'); 
                    background-position: center;
                    background-size: cover;
                    width: 180px; 
                    min-height: 240px;
                    border-radius: 15px; 
                    border: none;">
                        <div class="card-body" style="white-space: normal;">
                            <div style="position: absolute; bottom: 10px;">
                                <h5 class="card-title">Test Samapta</h5>
                                <h6 class="text-white">Lari 12 Menit</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
            <li class="nav-item" style="margin-right: 5px;">
                <a href="{{ url('mobile/pushup') }}">
                    <div class="card"
                        style="
                    background-image: linear-gradient(360deg, black, transparent), url('{{ asset('pushup.jpg') }}'); 
                    background-position: center;
                    background-size: cover;
                    width: 180px; 
                    min-height: 240px;
                    border-radius: 15px; 
                    border: none;">
                        <div class="card-body" style="white-space: normal;">
                            <div style="position: absolute; bottom: 10px;">
                                <h5 class="card-title">Test Samapta</h5>
                                <h6 class="text-white">Push Up 12 Menit</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
            <li class="nav-item" style="margin-right: 5px;">
                <a href="{{ url('mobile/situp') }}">
                    <div class="card"
                        style="
                    background-image: linear-gradient(360deg, black, transparent), url('{{ asset('situp.jpg') }}'); 
                    background-position: center;
                    background-size: cover;
                    width: 180px; 
                    min-height: 240px;
                    border-radius: 15px; 
                    border: none;">
                        <div class="card-body" style="white-space: normal;">
                            <div style="position: absolute; bottom: 10px;">
                                <h5 class="card-title">Test Samapta</h5>
                                <h6 class="text-white">Sit Up 12 Menit</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
            <li class="nav-item" style="margin-right: 5px;">
                <a href="{{ url('mobile/shuttlerun') }}">
                    <div class="card"
                        style="
                    background-image: linear-gradient(360deg, black, transparent), url('{{ asset('running.jpg') }}'); 
                    background-position: center;
                    background-size: cover;
                    width: 180px; 
                    min-height: 240px;
                    border-radius: 15px; 
                    border: none;">
                        <div class="card-body" style="white-space: normal;">
                            <div style="position: absolute; bottom: 10px;">
                                <h5 class="card-title">Test Samapta</h5>
                                <h6 class="text-white">Shuttle Run 3 Kali</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
            <li class="nav-item" style="margin-right: 5px;">
                <a href="{{ url('mobile/bbi') }}">
                    <div class="card"
                        style="
                    background-image: linear-gradient(360deg, black, transparent), url('{{ asset('bbi.jpg') }}'); 
                    background-position: center;
                    background-size: cover;
                    width: 180px; 
                    min-height: 240px;
                    border-radius: 15px; 
                    border: none;">
                        <div class="card-body" style="white-space: normal;">
                            <div style="position: absolute; bottom: 10px;">
                                <h5 class="card-title">BBI</h5>
                                <h6 class="text-white">Berat Badan Ideal</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
        </ul>

        <div class="mb-3 mt-4">
            <h3 style="margin-bottom: 0;">Catatan Lainnya</h3>
            <a href="#">
                <span style="font-size: 12px;">Lihat Catatan <i class="bi bi-arrow-right"></i></span>
            </a>
        </div>
        <ul class="nav nav-lt-tab" style="border: 0;" role="tablist">
            <li class="nav-item" style="margin-right: 5px;">
                <a href="{{ url('mobile/pelanggaran') }}">
                    <div class="card"
                        style="
                    background-image: linear-gradient(360deg, black, transparent), url('{{ asset('law.jpg') }}'); 
                    background-position: center;
                    background-size: cover;
                    width: 180px; 
                    min-height: 240px;
                    border-radius: 15px; 
                    border: none;">
                        <div class="card-body" style="white-space: normal;">
                            <div style="position: absolute; bottom: 10px;">
                                <h5 class="card-title">Catatan</h5>
                                <h6 class="text-white">Pelanggaran</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
            <li class="nav-item" style="margin-right: 5px;">
                <a href="{{ url('mobile/penghargaan') }}">
                    <div class="card"
                        style="
                    background-image: linear-gradient(360deg, black, transparent), url('{{ asset('penghargaan.jpg') }}'); 
                    background-position: center;
                    background-size: cover;
                    width: 180px; 
                    min-height: 240px;
                    border-radius: 15px; 
                    border: none;">
                        <div class="card-body" style="white-space: normal;">
                            <div style="position: absolute; bottom: 10px;">
                                <h5 class="card-title">Catatan</h5>
                                <h6 class="text-white">Penghargaan</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
            <li class="nav-item" style="margin-right: 5px;">
                <a href="{{ url('mobile/pembinaan') }}">
                    <div class="card"
                        style="
                    background-image: linear-gradient(360deg, black, transparent), url('{{ asset('pembinaan.jpg') }}'); 
                    background-position: center;
                    background-size: cover;
                    width: 180px; 
                    min-height: 240px;
                    border-radius: 15px; 
                    border: none;">
                        <div class="card-body" style="white-space: normal;">
                            <div style="position: absolute; bottom: 10px;">
                                <h5 class="card-title">Catatan</h5>
                                <h6 class="text-white">Pembinaan</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
@endsection
