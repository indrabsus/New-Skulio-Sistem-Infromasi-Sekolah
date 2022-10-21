<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ Config::get('data.nama_sekolah') }}</title>
    <link rel="stylesheet" href={{ asset("assets/css/bootstrap.min.css") }}>
    <link rel="stylesheet" href={{ asset("assets/css/owl.carousel.min.css") }}>
    <link rel="stylesheet" href={{ asset("assets/css/owl.theme.default.min.css") }}>
    <link rel="stylesheet" href={{ asset("assets/fontawesome/css/all.min.css") }}>
    <link rel="stylesheet" href={{ asset("assets/css/style.css") }}>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">



</head>

<body>

    <section>
        <div id="topbar">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-md-8 col-sm-12">
                        <ul class="top-nav kiri">
                            <li><a href="tel:{{ Config::get('data.notel') }}"><i class="fas fa-phone"></i> {{ Config::get('data.notel') }}</li></a>
                                <li><a href="{{ Config::get('data.email') }}"><i class="fas fa-envelope"></i>
                                    {{ Config::get('data.email') }}</li></a>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-12">
                        <ul class="top-nav kanan">
                                <li><a href="{{ Config::get('data.ig') }}"><i class="fab fa-instagram"></i></li></a>
                                    <li><a href="{{ Config::get('data.yt') }}"><i class="fab fa-youtube"></i></li></a>
                                    <li><a href="{{ route('loginui') }}" >Login</li></a>
                        </ul>
                    </div>
                </div>
                <!-- .row -->
            </div>
            <!-- .container -->
        </div>
        <!-- #topbar -->
    </section>

    <header>
        <div id="head">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="brand">
                            <a href="index.html">
                                <img src={{ asset(Config::get('public')) }}{{ Config::get('data.logo') }} alt="Logo" title="Logo" width="80px" style="margin-top: -10px;">
                            </a>
                            <div class="brand-title">
                                <a href="">
                                    <h1>{{ Config::get('data.nama_sekolah') }}</h1>
                                    <h4>{{ Config::get('data.desk_singkat') }}</h4>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 searchbox">
                        <!-- /.login-box -->


                    </div>
                </div>
            </div>
        </div>

        <!-- menu -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <!-- <a class="navbar-brand">Brand</a> -->
                <button class="navbar-toggler" data-target="#my-nav" data-toggle="collapse" aria-controls="my-nav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="fa fa-bars"></span> Menu
                </button>
                <div id="my-nav" class="collapse navbar-collapse">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item {{ Route::currentRouteName() === 'pengumuman' ? 'active':'' }}">
                            <a class="nav-link" href="{{ route('pengumuman') }}">Kegiatan</a>
                        </li>
                        <li class="nav-item dropdown {{ Route::currentRouteName() === 'dataguru' ||  Route::currentRouteName() === 'datatendik' ||  Route::currentRouteName() === 'datamapel' ||  Route::currentRouteName() === 'datakelas' ||  Route::currentRouteName() === 'datasiswa'? 'active':'' }}">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Data Sekolah
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('dataguru') }}">Data Guru</a>
                                <a class="dropdown-item" href="{{ route('datatendik') }}">Data Tendik</a>
                                <a class="dropdown-item" href="{{ route('datamapel') }}">Data Mapel</a>
                                <a class="dropdown-item" href="{{ route('datasiswa') }}">Data Siswa</a>
                                <a class="dropdown-item" href="{{ route('datakelas') }}">Data Kelas</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown {{ Route::currentRouteName() === 'datajadwal' || Route::currentRouteName() === 'datalabkom' ? 'active':''}}">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Data Jadwal
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('datajadwal') }}">Jadwal Pelajaran</a>
                                <a class="dropdown-item" href="{{ route('datalabkom') }}">Jadwal Lab Komputer</a>
                                {{-- <a class="dropdown-item" href="#">Jadwal Ekskul</a> --}}
                            </div>
                        </li>
                        <li class="nav-item dropdown {{ Route::currentRouteName() === 'kepsekagenda' || Route::currentRouteName() === 'kurikulumagenda' || Route::currentRouteName() === 'kesiswaanagenda' || Route::currentRouteName() === 'humasagenda' || Route::currentRouteName() === 'sarprasagenda' || Route::currentRouteName() === 'mutuagenda'? 'active':''}}">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Manajemen
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('kepsekagenda') }}">Kepala Sekolah</a>
                                <a class="dropdown-item" href="{{ route('kurikulumagenda') }}">Kurikulum</a>
                                <a class="dropdown-item" href="{{ route('kesiswaanagenda') }}">Kesiswaan</a>
                                <a class="dropdown-item" href="{{ route('humasagenda') }}">Humas Hubin</a>
                                <a class="dropdown-item" href="{{ route('sarprasagenda') }}">Sarana Prasarana</a>
                                <a class="dropdown-item" href="{{ route('mutuagenda') }}">Wakil Manajemen Mutu</a>
                            </div>
                        </li>

                        <li class="nav-item {{ Route::currentRouteName() === 'bukutamu' ?'active':''}}">
                            <a class="nav-link" href="{{ route('bukutamu') }}">Buku Tamu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">PPDB Online</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <section id="sambutan">
        <div class="container">
            @yield('content')
        </div>
        <!-- .container -->
    </section>
    <!-- #sambutan -->

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <div class="footer-col">
                        <div class="brand">
                            <img src={{ asset(Config::get('public')) }}{{ Config::get('data.logo') }} alt="Logo" width="50px">
                            <h1>{{ Config::get('data.nama_sekolah') }}</h1>
                        </div>
                        <p class="tentang">{{ Config::get('data.desk_panjang') }}</p>
                        <ul class="sosmed">
                            <li><a href="{{ Config::get('data.fb') }}"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="{{ Config::get('data.ig') }}"><i class="fab fa-instagram"></i></a></li>
                            <li><a href="{{ Config::get('data.yt') }}"><i class="fab fa-youtube"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="footer-col">
                        <h2>Kontak Kami</h2>
                        <p class="alamat">{{ Config::get('data.alamat') }}
                        </p>
                        <ul class="kontak">
                            <li><i class="fas fa-phone"></i> Telp : {{ Config::get('data.notel') }}</li>
                            <li><i class="fas fa-envelope"></i> Email : {{ Config::get('data.email') }}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-sm-12">
                    <div class="footer-col">
                        <h2>Navigasi</h2>
                        <ul class="footer-nav">
                            <li><a href="{{ route('pengumuman') }}">Kegiatan</a></li>
                            <li><a href="{{ route('dataguru') }}">Daftar Guru</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- .container -->
        <div class="footer-copyright">
            <div class="container text-center">
                <h6>Copyright © {{ date('Y',strtotime(now())) }} <a href="{{ Config::get('data.url') }}">{{ Config::get('data.nama_sekolah') }}</a></h6>
            </div>
        </div>
    </footer>



    <script src="https://code.jquery.com/jquery-3.6.1.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script src={{ asset("assets/js/bootstrap.min.js") }}></script>
    <script src={{ asset("assets/js/owl.carousel.min.js") }}></script>
    <script src={{ asset("assets/js/main.js") }}></script>
    <script>
        $(document).ready( function () {
    $('#table_id').DataTable();
} );
    </script>
</body>

</html>
