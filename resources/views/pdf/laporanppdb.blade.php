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
    <title>Struk Pembayaran PPDB</title>
</head>
<body>
    <span class="test"><center>Laporan Harian PPDB</center></span>
    <span class="test"><center>SMK Sangkuriang 1 Cimahi</center></span>
    <table class="table table-bordered mt-3">
        <tr>
            <th>No</th>
            <th>NISN</th>
            <th>Nama</th>
            <th>Jenis</th>
            <th>Jumlah</th>
        </tr>
        @php
            $no = 1;
        @endphp
        @foreach ($data as $d)
        <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->nisn }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->jenis }}</td>
                <td>Rp. {{ number_format($d->jumlah,2,',','.') }}</td>
            
        </tr>
        @endforeach
    </table>
    <p>Total Pendapatan Hari ini : Rp. {{ number_format($total,2,',','.') }}</p>
    <p class="text-right">Cimahi, {{ date('d F Y', strtotime($tanggal))}}</p>
    <p class="text-right"><img src="{{ asset('assets/img/qr-code.png') }}" width="50px"> Panitia PPDB</p>
    

</body>
</html>
                
  
