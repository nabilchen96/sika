@extends('template.index')

@push('lamaran-kerja')
    active
@endpush

@push('style')
    <link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
                <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Data Lamaran Kerja</h2>
            </div>

            <div class="card mb-12">
                <div class="card-header">
                   

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" width="100%" id="dataTable" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="width: 20px">No</th>
                                    <th>Nama Pelamar</th>
                                    <th>Jenis Kelamin</th>
                                    <th width="25%">Data Lainnya</th>
                                    <th width="25%">Melamar dari</th>
                                    <th width="10">Lihat Berkas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $k => $item)
                                    <tr>
                                        <td>{{ $k=1 }}</td>
                                        <td>{{ $item->nama_pelamar }}</td>
                                        <td>{{ $item->jenis_kelamin }}</td>
                                        <td>
                                             <ul style="padding-left: 20px;">
                                                <li><b>Email</b><br> {{ $item->email }}</li>
                                                <li><b>Nomor Telpon</b><br> {{ $item->nomor_telpon }}</li>
                                                <li><b>Alamat</b><br> {{ $item->alamat }}</li>
                                                <li><b>Pengalaman</b><br> {{ $item->pengalaman }}</li>
                                             </ul>
                                        </td>
                                        <td>
                                            <a target="_blank" href="{{ url('detailberita') }}/{{ $item->id_berita }}">
                                                {{ $item->judul_berita }}
                                            </a>
                                        </td>
                                        <td>
                                            <a target="_blank" class="btn btn-sm btn-primary text-center" href="{{ url('lamaran') }}/{{ $item->upload_lamaran }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formuser">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">NIP <sup class="text-danger">*</sup></label>
                            <input type="text" placeholder="NIP" name="nip" class="form-control" required
                                id="nip">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Nama <sup class="text-danger">*</sup></label>
                            <input type="text" placeholder="Nama" name="name" class="form-control" required
                                id="name">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Jenis Kelamin <sup
                                    class="text-danger">*</sup></label>
                            <select name="jk" placeholder="Jenis Kelamin" class="form-control" required>
                                <option value="1">Laki-laki</option>
                                <option value="0">perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">role <sup class="text-danger">*</sup></label>
                            <select name="role" placeholder="Role" class="form-control" required>
                                <option>admin</option>
                                <option>pusbangkar</option>
                                <option>pengasuh</option>
                                <option>poliklinik</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="col-form-label">Email <sup class="text-danger">*</sup></label>
                            <input type="email" placeholder="Email Address" name="email" class="form-control" required
                                id="email">
                        </div>
                        <div class="form-group">
                            <label for="col-form-label">Password</label>
                            <input type="password" placeholder="Password" name="password" class="form-control"
                                id="password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button id="tombol_kirim" type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('template/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="https://unpkg.com/axios@1.1.2/dist/axios.min.js"></script>
    <script src="{{ asset('template/js/demo/datatables-demo.js') }}"></script>
    {{-- <script>
        @if ($message = Session::get('sukses'))
            toastr.success("{{ $message }}")
        @elseif ($message = Session::get('gagal'))
            toastr.error("{{ $message }}")
        @endif
    </script> --}}

    <script>
        $('#modal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var recipient = button.data('bs-id')

            document.getElementById("form").reset();
            document.getElementById('id').value = ''

            if (recipient) {
                var modal = $(this)
                modal.find('#id').val(button.data('bs-id'))
                modal.find('#name').val(button.data('bs-name'))
                modal.find('#email').val(button.data('bs-email'))
                modal.find('#role').val(button.data('bs-role'))
                modal.find('#jk').val(button.data('bs-jk'))
                modal.find('#nip').val(button.data('bs-nip'))
            }
        })

        formuser.onsubmit = (e) => {

            let formData = new FormData(formuser);

            e.preventDefault();

            document.getElementById("tombol_kirim").disabled = true;

            axios({
                    method: 'post',
                    url: formData.get('id') == '' ? '/tambahuser' : '/edituser',
                    data: formData,
                })
                .then(function(res) {
                    //handle success         
                    if (res.data.responCode == 1) {


                        $('#modal').modal('hide');
                        toastr.success("Data Sukses Ditambahkan");
                        setTimeout(function() {
                            toastr.clear();
                            setTimeout(function() {
                                location
                                    .reload(); // Me-reload halaman setelah 2 detik (2000 milidetik)
                            }, 500);
                        }, 500);


                    } else {

                        console.log('error');
                    }

                    document.getElementById("tombol_kirim").disabled = false;
                })
                .catch(function(res) {
                    document.getElementById("tombol_kirim").disabled = false;
                    //handle error
                    console.log(res);
                });
        }

        hapusData = (id) => {
            if (window.confirm('Apakah ingin menghapus Data?')) {
                axios.post('/hapususer', {
                        id
                    })
                    .then((response) => {
                        if (response.data.responCode == 1) {
                            location.reload();
                        } else {
                            alert('Data gagal dihapus');
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }
    </script>
@endpush
