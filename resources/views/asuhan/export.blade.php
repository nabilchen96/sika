<table>
    <thead>
        <tr>
            <th>No</th>
            <th>NIT</th>
            <th>Nama Taruna</th>
            <th>Jenis Kelamin</th>
            <th>Proram Studi</th>
            <th>Pengasuh</th>
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
            <td>{{ $item->name }}</td>
        </tr>
        @endforeach
    </tbody>
</table>