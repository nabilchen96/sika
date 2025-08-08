<table>
    <thead>
        <tr>
            <th style="width: 5px">No</th>
            <th style="width: 50px">Taruna</th>
            <th style="width: 10px">NIT</th>
            <th style="width: 10px">Nilai SoftSkill</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($nilai as $k => $item)
            <tr>
                <td>{{ $k + 1 }}</td>
                <td>{{ $item['nama_mahasiswa'] }}</td>
                <td>{{ $item['nim'] }}</td>
                <td>{{ $item['nilai_softskill'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
