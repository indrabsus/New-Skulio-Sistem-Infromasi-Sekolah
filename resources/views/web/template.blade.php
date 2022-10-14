<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SMK Sangkuriang 1 Cimahi</title>
    <link rel="stylesheet" href={{ asset("assets/css/bootstrap.min.css") }}>
    <link rel="stylesheet" href={{ asset("assets/css/owl.carousel.min.css") }}>
    <link rel="stylesheet" href={{ asset("assets/css/owl.theme.default.min.css") }}>
    <link rel="stylesheet" href={{ asset("assets/fontawesome/css/all.min.css") }}>
    <link rel="stylesheet" href={{ asset("assets/css/style.css") }}>
</head>

<body>

    <section>
        <div id="topbar">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-md-8 col-sm-12">
                        <ul class="top-nav kiri">
                            <li><a href="tel:085773716731"><i class="fas fa-phone"></i> 023-1123456</li></a>
                                <li><a href="admin@smksangkuriang1cimahi.sch.id"><i class="fas fa-envelope"></i>
                                    admin@smksangkuriang1cimahi.sch.id</li></a>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-12">
                        <ul class="top-nav kanan">
                            <li><a href="#"><i class="fab fa-facebook-f"></i></li></a>
                                <li><a href="#"><i class="fab fa-instagram"></i></li></a>
                                    <li><a href="#"><i class="fab fa-youtube"></i></li></a>
                                        <li><a href="#"><i class="fab fa-twitter"></i></li></a>
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
                                <img src={{ asset("assets/img/logo.png") }} alt="Logo" title="Logo" width="80px" style="margin-top: -15px;">
                            </a>
                            <div class="brand-title">
                                <a href="">
                                    <h1>SMK SANGKURIANG 1 CIMAHI</h1>
                                    <h4>SEKOLAH PENCETAK GENERASI TELADAN DAN BERPESTASI</h4>
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
                        <li class="nav-item {{ Route::currentRouteName() === 'dataguru' ? 'active':'' }}">
                            <a class="nav-link" href="{{ route('dataguru') }}">Daftar Guru</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">Daftar Tendik</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">Jadwal Pelajaran</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">Jadwal Lab</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">Jadwal Ekskul</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">Buku Tamu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">Login/Register</a>
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
                            <img src={{ asset("assets/img/logo.png") }} alt="Logo" width="50px">
                            <h1>SMA Negeri 404 Teladan Jogja</h1>
                        </div>
                        <p class="tentang">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.</p>
                        <ul class="sosmed">
                            <li><a href=""><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href=""><i class="fab fa-instagram"></i></a></li>
                            <li><a href=""><i class="fab fa-youtube"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="footer-col">
                        <h2>Kontak Kami</h2>
                        <p class="alamat">Jl. Cuwiri No.10, Pakuncen, Kalasan, Wetanprogo, Daerah Istimewa Yogyakarta 54362
                        </p>
                        <ul class="kontak">
                            <li><i class="fas fa-phone"></i> Telp/Fax : 0234 - 56789 -123</li>
                            <li><i class="fas fa-envelope"></i> Email : humas@teamJogja.com</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-sm-12">
                    <div class="footer-col">
                        <h2>Navigasi</h2>
                        <ul class="footer-nav">
                            <li><a href="">Profil</a></li>
                            <li><a href="">Visi dan Misi</a></li>
                            <li><a href="">Struktur Organisasi</a></li>
                            <li><a href="">Sumber Daya Manusia</a></li>
                            <li><a href="">Pendaftaran PPDB 2020 <span>info</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- .container -->
        <div class="footer-copyright">
            <div class="container text-center">
                <h6>Copyright © 2019 <a href="">yourschool.sch.id</a></h6>
            </div>
        </div>
    </footer>



    <script src={{ asset("assets/js/jquery-3.3.1.slim.min.js") }}></script>
    <script src={{ asset("assets/js/bootstrap.min.js") }}></script>
    <script src={{ asset("assets/js/owl.carousel.min.js") }}></script>
    <script src={{ asset("assets/js/main.js") }}></script>
</body>

</html>
