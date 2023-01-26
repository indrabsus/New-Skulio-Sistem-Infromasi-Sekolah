<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href={{ asset("assets/css/bootstrap.min.css") }}>
    <style>
        .test {
            font-size: 20px;
            font-weight: bold;
        }
        .note {
            font-style: italic;
            float: left;
            font-size: 12px;
        }
    </style>
    <title>Data Kelas {{ $kelas }}</title>
</head>
<body>
    <span class="test"><center>Data Kelas {{ $kelas }}</center></span>
    <span class="test"><center>SMK Sangkuriang 1 Cimahi</center></span>
    <table class="table table-bordered mt-3">
        <tr>
            <th>No</th>
            <th>NISN</th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>No Map</th>
        </tr>
        @php
            $no = 1;
        @endphp
        @foreach ($data as $d)
        <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->nisn }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->jenkel == 'l' ? 'Laki-laki' : 'Perempuan' }}</td>
                <td>{{ $d->no_urut }}</td>
            
        </tr>
        @endforeach
    </table>
    <p>Jumlah siswa : {{ $jumlah }}</p>
    <p>Laki-laki : {{ $laki }}</p>
    <p>Perempuan : {{ $perempuan }}</p>
    

</body>
</html>
                
  
