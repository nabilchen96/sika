@extends('template.index')

@push('kuesioner') active @endpush

@push('style')
<link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
      <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Soal Kuesioner {{ $data->judul_kuesioner }}
      </h2>
    </div>

    <div class="card mb-12">
      <div class="card-header">
        <a href="{{ url('kuesioner') }}" class="btn btn-sm btn-success"><i class="fas fa-arrow-left"></i> Kembali</a>
        <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalform" data-array=""><i
            class="fas fa-plus"></i> Tambah</a>
        {{-- <a href="#" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> Export</a> --}}
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" width="100%" id="dataTable" cellspacing="0">
            <thead>
              <tr>
                <th style="width: 20px">No</th>
                <th>Soal</th>
                <th>Jenis Soal</th>
                <th>Jawaban</th>
                <th style="width: 20px"></th>
                <th style="width: 20px"></th>
                <th style="width: 20px"></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($soal as $k => $item)
              <tr>
                <td>{{ $k+1 }}</td>
                <td>{{ $item->soal }}</td>
                <td>
                  @if ($item->jenis_soal == 1)
                  Pilihan
                  @elseif ($item->jenis_soal == 2)
                  Isian Singkat
                  @elseif ($item->jenis_soal == 3)
                  Benar Salah
                  @else
                  Skala
                  @endif
                </td>
                <td>
                  <?php $jawaban = unserialize($item->jawaban);  ?>
                  @forelse ($jawaban as $i)
                  <li>{{ $i }}</li>
                  @empty
                  -
                  @endforelse
                </td>
                <td class="text-center"><a href="{{ url('statistikdetailkuesioner') }}/{{ $item->id_detail_kuesioner }}" class="btn btn-sm btn-primary"><i class="fas fa-chart-bar"></i></a></td>
                <td>
                  <a href="#" class="btn btn-sm btn-success" data-array="{{ $soal[$k] }}" data-toggle="modal"
                    data-target="#modalform"><i class="fas fa-edit"></i></a>
                </td>
                <td>
                  <a href="{{ url('hapus-soal-kuesioner') }}/{{ $item->id_detail_kuesioner }}"
                    class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
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

<div class="modal fade" id="modalform" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Form Data Soal Kuesioner</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" id="formmodal">
        @csrf
        <input type="hidden" name="id_detail_kuesioner" id="id_detail_kuesioner">
        <input type="hidden" name="id_kuesioner" value="{{ $data->id_kuesioner }}">
        <div class="modal-body">
          <div class="form-group">
            <label for="col-form-label">Soal</label>
            <textarea rows="5" name="soal" class="form-control" id="soal" required></textarea>
          </div>
          <div class="form-group">
            <label for="col-form-label">Jenis Soal</label>
            <select name="jenis_soal" id="jenis_soal" class="form-control" required>
              <option value="">--Pilih Jenis Soal--</option>
              <option value="1">Pilihan</option>
              <option value="2">Isian Singkat</option>
              <option value="3">Benar Salah</option>
              <option value="4">Skala</option>
            </select>
          </div>
          <div id="tombol-tambah">

          </div>
          <div id="jawaban">

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
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
<script src="{{ asset('unserialize.js') }}"></script>

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
  var html = `<div class="form-group">
    <div class="row mt-2">
      <div class="col-10">
        <input type="text" class="form-control" name="jawaban[]" required>
      </div>
      <div class="col-2">
        <button class="btn btn-danger btn-block remove" type="button" onclick="remove()"><i
            class="fas fa-trash"></i></button>
      </div>
    </div>
  </div>`

  $('.modal').on('show.bs.modal', function (event){
    var button  = $(event.relatedTarget)
    var data    = button.data('array')
    var modal   = $(this)

    if(data == ''){
      $('#formmodal').attr('action', "{{ url('tambah-soal-kuesioner') }}")
      $("#formmodal").trigger('reset')

      $("#jawaban").html('')
      $("#tombol-tambah").html('')

    }else{
      $('#formmodal').attr('action', "{{ url('edit-soal-kuesioner') }}")

      modal.find('#id_detail_kuesioner').val(data.id_detail_kuesioner)
      modal.find('#soal').val(data.soal)
      modal.find('#jenis_soal').val(data.jenis_soal)

      var jawaban = PHPUnserialize.unserialize(data.jawaban)

      $("#jawaban .form-group").remove('')

      if(data.jenis_soal === '1'){
        $("#tombol-tambah").html('<button id="button_tambah" onclick="tambah()" class="btn btn-sm btn-success" type="button"><i class="fas fa-plus"></i> Tambah Jawaban</button>')
        for (let index = 0; index < Object.keys(jawaban).length; index++) {
          var html = `<div class="form-group">
                <div class="row mt-2">
                  <div class="col-10">
                    <input type="text" class="form-control" name="jawaban[]" value="`+jawaban[index]+`" required>
                  </div>
                  <div class="col-2">
                    <button class="btn btn-danger btn-block remove" type="button" onclick="remove()"><i
                        class="fas fa-trash"></i></button>
                  </div>
                </div>
              </div>`
          $("#jawaban").append(html)
        }
      }else{
        $("#tombol-tambah").html('')
      }
    }
  })

  $( "#jenis_soal" ).change(function() {
    var jenis_soal = $('#jenis_soal').val()

    if(jenis_soal === '1'){
      $("#jawaban").html(html)
      $("#tombol-tambah").html('<button id="button_tambah" onclick="tambah()" class="btn btn-sm btn-success" type="button"><i class="fas fa-plus"></i> Tambah Jawaban</button>')
    }else{
      $("#jawaban").html('')
      $("#tombol-tambah").html('')
    }
  });

  function tambah(){
    $("#jawaban .form-group:last-child").after(html)
  }

  function remove(){
    $("body").on("click",".remove",function(){ 
      $(this).parents(".form-group").not(':first-child').remove();
    });
  }
</script>
@endpush