<table>
    <thead>
        <tr>
            <th>No</th>
            <th>NIT</th>
            <th>Nama Taruna</th>
            <th>Program Studi</th>
            <th>Tanggal Hukuman</th>
            <th>Keterangan Hukuman</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $k => $item)
        <tr>
            <td>{{ $k+1 }}</td>
            <td>{{ $item->nim }}</td>
            <td>{{ $item->nama_mahasiswa }}</td>
            <td>{{ $item->nama_program_studi }}</td>
            <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
            <td>{{ $item->keterangan }}</td>
            <td>{{ $item->is_dikerjakan == '1' ? 'Sudah Dikerjakan' : 'Belum Dikerjakan' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>