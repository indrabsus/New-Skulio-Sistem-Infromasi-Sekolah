<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>{{ $title }}</title>
  </head>
  <body>
    <h3 class="text-center">Laporan Absen Guru</h3>
    <h3 class="text-center">SMK Sangkuriang 1 Cimahi</h3>
    <hr>
    <p>Bulan : {{ $bulan }}</p>
    <table class="table table-bordered table-striped">
        <tr>
                <th>Kode</th>
                <th>Nama Guru</th>
                <th>Hadir</th>
                <th>Kegiatan</th>
                <th>BDR</th>
                <th>Sakit</th>
                <th>Izin</th>
                <th>Libur</th>
                <th>Total</th>
                <th>Persentase</th>
        </tr>
        @foreach ($data as $d)
            <tr>
                <td>{{ $d->kode_guru }}</td>
                <<td>{{ $d->nama_guru }}</td>
                <td>{{ $d->hadir }}</td>
                <td>{{ $d->kegiatan }}</td>
                <td>{{ $d->bdr }}</td>
                <td>{{ $d->sakit }}</td>
                <td>{{ $d->izin }}</td>
                <td>{{ $d->nojadwal }}</td>
                <td>{{ $d->total_absen }}</td>
                <td>{{ ($d->total_absen/$max)*100 }} %</td>
            </tr>
        @endforeach
    </table>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    -->
  </body>
</html>
