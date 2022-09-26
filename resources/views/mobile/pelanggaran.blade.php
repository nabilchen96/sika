@extends('layouts.mobile')
@section('content')
    <div
        style="height: 300px; background: linear-gradient(360deg, black, transparent), url('{{ asset('law.jpg') }}'); background-position: center; background-size: cover;">

    </div>
    <div class="container">
        <div class="ps-2" style="margin-top: -270px;">
            <h2 class="text-white">Catatan</h2>
            <h4 class="text-white">Pelanggaran Taruna</h4>
            <form action="{{ url('mobile/pelanggaran') }}">
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
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modal" class="btn btn-primary"
                        style="border-radius: 20px; padding-left: 25px; padding-right: 25px;">Tambah</a>
                </li>
                <li class="nav-item" style="margin-right: 5px;">
                    <a href="{{ url('mobile/pelanggaran') }}" class="btn btn-primary"
                        style="border-radius: 20px; padding-left: 25px; padding-right: 25px;">Pelanggaran</a>
                </li>
                <li class="nav-item" style="margin-right: 5px;">
                    <a href="{{ url('mobile/penghargaan') }}" class="btn btn-primary position-relative" onclick="getData(0)"
                        id="0"
                        style="border-radius: 25px; padding-left: 25px; padding-right: 25px;">Penghargaan</span>
                    </a>
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
                                                            <div class="col-12">
                                                                Semester ini<br>
                                                                <h4>{{ $item->poin_semester }} Poin</h4> <a
                                                                    href="{{ url('mobile/detail-pelanggaran') }}/{{ $item->id_mahasiswa }}">Detail</a>
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

    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Pelanggaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form">
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            @php
                                $taruna = DB::table('tarunas')->get();
                            @endphp
                            <select class="select2 form-control" name="id_mahasiswa" id="id_mahasiswa">
                                @foreach ($taruna as $item)
                                    <option value="{{ $item->id_mahasiswa }}">{{ $item->nama_mahasiswa }} | {{ $item->nim }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Pelanggaran</label>
                            <input type="date" class="form-control" id="tgl_pelanggaran" name="tgl_pelanggaran"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenis Pelanggaran</label>
                            @php
                                $pelanggaran = DB::table('pelanggarans')->get();
                            @endphp
                            <select class="select3 form-control" name="id_pelanggaran" id="id_pelanggaran">
                                @foreach ($pelanggaran as $item)
                                    <option value="{{ $item->id_pelanggaran }}">{{ $item->pelanggaran }} | <b>{{ $item->poin_pelanggaran }} Poin</b></option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Hukuman</label>
                            <textarea name="hukuman" id="hukuman" class="form-control" cols="30" rows="3" placeholder="Hukuman"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="tombol_kirim" style="border-radius: 25px;" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://unpkg.com/axios@0.27.2/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: "bootstrap",
                dropdownParent: $(".select2").parent()
            });
        });

        $(document).ready(function() {
            $('.select3').select2({
                theme: "bootstrap",
                dropdownParent: $(".select3").parent()
            });
        })


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

        form.onsubmit = (e) => {

            let formData = new FormData(form);

            e.preventDefault();

            document.getElementById("tombol_kirim").disabled = true;

            axios({
                    method: 'post',
                    url: formData.get('id') == '' ? '/mobile/store-pelanggaran' : '/mobile/update-pelanggaran',
                    data: formData,
                })
                .then(function(res) {
                    //handle success         
                    if (res.data.responCode == 1) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: res.data.respon,
                            timer: 3000,
                            showConfirmButton: false
                        })

                        //reload
                        window.location.replace("/mobile/pelanggaran");

                    } else {

                    }

                    document.getElementById("tombol_kirim").disabled = false;
                })
                .catch(function(res) {
                    //handle error
                    console.log(res);
                    document.getElementById("tombol_kirim").disabled = false;
                });
        }
    </script>
@endpush
