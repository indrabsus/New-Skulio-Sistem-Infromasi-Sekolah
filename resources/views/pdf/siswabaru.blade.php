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
    <span class="test"><center>Struk Pembayaran PPDB</center></span>
    <span class="test"><center>SMK Sangkuriang 1 Cimahi</center></span>
    <table class="table table-sm mt-3">
        <tr>
            <td>NISN</td>
            <td>:</td>
            <td>{{ $data->nisn }}</td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $data->nama }}</td>
        </tr>
        <tr>
            <td>Asal Sekolah</td>
            <td>:</td>
            <td>{{ $data->asal_sekolah }}</td>
        </tr>
        <tr>
            <td>Uang Pendaftaran</td>
            <td>:</td>
            <td>
                @if ($data->daftar == NULL)
                    <span class="text-danger">Belum Bayar</span>
                @else
                    <strong>LUNAS</strong>
                @endif
            </td>
        </tr>
        <tr>
            <td>Uang PPDB</td>
            <td>:</td>
            <td>Rp. {{ number_format($data->cicilan1+$data->cicilan2+$data->cicilan3, 2, ',','.') }}</td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td>@if ($data->cicilan1+$data->cicilan2+$data->cicilan3 == 2250000)
                <strong>TUNTAS</strong>
            @else
                <span class="text-danger">Rp. {{ number_format($data->cicilan1+$data->cicilan2+$data->cicilan3-2250000, 2, ',','.') }}</span>
            @endif</td>
        </tr>
    </table>
    <p class="note"><u>Note : <br> Uang Pendaftaran Rp.150.000 <br> Uang PPDB Rp.2.250.000</u></p>
    <p class="text-right">Cimahi, {{ date('d F Y')}}</p>
    <p class="text-right"><img src="{{ asset('assets/img/qr-code.png') }}" width="50px"> Panitia PPDB</p>
    

</body>
</html>
                
  
