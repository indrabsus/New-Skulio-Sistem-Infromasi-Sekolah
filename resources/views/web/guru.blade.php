@extends('web.template')

@section('content')

<table class="table table-bordered table-striped">
    <tr>
        <th>Kode Guru</th>
        <th>Nama Guru</th>
        <th>Jenis Kelamin</th>
        <th>No HP</th>
    </tr>
    <?php $no=1; ?>
    @foreach ($data as $d)
    <tr>
        <td>{{ $no++ }}</td>
        <td>{{ $d->nama_guru }}</td>
        <td>@if ($d->jk_guru == 'L')
            Laki-laki
        @else
            Perempuan
        @endif</td>
        <td>{{ $d->nohp_guru }}</td>
    </tr>
    @endforeach

</table>

{{ $data->links() }}

@endsection
