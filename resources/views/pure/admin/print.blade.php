@if (strpos(Config::get('piket'), Auth::user()->level) === false)
<script>window.location = "{{ route('index') }}";</script>
@endif

@extends('layouts.admin.app')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('printdataguru') }}" method="POST">
            @csrf
            <h3>Print Data Guru</h3>
        <div class="form-group">
            <button class="btn btn-primary btn-sm">Download</button>
        </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('printdatasiswa') }}" method="POST">
            @csrf
            <h3>Print Data Siswa</h3>
        <div class="form-group">
            <div class="col-lg-6">
                <select name="id_kelas" class="form-control">
                    <option value="">Pilih Kelas</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
                <div class="text-danger">
                    @error('id_kelas')
                        {{$message}}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-primary btn-sm">Download</button>
        </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('printjadwal') }}" method="POST">
            @csrf
            <h3>Print Data Jadwal</h3>
        <div class="form-group">
            <div class="col-lg-6">
                <select name="hari" class="form-control">
                    <option value="">Hari</option>
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                </select>
                <div class="text-danger">
                    @error('hari')
                        {{$message}}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-primary btn-sm">Download</button>
        </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('printagendamanajerial') }}" method="POST">
            @csrf
            <h3>Print Agenda Manajerial</h3>
        <div class="form-group">
            <div class="col-lg-6">
                <select name="level" class="form-control">
                    <option value="">Pilih Divisi</option>
                    <option value="kepsek">Kepsek</option>
                    <option value="mutu">Manajemen Mutu</option>
                    <option value="kurikulum">kurikulum</option>
                    <option value="kesiswaan">Kesiswaan</option>
                    <option value="sarpras">Sarana Prasarana</option>
                    <option value="humas">Humas Hubin</option>
                    <option value="perpus">Koordinator Perpustakaan</option>
                    <option value="konseling">Koordinator BP/BK</option>
                    <option value="otkp">Kajur OTKP</option>
                    <option value="akl">Kajur AKL</option>
                    <option value="rpl">Kajur RPL</option>
                    <option value="bdp">Kajur BDP</option>
                    <option value="kasubag">Tata Usaha</option>
                </select>
                <div class="text-danger">
                    @error('level')
                        {{$message}}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-primary btn-sm">Download</button>
        </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('printdatabos') }}" method="POST">
            @csrf
            <h3>Print Rekapan Pemasukan/Pengeluaran BOS</h3>
        <div class="form-group">
            <div class="col-lg-6">
                <select name="laporan" class="form-control">
                    <option value="">Pilih Keterangan</option>
                    <option value="credit">Pemasukan</option>
                    <option value="debit">Pengeluaran</option>
                </select>
                <div class="text-danger">
                    @error('laporan')
                        {{$message}}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-primary btn-sm">Download</button>
        </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('printdatasarpras') }}" method="POST">
            @csrf
            <h3>Print Inventaris Barang Sekolah</h3>
        <div class="form-group">
            <div class="col-lg-6">
                <input type="month" name="bulan" class="form-control">
                <div class="text-danger">
                    @error('bulan')
                        {{$message}}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-primary btn-sm">Download</button>
        </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('printdatacatatan') }}" method="POST">
            @csrf
            <h3>Print Catatan Siswa</h3>
            <div class="form-group">
                <div class="col-lg-6">
                    <select name="id_kelas" class="form-control">
                        <option value="">Pilih Kelas</option>
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('id_kelas')
                            {{$message}}
                        @enderror
                    </div>
                </div>
            </div>
        <div class="form-group">
            <button class="btn btn-primary btn-sm">Download</button>
        </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('printdataabsenguru') }}" method="POST">
            @csrf
            <h3>Print Absen Guru</h3>
            <div class="form-group">
                <div class="col-lg-6">
                    <input type="month" name="bulan" class="form-control">
                    <div class="text-danger">
                        @error('bulan')
                            {{$message}}
                        @enderror
                    </div>
                </div>
            </div>
        <div class="form-group">
            <button class="btn btn-primary btn-sm">Download</button>
        </div>
        </form>
    </div>
</div>
@endsection
