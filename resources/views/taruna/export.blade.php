<table>
    <thead>
        <tr>
            <th>No</th>
            <th>NIT</th>
            <th>Nama Taruna</th>
            <th>Jenis Kelamin</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Agama</th>
            <th>Kelas</th>
            <th>Program Studi</th>
            <th>Semester</th>
            <th>Alamat</th>
            <th>Nama Wali</th>
            <th>Nomor Wali</th>
            <th>Hubungan Wali</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $k => $item)
        <tr>
            <td>{{ $k+1 }}</td>
            <td>{{ $item->nim }}</td>
            <td>{{ $item->nama_mahasiswa }}</td>
            <td>{{ $item->jenis_kelamin }}</td>
            <td>{{ $item->tempat_lahir }}</td>
            <td>{{ $item->tanggal_lahir }}</td>
            <td>{{ $item->agama }}</td>
            <td>{{ $item->kelas }}</td>
            <td>{{ $item->nama_program_studi }}</td>
            <td>{{ $item->semester }}</td>
            <td>{{ $item->alamat }}</td>
            <td>{{ $item->wali_dihubungi }}</td>
            <td>{{ $item->no_wali_dihubungi }}</td>
            <td>{{ $item->hubungan_wali }}</td>
        </tr>
        @endforeach
    </tbody>
</table>