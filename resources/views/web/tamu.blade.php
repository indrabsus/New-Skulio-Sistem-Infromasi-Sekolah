@extends('web.layouts.template')

@section('content')

<div class="row">
    <div class="col-lg-5">
        <img src="assets/img/logo.png" width="300px" class="rounded float-left mt-5">
    </div>
    <div class="col-lg-6">
        @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
        <div class="card">
            <div class="card-header">
                <h3>Penerima Tamu</h3>
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                <form action="{{ route('kirimtamu') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" name="nama" value="{{ old('nama') }}">
                        <div class="text-danger">
                            @error('nama')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="instansi">Instansi</label>
                        <input type="text" class="form-control" name="instansi" value="{{ old('instansi') }}">
                        <div class="text-danger">
                            @error('instansi')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nohp">No Handphone</label>
                        <input type="text" class="form-control" name="nohp" value="{{ old('nohp') }}">
                        <div class="text-danger">
                            @error('nohp')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email (jika ada)</label>
                        <input type="text" class="form-control" name="email" value="{{ old('email') }}">
                    </div>
                    <div class="form-group">
                        <label for="keperluan">Keperluan</label>
                        <input type="text" class="form-control" name="keperluan" value="{{ old('keperluan') }}">
                        <div class="text-danger">
                            @error('keperluan')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="divisi">Manajemen yang dituju</label>
                        <select name="divisi" class="form-control">
                            <option value="">Silakan Masukan Tujuan</option>
                            <option value="tu">Tata Usaha</option>
                            <option value="humas">Humas</option>
                            <option value="kesiswaan">Kesiswaan</option>
                            <option value="kurikulum">Kurikulum</option>
                            <option value="sarpras">Sarana Prasarana</option>
                            <option value="wmm">Wakil Manajemen Mutu</option>
                            <option value="kepsek">Kepala Sekolah</option>
                        </select>
                        <div class="text-danger">
                            @error('divisi')
                                {{$message}}
                            @enderror
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
