@extends('web.layouts.template')

@section('content')



<table class="display" id="table_id">
    <thead>
    <tr>
        <th>No</th>
        <th>Tanggal Agenda</th>
        <th>Kegiatan</th>
        <th>Partner</th>
        <th>Materi</th>
        <th>Hasil</th>
    </tr>
</thead>
<tbody>
    <?php $no=1; ?>
    @foreach ($data as $d)
    <tr>
        <td>{{ $no++ }}</td>
        <td>{{ date('d M Y h:i:s', strtotime($d->tanggal_agenda)) }}</td>
        <td>{{ $d->kegiatan_agenda }}</td>
        <td>{{ $d->partner }}</td>
        <td>{{ $d->materi }}</td>
        <td>{{ $d->hasil_kegiatan }}</td>
    </tr>
    @endforeach
</tbody>
</table>



@endsection
