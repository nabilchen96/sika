@extends('layouts.mobile')
@section('content')
    <div
        style="height: 300px; background: linear-gradient(360deg, black, transparent), url('{{ asset('poltekbang.jpg') }}'); background-position: center; background-size: cover;">

    </div>
    <div class="container">
        <div class="ps-2" style="margin-top: -270px;">
            <h2 class="text-white">Penilaian Jasmani</h2>
            <h4 class="text-white">{{ @$data[0]->nama_semester }}</h4>
            <ul class="nav nav-lt-tab mt-3" style="border: 0;" role="tablist">
                <li class="nav-item" style="margin-right: 5px;">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modal" class="btn btn-primary"
                        style="border-radius: 20px; padding-left: 25px; padding-right: 25px;">Cari</a>
                </li>
                {{-- <li class="nav-item" style="margin-right: 5px;">
                    <a href="{{ url('mobile/lari') }}" class="btn btn-primary"
                        style="border-radius: 20px; padding-left: 25px; padding-right: 25px;">Nilai Total</a>
                </li> --}}
                <li class="nav-item" style="margin-right: 5px;">
                    <a href="{{ url('mobile/nilai') }}" class="btn btn-primary"
                        style="border-radius: 20px; padding-left: 25px; padding-right: 25px;">Nilai Jasmani</a>
                </li>
                <li class="nav-item" style="margin-right: 5px;">
                    <a href="{{ url('mobile/nilai-pelanggaran') }}" class="btn btn-primary position-relative"
                        onclick="getData(0)" id="0"
                        style="border-radius: 25px; padding-left: 25px; padding-right: 25px;">Nilai Pelanggaran</span>
                    </a>
                </li>
                <li class="nav-item" style="margin-right: 5px;">
                    <a href="{{ url('mobile/nilai-penghargaan') }}" class="btn btn-primary" onclick="getData(1)"
                        id="1" style="border-radius: 25px; padding-left: 25px; padding-right: 25px;">Nilai
                        Penghargaan</a>
                </li>
                {{-- <li class="nav-item" style="margin-right: 5px;">
                    <a href="{{ url('mobile/shuttlerun') }}" class="btn btn-primary" onclick="getData(1)" id="1"
                        style="border-radius: 25px; padding-left: 25px; padding-right: 25px;"> Shuttle Run</a>
                </li>
                <li class="nav-item" style="margin-right: 5px;">
                    <a href="{{ url('mobile/bbi') }}" class="btn btn-primary" onclick="getData(1)" id="1"
                        style="border-radius: 25px; padding-left: 25px; padding-right: 25px;"> BBI</a>
                </li> --}}
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
                                                            @if ($item->foto != null)
                                                                @php
                                                                    $file = $item->foto;
                                                                    $file_headers = @get_headers($file);
                                                                @endphp
                                                                @if ($file_headers[0] != 'HTTP/1.1 404 Not Found')
                                                                    <img style="border-radius: 15px; height: 100%; object-fit: cover; width: 100%;"
                                                                    src="{{ $item->foto }}" alt="">
                                                                @else
                                                                    <img style="object-fit: cover; width: 100%;"
                                                                    src="{{ asset('male.svg') }}" alt="">
                                                                @endif
                                                            @else
                                                                <img style="object-fit: cover; width: 100%;"
                                                                    src="{{ asset('male.svg') }}" alt="">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-8">
                                                        {{ $item->nama_mahasiswa }}<br>
                                                        <span class="badge bg-primary">{{ $item->nim }}</span>
                                                        <span class="badge bg-primary">
                                                            @if ($item->nama_program_studi == 'Teknologi Rekayasa Bandar Udara')
                                                                TRBU
                                                            @elseif($item->nama_program_studi == 'Manajemen Bandar Udara')
                                                                MBU
                                                            @elseif($item->nama_program_studi == 'Penyelamatan dan Pemadam Kebakaran Penerbangan')
                                                                PPKP
                                                            @endif
                                                        </span>
                                                        <div class="row mt-2">
                                                            <div class="col-12">
                                                                <b>Nilai Jasmani</b> <br>
                                                                <h4>{{ $item->nilai_samapta ?? 0 }} <a
                                                                        style="font-size: 14px;" role="button"
                                                                        aria-expanded="false"
                                                                        aria-controls="collapseExample"
                                                                        data-bs-toggle="collapse"
                                                                        href="#data{{ $item->id_mahasiswa }}">Detail</a>
                                                                </h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="collapse" style="font-size: 12px;"
                                                        id="data{{ $item->id_mahasiswa }}">
                                                        <div class="card" style="border-radius: 15px;">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-4">
                                                                        Lari <br>
                                                                        <h4>{{ $item->nilai_lari ?? 0 }}</h4>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        Push Up <br>
                                                                        <h4>{{ $item->nilai_push_up ?? 0 }}
                                                                        </h4>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        Sit Up <br>
                                                                        <h4>{{ $item->nilai_sit_up ?? 0 }}</h4>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        Shuttle Run <br>
                                                                        <h4>{{ $item->nilai_shuttle_run ?? 0 }}
                                                                        </h4>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        BBI <br>
                                                                        <h4>{{ $item->nilai_bbi ?? 0 }}</h4>
                                                                    </div>
                                                                </div>
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
                    <h5 class="modal-title" id="exampleModalLabel">Cari Taruna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('mobile/nilai') }}">
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            @php
                                $taruna = DB::table('tarunas')->get();
                            @endphp
                            <select class="select2 form-control" name="id_mahasiswa" id="id_mahasiswa" required>
                                <option value="all">Tampilan Semua</option>
                                @foreach ($taruna as $item)
                                    <option value="{{ $item->id_mahasiswa }}">{{ $item->nama_mahasiswa }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Semester</label>
                            @php
                                $semester = DB::table('semesters')
                                    ->orderBy('id_semester', 'DESC')
                                    ->take('10')
                                    ->get();
                            @endphp
                            <select class="select2 form-control" name="id_semester" id="id_semester" required>
                                @foreach ($semester as $item)
                                    <option value="{{ $item->id_semester }}">{{ $item->nama_semester }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" style="border-radius: 25px;" class="btn btn-primary">Submit</button>
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

        $('#modal').on('show.bs.modal', function(event) {
            // var button = $(event.relatedTarget) // Button that triggered the modal
            // var recipient = button.data('bs-id') // Extract info from data-* attributes
            // var cok = $("#myTable").DataTable().rows().data().toArray()

            // let cokData = cok.filter((dt) => {
            //     return dt.id == recipient;
            // })

            // document.getElementById("form").reset();
            // document.getElementById('id').value = ''
            // $('.error').empty();

            // if (recipient) {
            //     var modal = $(this)
            //     modal.find('#id').val(cokData[0].id)
            //     modal.find('#awal').val(cokData[0].awal)
            //     modal.find('#akhir').val(cokData[0].akhir)
            //     modal.find('#status').val(cokData[0].status)
            // }
        })

        form.onsubmit = (e) => {

            let formData = new FormData(form);

            e.preventDefault();

            document.getElementById("tombol_kirim").disabled = true;

            axios({
                    method: 'post',
                    url: formData.get('id') == '' ? '/mobile/store-lari' : '/mobile/update-lari',
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
                        window.location.replace("/mobile/lari");

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
