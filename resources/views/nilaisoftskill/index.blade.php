@extends('template.index')

@push('nilai') active @endpush
@push('sub-nilai') show @endpush
@push('penilaiansoftskill') active @endpush

@push('style')
<link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="d-sm-flex align-items-center justify-content-between mb-4 alert alert-primary">
      <h2 class="h5 mb-0 text-gray-800"><i class="fas fa-fw fa-cog"></i> Penilaian / Penilaian SoftSkill</h2>
    </div>

    <div class="card mb-12">
      <div class="card-header">
      </div>
      <div class="card-body">
        <form action="{{ route('penilaiansoftskill.index') }}" method="GET">
          {{-- @csrf --}}
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Nama Taruna</label>
            <div class="col-sm-3">
              <select name="id_mahasiswa" class="form-control">
                <option value="">----</option>
                @foreach ($data as $d)
                  <option value="{{ $d->id_mahasiswa }}">{{ $d->nama_mahasiswa }} | {{ $d->nim }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label"></label>
            <div class="col-sm-2">
              <button type="submit" class="btn btn-sm btn-success">
                <i class="fas fa-search"></i> Tampilkan
              </button>
            </div>
          </div>
          <br>
        </form>
        <div class="table-responsive">
          <table class="table table-bordered table-striped" width="100%" id="dataTable" cellspacing="0">
            <thead>
              <tr>
                <th style="width: 20px">No</th>
                <th>Taruna</th>
                <th width="50%">Nilai Per-evaluasi</th>
                <th width="100">Nilai SoftSkill</th>
              </tr>
            </thead>
            <tbody>
              <?php $nilai = 0 ;?>
              @foreach ($taruna as $k => $item)
              <tr>
                <td>{{ $k+1 }}</td>
                <td>
                  {{ $item->nama_mahasiswa }} <br>
                  {{ $item->nim }}
                </td>
                <td>
                  @foreach ($komponen_nilai as $j)
                  <li>
                    {{ $j->jenis_softskill }}:
                    <?php
                    
                    $perevaluasi = DB::table('penilaian_soft_skills')
                                    ->join('komponen_softskills','komponen_softskills.id_komponen_softskill','=','penilaian_soft_skills.id_komponen_softskill')
                                    ->join('semesters', 'semesters.id_semester', '=', 'penilaian_soft_skills.id_semester')
                                    ->where('semesters.is_semester_aktif', '1')
                                    ->where('penilaian_soft_skills.id_mahasiswa', $item->id_mahasiswa)
                                    ->where('komponen_softskills.jenis_softskill', $j->jenis_softskill)
                                    ->sum('nilai');

                    echo $perevaluasi/$j->nilai;
                    
                    $nilai = $nilai + ($perevaluasi/$j->nilai);
                    ?>
                    <a href="{{ url('editpenilaiansoftskill') }}/{{ $_GET['id_mahasiswa'] }}/{{ $j->jenis_softskill }}"><i class="fas fa-edit"></i></a>
                  </li>
                  @endforeach
                </td>
                <td>
                  {{-- {{ $item->nilai_softskill }} <br>
                  {{ $total_soal }} --}}
                  {{-- {{ ($item->nilai_softskill / $total_soal) }} --}}
                  {{ $nilai / $komponen_nilai->count('nilai') }}
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
    @endif
</script>
@endpush