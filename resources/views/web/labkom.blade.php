@extends('web.layouts.template')

@section('content')



<table class="display" id="table_id">
    <thead>
    <tr>
        <th>No</th>
        <th>Nama Guru</th>
        <th>Mata Pelajaran</th>
        <th>Kelas</th>
        <th>Lab</th>
        <th>Hari</th>
        <th>Jam</th>
    </tr>
</thead>
<tbody>
    <?php $no=1; ?>
    @foreach ($data as $d)
    <tr>
        <td>{{ $no++ }}</td>
        <td>{{ $d->nama_guru }}</td>
        <td>{{ $d->nama_mapel }}</td>
        <td>{{ $d->nama_kelas }}</td>
        <td>Lab {{ strtoupper($d->tempat) }}</td>
        <td>{{ $d->hari }}</td>
        <td>{{ $d->jam_a }} - {{ $d->jam_b }}</td>
    </tr>
    @endforeach
</tbody>
</table>



@endsection
