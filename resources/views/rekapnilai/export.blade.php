<table>
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">NIT</th>
            <th rowspan="2">Nama Taruna</th>
            <th rowspan="2">Jenis Kelamin</th>
            <th rowspan="2">Program Studi</th>
            <th rowspan="2">Kelas</th>
            <th rowspan="2">Nilai Jasmani</th>
            <th colspan="3" class="text-center">Nilai Softskill</th>
            <th rowspan="2">Nilai Akhir</th>
        </tr>
        <tr>
            <th>Nilai Softskill Competency</th>
            <th>Nilai Pelanggaran</th>
            <th>Nilai Penghargaan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $k => $item)
        <tr>
            <td>{{ $k+1 }}</td>
            <td>{{ $item->nim }}</td>
            <td>{{ $item->nama_mahasiswa }}</td>
            <td>{{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            <td>{{ $item->nama_program_studi }}</td>
            <td>{{ $item->nama_kelas }}</td>
            <td>{{ $item->nilai_samapta }}</td>
            <td>{{ $item->nilai_softskill }}</td>
            <td>{{ $item->nilai_pelanggaran }}</td>
            <td>{{ $item->nilai_penghargaan }}</td>
            <td>
                <?php
                    $nilai1 = $item->nilai_samapta * 40 / 100;
                    $nilai2 = $item->nilai_softskill * 50 / 100;
                    $nilai3 = $item->nilai_pelanggaran * 25 / 100;
                    $nilai4 = $item->nilai_penghargaan * 25 / 100;    
                ?>
                {{ round(@$nilai1 + (($nilai2 + $nilai3 + $nilai4) * 60 / 100), 2) }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>