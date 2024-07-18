@extends('template.index')

@push('tarunakamar') active @endpush

@push('style')
<link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
            <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Master Data / Detail Data Taruna</h2>
        </div>

        <div class="card mb-12">
            <div class="card-header">
                <a href="{{url('tarunakamar')}}" class="btn btn-sm btn-success"><i class="fas fa-arrow-left"></i>
                    Kembali</a>
            </div>
            <form action="{{ url('simpan-tarunakamar') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nama Kamar</label>
                        <div class="col-sm-3">
                            <select name="id_kamar" class="form-control">
                                @foreach ($kamar as $item)
                                    <option value="{{ $item->id_kamar }}">
                                        {{ $item->nama_kamar }} :
                                        {{ DB::table('taruna_kamars')->where('id_kamar', $item->id_kamar)->count() }} / {{ $item->batas_kamar }} Taruna
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>  
                    <br>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nama Taruna</label>
                        <div class="col-sm-10">
                            <table class="table table-striped" width="100%" id="dataTable">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th style="width: 20px">No</th>
                                        <th>NIT</th>
                                        <th>Nama Taruna</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Program Studi</th>
                                        <th>Kelas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $k => $item)
                                        <tr>
                                            <td>
                                                <input style="vertical-align: middle;" type="checkbox" name="id_mahasiswa[]" value="{{ $item->id_mahasiswa }}">
                                            </td>
                                            <td>{{ $k+1 }}</td>
                                            <td>{{ $item->nim }}</td>
                                            <td>{{ $item->nama_mahasiswa }}</td>
                                            <td>{{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                            <td>{{ $item->nama_program_studi }}</td>
                                            <td>{{ $item->nama_kelas }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-5">
                            <button class="btn btn-sm btn-success" type="submit">
                                <i class="fas fa-plus"></i> Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<br>
@endsection

@push('scripts')
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
{{-- <script>
    $(function() {
          let id
          $('#table-taruna').DataTable({
              processing: true,
              serverSide: true,
              ajax: 'tambah-tarunakamar-json',
              columns: [
                    { data: 'id_mahasiswa', render: function (data){
                        return '<input style="vertical-align: middle;" type="checkbox" name="id_mahasiswa[]" value="'+data+'">'
                    }},
                  { data: 'id_mahasiswa', name:'id_mahasiswa', render: function (data, type, row, meta) {
                      id = data
                      return meta.row + meta.settings._iDisplayStart + 1;
                  }},
                  { data: 'nim', name:'nim'},
                  { data: 'nama_mahasiswa', name:'nama_mahasiswa'},
                  { data: 'jenis_kelamin', name:'jenis_kelamin', render: function(data){
                    return (data == 'L' ? 'Laki-laki' : 'Perempuan')
                  }},
                  { data: 'nama_program_studi', name:'nama_program_studi'},
                  { data: 'nama_kelas', name: 'nama_kelas'},
              ]
          });
      });
</script> --}}
@endpush