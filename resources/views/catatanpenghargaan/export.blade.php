<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Penerima Penghargaan</th>
            <th>Tanggal Penghargaan</th>
            <th>Penghargaan</th>
            <th>Bidang Penghargaan</th>
            <th>Poin Penghargaan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $k => $item)
        <tr>
            <td>{{ $k+1 }}</td>
            <td>{{ $item->nama_mahasiswa }}</td>
            <td>{{ date('d-m-Y', strtotime($item->tgl_penghargaan)) }}</td>
            <td>{{ $item->penghargaan }}</td>
            <td>{{ $item->bidang_penghargaan }}</td>
            <td>{{ $item->poin_penghargaan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>