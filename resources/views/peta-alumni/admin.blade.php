<!doctype html><html lang="id"><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Admin Peta Alumni</title>
<style>body{font:16px system-ui;color:#10283d;background:#f3f6fa;margin:0;padding:24px}main{max-width:780px;margin:auto;background:white;border-radius:16px;padding:24px}label{display:block;margin:12px 0}input,select{display:block;width:100%;box-sizing:border-box;padding:9px;border:1px solid #9bb2c6;border-radius:6px}button{background:#13648e;color:white;border:0;padding:10px 15px;border-radius:6px;cursor:pointer}td,th{text-align:left;padding:8px;border-bottom:1px solid #ddd}.error{color:#a22222}</style>
<main>
<a href="{{ route('peta-alumni.index') }}">← Peta publik</a>
<h1>Admin Peta Alumni</h1>
@if(session('status')) <p role="status">{{ session('status') }}</p> @endif
@if($errors->any())
<ul class="error" role="alert">
@foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
</ul>
@endif
<form method="post" action="{{ route('peta-alumni.store') }}">
@csrf
@foreach(['name'=>'Nama alumni','work'=>'Tempat kerja','province'=>'Provinsi','city'=>'Kota/kabupaten'] as $field => $label)
<label>{{ $label }}<input name="{{ $field }}" required maxlength="120" value="{{ old($field) }}"></label>
@endforeach
<label>Program studi<select name="program" required>
@foreach($programs as $program)
<option {{ old('program') === $program ? 'selected' : '' }}>{{ $program }}</option>
@endforeach
</select></label>
<label>Lintang<input name="lat" type="number" step="any" min="-90" max="90" required value="{{ old('lat') }}"></label>
<label>Bujur<input name="lng" type="number" step="any" min="-180" max="180" required value="{{ old('lng') }}"></label>
<button>Simpan alumni</button>
</form>
<h2>Data tersimpan</h2>
<div style="overflow:auto"><table>
<thead><tr><th>Nama</th><th>Program studi</th><th>Tempat kerja</th><th>Lokasi</th></tr></thead>
<tbody>
@forelse($rows as $row)
<tr><td>{{ $row['name'] }}</td><td>{{ $row['program'] }}</td><td>{{ $row['work'] }}</td><td>{{ $row['city'] }}, {{ $row['province'] }}</td></tr>
@empty
<tr><td colspan="4">Belum ada data alumni.</td></tr>
@endforelse
</tbody></table></div>
</main></html>
