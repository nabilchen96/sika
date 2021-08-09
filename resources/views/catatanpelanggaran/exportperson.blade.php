<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Jenis Pelanggaran</th>
            <th>Poin Pelanggaran</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $k => $item)
        <tr>
            <td>{{ $k+1 }}</td>
            <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
            <td>{{ $item->pelanggaran }}</td>
            <td>{{ $item->poin_pelanggaran }}</td>
        </tr>
        @endforeach
    </tbody>
</table>