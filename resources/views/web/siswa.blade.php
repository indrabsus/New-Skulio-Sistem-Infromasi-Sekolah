@extends('web.layouts.template')

@section('content')

<table class="display" id="table_id">
    <thead>
    <tr>
        <th>No</th>
        <th>Nama Siswa</th>
        <th>Jenis Kelamin</th>
        <th>No Hp</th>
        <th>Kelas</th>
        <th>Poin</th>
    </tr>
</thead>
<tbody>
    <?php $no=1; ?>
    @foreach ($data as $d)
    <tr>
        <td>{{ $no++ }}</td>
        <td>{{ $d->nama_siswa }}</td>
        <td>@if ($d->jk_siswa == 'l')
            Laki-laki
        @else
            Perempuan
        @endif</td>
        <td>{{ $d->nohp }}</td>
        <td>{{ $d->nama_kelas }}</td>
        <td>{{ $d->poin }}</td>
    </tr>
    @endforeach
</tbody>

</table>



@endsection
