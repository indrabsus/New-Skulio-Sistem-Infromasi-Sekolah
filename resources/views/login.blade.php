
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Skulio Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('adminv') }}/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('adminv') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('adminv') }}/dist/css/adminlte.min.css">
</head>
<body>
    <div class="container">

    <div class="row">
            <div class="col-lg-6 mt-5">
                <div class="login-box">
                    <div class="login-logo">
                      <a href=""><b>SkuL</b>.IO</a>
                    </div>

                    <!-- /.login-logo -->
                    <div class="card">
                      <div class="card-body login-card-body">
                        <form action="{{ url('proses_login') }}" method="post">
                            @csrf
                          <div class="form-group">
                            <label for="username">Username</label>
                            <input type="username" class="form-control @error('username') is-invalid @enderror" placeholder="Username" name="username" value="{{ old('username') }}">
                            <div class="text-danger">
                                @error('username')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>
                          <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" value="{{ old('password') }}">
                            <div class="text-danger">
                                @error('password')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>
                          <div class="row">
                              <div class="col-8"><p><a href="{{ route('pengumuman') }}">Kembali ke Home</a></p></div>
                            <div class="col-4">
                              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                            </div>
                            <!-- /.col -->
                          </div>
                        </form>


                      </div>
                      <!-- /.login-card-body -->
                    </div>
                  </div>
                  <!-- /.login-box -->

            </div>

            <div class="col-lg-6 mt-5 mb-3">
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
                    <div class="register-logo">
                      <a href=""><b>Register</b>Skulio</a>
                    </div>

                    <div class="card">
                      <div class="card-body register-card-body">
                        <form action="{{ route('proses_register') }}" method="post">
                            @csrf
                          <div class="form-group">
                            <label for="nama_siswa">Nama Siswa</label>
                            <input type="text" class="form-control" placeholder="Full name" name="nama_siswa" value="{{ old('nama_siswa') }}">
                            <div class="text-danger">
                                @error('nama_siswa')
                                    {{$message}}
                                @enderror
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="username">Username</label>
                            <input type="username" class="form-control" placeholder="Username" name="username" value="{{ old('username') }}">
                            <div class="text-danger">
                                @error('username')
                                    {{$message}}
                                @enderror
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" placeholder="Password" name="password" value="{{ old('password') }}">
                            <div class="text-danger">
                                @error('password')
                                    {{$message}}
                                @enderror
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="jk_siswa">Jenis Kelamin</label>
                            <select name="jk_siswa" class="form-control">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="l">Laki-laki</option>
                                <option value="p">Perempuan</option>
                            </select>
                            <div class="text-danger">
                                @error('jk_siswa')
                                    {{$message}}
                                @enderror
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="id_kelas">Kelas</label>
                            <select name="id_kelas" class="form-control" value="{{ old('id_kelas') }}">
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
                          <div class="form-group">
                            <label for="nohp">No Handphone</label>
                            <input type="text" class="form-control" placeholder="No Handphone" name="nohp" value="{{ old('nohp') }}">
                            <div class="text-danger">
                                @error('nohp')
                                    {{$message}}
                                @enderror
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-8">
                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                              <button type="submit" class="btn btn-primary btn-block">Register</button>
                            </div>
                            <!-- /.col -->
                          </div>
                        </form>
                      </div>
                      <!-- /.form-box -->
                    </div><!-- /.card -->
            </div>
    </div>
</div>



<!-- jQuery -->
<script src="{{ asset('adminv') }}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('adminv') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminv') }}/dist/js/adminlte.min.js"></script>
</body>
</html>
