<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Pelanggaran</th>
            <th>Kategori Pelanggaran</th>
            <th>Poin Pelanggaran</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $k => $item)
        <tr>
            <td>{{ $k+1 }}</td>
            <td>{{ $item->pelanggaran }}</td>
            <td>{{ $item->kategori_pelanggaran }}</td>
            <td>{{ $item->poin_pelanggaran }}</td>
        </tr>
        @endforeach
    </tbody>
</table>