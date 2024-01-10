<table>
    <thead>
        <tr>
            <th>No</th>
            <th>NIT</th>
            <th>Nama Taruna</th>
            <th>Jenis Kelamin</th>
            <th>Program Studi</th>
            <th>Poin Bulan Ini</th>
            <th>Poin Semester Ini</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $k => $item)
        <tr>
            <td>{{ $k+1 }}</td>
            <td>{{ $item['nim'] }}</td>
            <td>{{ $item['nama_mahasiswa'] }}</td>
            <td>{{ $item['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            <td>{{ $item['nama_program_studi'] }}</td>
            <td>{{ $item['poin_bulan_ini'] }}</td>
            <td>{{ $item['poin_semester_ini'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>