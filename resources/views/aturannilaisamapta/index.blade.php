@extends('template.index')

@push('aturannilai') active @endpush
@push('sub-aturannilai') show @endpush
@push('aturannilaisamapta') active @endpush

@push('style')
<link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
            <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Master Data / Data Aturan Nilai Samapta
            </h2>
        </div>

        <div class="card mb-12">
            <div class="card-header">
                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".modal" data-array=""><i
                        class="fas fa-plus"></i> Tambah</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%" id="dataTable" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 20px">No</th>
                                <th>Jenis Samapta</th>
                                <th>Nilai Untuk</th>
                                <th>Ukuran Menit/Putaran</th>
                                <th>Jumlah</th>
                                <th>Nilai</th>
                                <th width="10"></th>
                                <th width="10"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $k => $item)
                            <tr>
                                <td>{{ $k+1 }}</td>
                                <td>{{ $item->jenis_samapta }}</td>
                                <td>{{ $item->untuk }}</td>
                                <td>{{ $item->ukuran_menit }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>{{ $item->nilai }}</td>
                                <td>
                                    <a href="#" data-target=".modal" data-toggle="modal" data-array="{{ $data[$k] }}"
                                        class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>
                                </td>
                                <td>
                                    <a href="{{ url('hapusaturannilaisamapta') }}/{{ $item->id_nilai_samapta }}" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
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

<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Aturan Nilai Samapta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post">
                @csrf
                <input type="hidden" name="id_nilai_samapta" id="id_nilai_samapta">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Jenis Samapta</label>
                        <select name="jenis_samapta" class="form-control" id="jenis_samapta" onchange="ukuranmenit()">
                            <option value="">----</option>
                            <option>Lari</option>
                            <option>Push-up</option>
                            <option>Sit-up</option>
                            <option>Shuttle Run</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Nilai Untuk</label>
                        <select name="untuk" class="form-control" id="untuk">
                            <option value="">----</option>
                            <option>Taruna</option>
                            <option>Taruni</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Ukuran Menit/Putaran</label>
                        <input type="number" name="ukuran_menit" class="form-control" id="ukuran_menit">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Jumlah</label>
                        <input type="number" step="0.01" name="jumlah" class="form-control" id="jumlah">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Nilai</label>
                        <input type="number" name="nilai" class="form-control" id="nilai">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Tambah">
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
<script src="{{ asset('template/js/demo/datatables-demo.js') }}"></script>
<script>
    @if($message = Session::get('sukses'))
        toastr.success("{{ $message }}")
    @elseif($message = Session::get('gagal'))
        toastr.error("{{ $message }}")
    @elseif($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}")
        @endforeach
    @endif
</script>
<script>
    $('.modal').on('show.bs.modal', function (event) {
    var button  = $(event.relatedTarget)
    var data    = button.data('array');
    var modal   = $(this)

    if(data === ''){
        $('.form').attr('action', "{{ url('tambahaturannilaisamapta') }}").trigger('reset')
    }else{
        $('.form').attr('action', "{{ url('editaturannilaisamapta') }}")

        modal.find('#id_nilai_samapta').val(data.id_nilai_samapta)
        modal.find('#untuk').val(data.untuk)
        modal.find('#jenis_samapta').val(data.jenis_samapta)
        modal.find('#ukuran_menit').val(data.ukuran_menit)
        modal.find('#jumlah').val(data.jumlah)
        modal.find('#nilai').val(data.nilai)
    }

    })
</script>
<script>
    $( document ).ready(function() {
        ukuranmenit()
     })

     function ukuranmenit(){
        var jenis_samapta = document.getElementById('jenis_samapta').value 
        var menit;

        if(jenis_samapta == 'Lari'){
            menit = 12
        }else if(jenis_samapta == 'Push-up'){
            menit = 1
        }else if(jenis_samapta == 'Sit-up'){
            menit = 1
        }else if(jenis_samapta == 'Shuttle Run'){
            menit = 3
        }

        document.getElementById('ukuran_menit').value = menit
     }
</script>
@endpush