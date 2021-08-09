<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Penghargaan</th>
            <th>Bidang Penghargaan</th>
            <th>Poin Penghargaan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $k => $item)
        <tr>
            <td>{{ $k+1 }}</td>
            <td>{{ $item->penghargaan }}</td>
            <td>{{ $item->bidang_penghargaan }}</td>
            <td>{{ $item->poin_penghargaan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>