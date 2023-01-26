@if (Auth::user()->level != 'admin')
<script>window.location = "{{ route('index') }}";</script>
@endif

@extends('layouts.admin.app')

@section('content')
@if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
<div>
    <h2 class="mb-3">Config Web</h2>
    <form action="{{ route('prosesConfig') }}" method="post" enctype='multipart/form-data'>
        @csrf
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="npsn">NPSN</label>
                    <input type="text" class="form-control" value="{{ $data->npsn }}" name="npsn" disabled>
                    <div class="text-danger">
                        @error('npsn')
                            {{$message}}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="notel">No Telepon</label>
                    <input type="text" class="form-control" value="{{ $data->notel }}" name="notel">
                    <div class="text-danger">
                        @error('notel')
                            {{$message}}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" value="{{ $data->email }}" name="email">
                    <div class="text-danger">
                        @error('email')
                            {{$message}}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="fb">Link Facebook</label>
                    <input type="text" class="form-control" value="{{ $data->fb }}" name="fb">
                    <div class="text-danger">
                        @error('fb')
                            {{$message}}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="ig">Link Instagram</label>
                    <input type="text" class="form-control" value="{{ $data->ig }}" name="ig">
                    <div class="text-danger">
                        @error('ig')
                            {{$message}}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="yt">Link Youtube</label>
                    <input type="text" class="form-control" value="{{ $data->yt }}" name="yt">
                    <div class="text-danger">
                        @error('yt')
                            {{$message}}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="nama_sekolah">Nama Sekolah</label>
                    <input type="text" class="form-control" value="{{ $data->nama_sekolah }}" name="nama_sekolah">
                    <div class="text-danger">
                        @error('nama_sekolah')
                            {{$message}}
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" class="form-control" value="{{ $data->alamat }}" name="alamat">
                    <div class="text-danger">
                        @error('alamat')
                            {{$message}}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="yt_video">Video Youtube</label>
                    <textarea class="form-control" name="yt_video">{{ $data->yt_video }}</textarea>
                    <div class="text-danger">
                        @error('yt_video')
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="url">Url Footer</label>
                    <input type="text" class="form-control" value="{{ $data->url }}" name="url">
                    <div class="text-danger">
                        @error('url')
                            {{$message}}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="token_telegram">Token Telegram</label>
                    <input type="text" class="form-control" value="{{ $data->token_telegram }}" name="token_telegram">
                    <div class="text-danger">
                        @error('token_telegram')
                            {{$message}}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="chat_admin">Chat ID Admin</label>
                    <input type="text" class="form-control" value="{{ $data->chat_admin }}" name="chat_admin">
                    <div class="text-danger">
                        @error('chat_admin')
                            {{$message}}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="desk_singkat">Deskripsi Singkat</label>
                    <input type="text" class="form-control" value="{{ $data->desk_singkat }}" name="desk_singkat">
                    <div class="text-danger">
                        @error('desk_singkat')
                            {{$message}}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="desk_panjang">Deskripsi Lengkap</label>
                    <textarea class="form-control" name="desk_panjang">{{ $data->desk_panjang }}</textarea>
                    <div class="text-danger">
                        @error('desk_panjang')
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="logo">Logo</label>
                    <p><img src="{{ asset(Config::get('public')) }}{{ $data->logo }}" width="100px"></p>

                    <form>
                        <div class="form-group">
                          <label for="exampleFormControlFile1">Upload Logo Sekolah</label>
                          <input type="file" class="form-control-file" id="exampleFormControlFile1" name="logo">
                        </div>
                      </form>
                </div>

                <div class="form-group">
                    <label for="sambutan">Sambutan Kepsek</label>
                    <textarea class="form-control" name="sambutan">{{ $data->sambutan }}</textarea>
                    <div class="text-danger">
                        @error('sambutan')
                        @enderror
                    </div>
                </div>
            </div>
            <button class="btn btn-primary btn-block" type="submit">Update</button>
        </div>
    </form>
</div>


@endsection
