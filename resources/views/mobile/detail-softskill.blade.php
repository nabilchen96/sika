@extends('layouts.mobile')
@section('content')
    <div
        style="height: 300px; background: linear-gradient(360deg, black, transparent), url('{{ asset('running.jpg') }}'); background-position: center; background-size: cover;">
        <a href="{{ url('mobile/softskill') }}/{{ $jenis_softskill }}">
            <i class="p-3 bi bi-arrow-left-circle text-white" style="font-size: 2rem;"></i>
        </a>      
    </div>
    <div class="container">
        <div class="ps-2" style="margin-top: -250px;">
            <h2 class="text-white">Nilai Softskill</h2>
            <h4 class="text-white">{{ @$jenis_softskill }}</h4>
            @php
                $taruna = DB::table('tarunas')
                    ->where('id_mahasiswa', $id_mahasiswa)
                    ->get();
            @endphp
            <h5 class="text-white">{{ @$taruna[0]->nama_mahasiswa }} | {{ @$taruna[0]->nim }}</h5>

            <ul class="nav nav-lt-tab mt-3 mb-0" style="border: 0;" role="tablist">
                <li class="nav-item" style="margin-right: 5px;">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modal" class="btn btn-primary"
                        style="border-radius: 20px; padding-left: 25px; padding-right: 25px;">Add or Edit</a>
                </li>

                @php
                    $jenissoftskill = DB::table('komponen_softskills')
                        ->groupBy('jenis_softskill')
                        ->get();
                @endphp

                @foreach ($jenissoftskill as $item)
                    <li class="nav-item" style="margin-right: 5px;">
                        <a href="{{ url('mobile/detail-softskill') }}/{{ $id_mahasiswa }}/{{ $item->jenis_softskill }}"
                            class="btn btn-primary"
                            style="border-radius: 20px; padding-left: 25px; padding-right: 25px;">{{ $item->jenis_softskill }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div style="margin-top: -10px; border-radius: 15px;">
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
                                                    <div class="col-9">
                                                        <b>Keterangan Evaluasi</b> <br>
                                                        {{ $item->keterangan_softskill }}
                                                    </div>
                                                    <div class="col-3">
                                                        <b>Nilai</b> <br>
                                                        {{ $item->nilai }}
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
                    <h5 class="modal-title" id="exampleModalLabel">Add or Edit {{ $jenis_softskill }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form">
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <select class="select2 form-control" name="id_mahasiswa" id="id_mahasiswa">
                                @foreach ($taruna as $item)
                                    <option value="{{ $item->id_mahasiswa }}">{{ $item->nama_mahasiswa }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if (count($data))
                            @foreach ($data as $item)
                                <div class="mb-3">
                                    <label class="form-label">{{ $item->keterangan_softskill }}</label>
                                    <select name="nilai[]" class="form-select">
                                        <option value=100 {{ $item->nilai == 100 ? 'selected' : '' }}>Ya</option>
                                        <option value=0 {{ $item->nilai == 0 ? 'selected' : '' }}>Tidak</option>
                                    </select>
                                    <input type="hidden" name="id_komponen_softskill[]"
                                        value="{{ $item->id_komponen_softskill }}">
                                </div>
                            @endforeach
                        @else
                            @php
                                $komponen = DB::table('komponen_softskills')->where('komponen_softskills.jenis_softskill', $jenis_softskill)->get();
                            @endphp
                            @foreach ($komponen as $item)
                                <div class="mb-3">
                                    <label class="form-label">{{ $item->keterangan_softskill }}</label>
                                    <select name="nilai[]" class="form-select">
                                        <option value=100>Ya</option>
                                        <option value=0>Tidak</option>
                                    </select>
                                    <input type="hidden" name="id_komponen_softskill[]"
                                        value="{{ $item->id_komponen_softskill }}">
                                </div>
                            @endforeach
                        @endif
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
                    url: formData.get('id') == '' ? '/mobile/store-softskill' : '/mobile/update-softskill',
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
                        window.location.reload();

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
