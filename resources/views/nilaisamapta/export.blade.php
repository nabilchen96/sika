<table>
    <thead>
        <tr>
            <th style="width:3px; text-align: center;">No</th>
            <th style="width:20px; text-align: center;">Taruna</th>
            <th style="width:14px; text-align: center;">Samapta A</th>
            <th style="width:23px; text-align: center;">Samapta B</th>
            <th style="width:13px; text-align: center;">Nilai Samapta</th>
            <th style="width:16px; text-align: center;">Nilai BMI</th>
            <th style="width:8px; text-align: center;">Nilai BBI</th>
            <th style="width:12px; text-align: center;">
                Nilai Jasmani
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $k => $item)
        <tr>
            <td style="text-align:center; vertical-align: middle;">{{ $k+1 }}</td>
            <td style="text-align:center; vertical-align: middle;">
                {{ $item->nama_mahasiswa }}<br>
                {{ $item->nim }}
            </td>
            <td style="vertical-align: middle;">
                Nilai Lari: {{ $item->nilai_lari }} <br>
                Jarak Lari: {{ $item->jarak_lari }}
            </td>
            <td style="text-align:center; vertical-align: middle;">
                Nilai Push Up: {{ $item->nilai_push_up }} <br>
                Jumlah Push Up: {{ $item->jumlah_push_up }} <br>
                Nilai Sit Up: {{ $item->nilai_sit_up }} <br>
                Jumlah Sit Up: {{ $item->jumlah_sit_up }} <br>
                Nilai Shuttle Run: {{ $item->nilai_shuttle_run }} <br>
                Jumlah Shuttle Run: {{ $item->jumlah_shuttle_run }}
            </td>
            <td style="text-align:center; vertical-align: middle;">
                {{ round(($item->nilai_lari + (($item->nilai_push_up + $item->nilai_sit_up + $item->nilai_shuttle_run) / 3)) / 2, 2) }}
            </td>
            <td style="text-align:center; vertical-align: middle;">
                Tinggi Badan: {{ $item->tinggi_badan }} <br>
                Berat Badan: {{ $item->berat_badan }} <br>
                Nilai BMI:
                    {{ round($item->berat_badan / pow(($item->tinggi_badan/100), 2), 2) }} <br>
                
                Stakes: {{ $item->stakes }}
            </td>
            <td style="text-align:center; vertical-align: middle;">
                {{ $item->nilai_bbi }}
            </td>
            <td style="text-align:center; vertical-align: middle;">
                {{ $item->nilai_samapta }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>