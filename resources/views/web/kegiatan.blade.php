@extends('web.layouts.template')

@section('content')



<table class="display" id="table_id">
    <thead>
    <tr>
        <th>No</th>
        <th>Nama Kegiatan</th>
        <th>Tempat</th>
        <th>Waktu</th>
        <th>Pengirim</th>
    </tr>
</thead>
<tbody>
    <?php $no=1; ?>
    @foreach ($data as $d)
    <tr>
        <td>{{ $no++ }}</td>
        <td>{{ $d->nama_kegiatan }}</td>
        <td>{{ $d->tempat_kegiatan }}</td>
        <td>{{ $d->waktu_kegiatan }}</td>
        <td>{{ $d->pengirim }}</td>
    </tr>
    @endforeach
</tbody>
</table>



@endsection
