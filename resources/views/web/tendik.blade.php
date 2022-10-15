@extends('web.layouts.template')

@section('content')
<table id="table_id" class="display">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Tendik</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=1; ?>
    @foreach ($data as $d)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $d->nama_staf }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
