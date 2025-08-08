<table>
    <thead>
        <tr>
            <th style="width: 3px">No</th>
            <th style="width: 17px;">Taruna</th>
            <th style="width: 80px;">Nilai Per-evaluasi</th>
            <th style="width: 13px">Nilai SoftSkill</th>
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
              {{ $j->jenis_softskill }}:
              <?php
            
                $perevaluasi = DB::table('penilaian_soft_skills')
                                ->join('komponen_softskills','komponen_softskills.id_komponen_softskill','=','penilaian_soft_skills.id_komponen_softskill')
                                ->join('semesters', 'semesters.id_semester', '=', 'penilaian_soft_skills.id_semester')
                                ->where('semesters.is_semester_aktif', '1')
                                ->where('penilaian_soft_skills.id_mahasiswa', $item->id_mahasiswa)
                                ->where('komponen_softskills.jenis_softskill', $j->jenis_softskill)
                                ->sum('nilai');

                echo round($perevaluasi/$j->nilai, 2);
                
                $nilai = $nilai + ($perevaluasi/$j->nilai);
                echo '<br>';
            ?>
            @endforeach
          </td>
          <td>
            {{ round($nilai / $komponen_nilai->count('nilai'), 2) }}
          </td>
        </tr>
        @endforeach
      </tbody>
</table>