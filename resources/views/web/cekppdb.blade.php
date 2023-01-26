@extends('web.layouts.template')

@section('content')

<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-8">
            @if (isset($data->nisn))
        <div class="card">
            <div class="card-header">Detail Siswa Baru</div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <td>NISN</td>
                        <td>{{ $data->nisn }}</td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>{{ $data->nama }}</td>
                    </tr>
                    <tr>
                        <td>Asal Sekolah</td>
                        <td>{{ $data->asal_sekolah }}</td>
                    </tr>
                    <tr>
                        <td>Uang Pendaftaran</td>
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
                        <td>Rp. {{ number_format($data->cicilan1+$data->cicilan2+$data->cicilan3, 2, ',','.') }}</td>
                    </tr>
                    <tr>
                        <td>Keterangan</td>
                        <td>@if ($data->cicilan1+$data->cicilan2+$data->cicilan3 == 2250000)
                            <strong>TUNTAS</strong>
                        @else
                            <span class="text-danger">Rp. {{ number_format($data->cicilan1+$data->cicilan2+$data->cicilan3-2250000, 2, ',','.') }}</span>
                        @endif</td>
                    </tr>
                </table>
                <hr>
                <i>Note : Uang pendaftaran <strong>Rp.150.000</strong> dan Uang PPDB <strong>Rp.2250.000</strong></i>
            </div>
        </div>
        
    @else
    <div class="row justify-content-md-center">
    <div class="col col-md-auto"><h3>Data tidak ditemukan</h3></div>
    </div>
    @endif
        </div>
    </div>
    <div class="row justify-content-md-center mt-3">
        <div class="col col-auto">
            <a href="{{ route('ppdb2') }}">Kembali ke Cek PPDB</a>
        </div>
    </div>
    
</div>





@endsection
