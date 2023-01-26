@extends('web.layouts.template')

@section('content')
<p>Sudah Pernah Mendaftar? Silakan <a href="{{ route('ppdb2') }}">klik ini untuk melihat detail!</a></p>
<div class="row">
    <div class="col-lg">
        @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
        <div class="card">
            <div class="card-header">
                <h3>Daftar Siswa Baru</h3>
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                <form action="{{ route('kirimbaru') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nisn">NISN</label>
                                <input type="text" class="form-control" name="nisn" value="{{ old('nisn') }}">
                                <div class="text-danger">
                                    @error('nisn')
                                        {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama" value="{{ old('nama') }}">
                                <div class="text-danger">
                                    @error('nama')
                                        {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="jenkel">Jenis Kelamin</label>
                                <select name="jenkel" class="form-control">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="l">Laki-laki</option>
                                    <option value="p">Perempuan</option>
                                </select>
                                <div class="text-danger">
                                    @error('jenkel')
                                        {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ortu">Nama Ayah/Ibu</label>
                                <input type="text" class="form-control" name="ortu" value="{{ old('ortu') }}">
                                <div class="text-danger">
                                    @error('ortu')
                                        {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ttl">Tanggal Lahir</label>
                                <input type="date" class="form-control" name="ttl" value="{{ old('ttl') }}">
                                <div class="text-danger">
                                    @error('ttl')
                                        {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="agama">Agama</label>
                                <select name="agama" class="form-control">
                                    <option value="">Pilih Agama</option>
                                    <option value="islam">Islam</option>
                                    <option value="kristen">Kristen</option>
                                    <option value="hindu">Hindu</option>
                                    <option value="budha">Budha</option>
                                </select>
                                <div class="text-danger">
                                    @error('agama')
                                        {{$message}}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat" cols="30" rows="5" class="form-control"></textarea>
                                <div class="text-danger">
                                    @error('alamat')
                                        {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nohp">No Handphone (WA diutamakan)</label>
                                <input type="text" class="form-control" name="nohp" value="{{ old('nohp') }}">
                                <div class="text-danger">
                                    @error('nohp')
                                        {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="asal_sekolah">Asal Sekolah</label>
                                <input type="text" class="form-control" name="asal_sekolah" value="{{ old('asal_sekolah') }}">
                                <div class="text-danger">
                                    @error('asal_sekolah')
                                        {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="minat">Minat Jurusan : </label>
                                <div class="form-group">
                                     <input type="checkbox" name="minat[]" value="otkp"> OTKP
                                </div>
                                <div class="form-group"><input type="checkbox" name="minat[]" value="rpl"> RPL
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" name="minat[]" value="akl"> AKL
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" name="minat[]" value="bdp"> BDP
                                </div>
                                <div class="text-danger">
                                    @error('minat')
                                        {{$message}}
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <button class="btn btn-primary btn-sm">Kirim</button>
                </form>
              </li>

            </ul>
          </div>
    </div>
</div>





@endsection
