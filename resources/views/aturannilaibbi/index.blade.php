@extends('template.index')

@push('aturannilai') active @endpush
@push('sub-aturannilai') show @endpush
@push('aturannilaibbi') active @endpush

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
                                <th>BMI</th>
                                <th>Stakes</th>
                                <th>Untuk</th>
                                <th>Nilai</th>
                                <th width="10"></th>
                                <th width="10"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $k => $item)
                            <tr>
                                <td>{{ $k+1 }}</td>
                                <td>{{ $item->bmi }}</td>
                                <td>{{ $item->stakes }}</td>
                                <td>{{ $item->untuk }}</td>
                                <td>{{ $item->nilai }}</td>
                                <td>
                                    <a href="#" data-array="{{ $data[$k] }}" data-toggle="modal" data-target=".modal"
                                        class="btn btn-sm btn-success">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ url('hapusaturannilaibbi') }}/{{ $item->id_nilai_bbi }}"
                                        class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
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
                <input type="hidden" name="id_nilai_bbi" id="id_nilai_bbi">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">BMI</label>
                        <input type="number" name="bmi" id="bmi" class="form-control" onkeyup="setstakes()">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Nilai Untuk</label>
                        <select name="untuk" id="untuk" class="form-control" onchange="setstakes()">
                            <option value="">----</option>
                            <option>Taruna</option>
                            <option>Taruni</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Stakes</label>
                        <input type="text" class="form-control" name="stakes" id="stakes" readonly>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Nilai</label>
                        <input type="number" name="nilai" id="nilai" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Simpan">
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

    $('.modal').on('show.bs.modal', function (event) {
        var button  = $(event.relatedTarget)
        var data    = button.data('array')
        var modal   = $(this)

        if(data === ''){
            $('.form').attr('action', "{{ url('tambahaturannilaibbi') }}").trigger('reset')
        }else{
            $('.form').attr('action', "{{ url('editaturannilaibbi') }}")

            modal.find('#id_nilai_bbi').val(data.id_nilai_bbi)
            modal.find('#untuk').val(data.untuk)
            modal.find('#bmi').val(data.bmi)
            modal.find('#stakes').val(data.stakes)
            modal.find('#nilai').val(data.nilai)
        }
    })

    $( document ).ready(function() {
        setstakes()
     })

     function setstakes(){
        var bmi     = document.getElementById('bmi').value 
        var untuk   = document.getElementById('untuk').value
        var stakes

        if(untuk == 'Taruna'){
            if(bmi >= 18 && bmi <= 23){
                stakes  = "Stakes 1"
            }else if(bmi >= 16 && bmi <= 25){
                stakes  = "Stakes 2"
            }else if(bmi >= 26 && bmi <= 30){
                stakes = "Stakes 3"
            }else if(bmi == 0){
                stakes  = ""
            }else{
                stakes  = "Stakes 4"
            }
        }else if(untuk == 'Taruni'){
            if(bmi >= 18.5 && bmi <= 23){
                stakes = "Stakes 1"
            }else if(bmi >= 16.5 && bmi <= 25){
                stakes = "Stakes 2"
            }else if(bmi >= 26 && bmi <= 30){
                stakes = "Stakes 3"
            }else if(bmi == 0){
                stakes = ""
            }else{
                stakes = "Stakes 4"
            }
        }else{
            stakes = ''
        }            

        
        document.getElementById('stakes').value     = stakes
     }

    
</script>
@endpush