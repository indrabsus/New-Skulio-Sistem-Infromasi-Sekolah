@extends('web.layouts.template')

@section('content')
<table id="table_id" class="display">
    <thead>
        <tr>
            <th>No</th>
            <th>Kelas</th>
            <th>Walikelas</th>
            <th>No HP</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=1; ?>
    @foreach ($data as $d)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $d->nama_kelas }}</td>
            <td>{{ $d->nama_guru }}</td>
            <td>{{ $d->nohp_guru }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
