@extends('web.layouts.template')

@section('content')



<table class="display" id="table_id">
    <thead>
    <tr>
        <th>No</th>
        <th>Nama Kegiatan</th>
        <th>Tempat</th>
        <th>Waktu</th>
    </tr>
</thead>
<tbody>
    <?php $no=1; ?>
    @foreach ($data as $d)
    <tr>
        <td>{{ $no++ }}</td>
        <td>{{ $d->nama_kegiatan }} @if ($d->pengirim !== NULL)
            dikirim oleh {{ $d->pengirim }}
        @endif</td>
        <td>{{ $d->tempat_kegiatan }}</td>
        <td>{{ \Carbon\Carbon::parse(date($d->waktu_kegiatan))->translatedFormat('l, d F Y h:i') }}</td>

    </tr>
    @endforeach
</tbody>
</table>



@endsection
