@extends('web.layouts.template')

@section('content')

<table class="display" id="table_id">
    <thead>
    <tr>
        <th>Kode Guru</th>
        <th>Nama Guru</th>
        <th>Jenis Kelamin</th>
        <th>No HP</th>
    </tr>
</thead>
<tbody>
    @foreach ($data as $d)
    <tr>
        <td>{{ $d->kode_guru }}</td>
        <td>{{ $d->nama_guru }}</td>
        <td>@if ($d->jk_guru == 'L')
            Laki-laki
        @else
            Perempuan
        @endif</td>
        <td>{{ $d->nohp_guru }}</td>
    </tr>
    @endforeach
</tbody>

</table>



@endsection
