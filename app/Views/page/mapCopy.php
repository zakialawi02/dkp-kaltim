<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title><?= $title; ?></title>
    <!-- Favicon -->
    <link href="/img/favicon.png" rel="icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link href=" https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.css " rel="stylesheet">
    <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css " rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Template Stylesheet -->
    <link href="/css/map.css" rel="stylesheet">

    <!-- Open Layers Component -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v7.4.0/ol.css">

</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->

    <header>
        <div class="logo"><img class="img-fluid navbar-logo me-2" src="/img/logo navbar.png" alt="DINAS KELAUTAN DAN PERIKANAN PROVINSI KALIMANTAN TIMUR" style="max-width: 12rem;"></div>
        <nav>
            <ul>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Cek Kesesuaian
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                        <li id="modalAdd-button"><a class="dropdown-item">Masukkan Koordinat</a></li>
                        <li id="modalAdd-button2"><a class="dropdown-item">Gambar Polygon</a></li>
                    </ul>
                </li>
                <?php if (logged_in()) : ?>
                    <li><a href="/dashboard">Dashboard</a></li>
                    <li><a id="logout-btn">Log Out</a></li>
                    <li><a id="spinners"><span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Logout... </a></li>
                <?php else : ?>
                    <li><a id="login-btn" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a></li>
                <?php endif ?>
            </ul>
        </nav>
        <div class="menu-toggle">
            <i class="bi bi-list"></i>
        </div>
    </header>

    <!-- ISI CONTENT -->
    <!-- spinner -->
    <div id="loading-spinner" class="spinner-container d-flex justify-content-center align-items-center position-fixed top-0 start-0 w-100 h-100 d-none">
        <div class="spinner-border text-light" role="status"></div>
    </div>

    <!-- Modal dialog login-->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="loginModalLabel">Login</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?= view('Myth\Auth\Views\_message_block') ?>
                    <form action="<?= url_to('login') ?>" method="post" name="login">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="login"><?= lang('Auth.emailOrUsername') ?></label>
                            <input type="text" class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" name="login" placeholder="<?= lang('Auth.emailOrUsername') ?>">
                            <div class="invalid-feedback">
                                <?= session('errors.login') ?>
                            </div>
                            <div class="invalid-feedback" id="loginError"></div>
                        </div>
                        <div class="mb-3">
                            <label for="password"><?= lang('Auth.password') ?></label>
                            <input type="password" name="password" class="form-control  <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>" aria-describedby="emailHelp">
                            <div class="invalid-feedback">
                                <?= session('errors.password') ?>
                            </div>
                            <div class="invalid-feedback" id="passwordError"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-check-label">
                                <input type="checkbox" name="remember" class="form-check-input" <?php if (old('remember')) : ?> checked <?php endif ?>>
                                <?= lang('Auth.rememberMe') ?>
                            </label>
                        </div>
                        <div class="form-group">
                            <p class="text-center">Don't have account? <a href="<?= url_to('register') ?>" id="signup">Sign up here</a></p>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col">
                                <button type="submit" id="login-submit" class=" btn btn-block mybtn btn-primary tx-tfm"><?= lang('Auth.loginAction') ?></button>
                                <button id="spinnerss" class="btn btn-primary" type="button" disabled>
                                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Login... </button>
                            </div>
                            <div class="col">
                                <p class="text-center">
                                    <a href="<?= url_to('forgot') ?>" class="google btn mybtn"><?= lang('Auth.forgotYourPassword') ?>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add cek kesesuaian -->
    <div class="modalAdds" id="modalAdd">
        <div class="modalAdd-content">
            <div class="modal-header">
                <h3>Cek Informasi</h3>
                <button class="close-button" id="close-button">&times;</button>
            </div>
            <hr>
            <div class="modalAdd-body">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-3">
                            <div class="step_info">
                                <h4>Masukkan Lokasi</h4>
                                <p>Masukkan X,Y dari lokasi atau alamat lokasi</p>
                                <hr>
                                <p>1. Jika jumlah titik sebanyak satu titik maka geometri akan bertipe titik(point)</p>
                                <p>2. Jika jumlah titik sebanyak dua titik maka geometri akan bertipe garis(line)</p>
                                <p>3. Jika jumlah titik lebih dari dua titik maka geometri akan bertipe poligon(polygon)</p>
                            </div>
                            <div class="preview gap-2">
                                <p>Preview:</p>
                                <div class="previewMap" id="previewMap"><iframe src="/data/petaPreview" id="petaPreview" frameborder="0" width="100%"></iframe></div>
                            </div>
                        </div>
                        <div class="col-sm-9 ">

                            <div class="form_sep pb-3">
                                <label>Berdasar :</label>
                                &nbsp;&nbsp;
                                <div class="col-md-6">
                                    <input type="radio" style="transform: scale(1.4);" name="berdasar" id="rd_file" /> Dengan File &nbsp;&nbsp;&nbsp;&nbsp;
                                </div>
                                <div class="inputByFile d-none">
                                    <div class="mb-3">
                                        <label for="isiByFile" class="form-label">Dengan File</label>
                                        <input type="file" class="form-control file-input" name="isiByFile" id="isiByFile" accept=".kmz,.kml,.topojson,.geojson,.gpx,.xlsx,.xls,.csv" aria-describedby="fileHelpId">
                                        <div id="fileHelpId" class="form-text">Pilih file ...</div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="radio" style="transform: scale(1.4);" name="berdasar" id="rd_dd" checked /> Degree Decimal &nbsp;&nbsp;&nbsp;&nbsp;
                                    </div>
                                    <div class="col-md-6">
                                        <input type="radio" style="transform: scale(1.4);" name="berdasar" id="rd_dms" /> Degree Minute Second
                                    </div>
                                </div>
                            </div>

                            <div class="form_isi_koordinat">
                                <div class="form_sep" id="isi_koordinat">
                                    <div class="ini_koordinat">
                                        <div class="form-group mb-3 pb-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <b>Longitude</b><br>
                                                    <input id="tx_x" value="117.040" type="text" class="form-control dd-input" alt="posisi X">
                                                </div>

                                                <div class="col-md-6">
                                                    <b>Latitude</b><br>
                                                    <input id="tx_y" value="-1.175" type="text" class="form-control dd-input" alt="posisi Y">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="p-3" style="border-top: 1px dotted rgb(130, 130, 130);"></div>

                                        <div class="form-group pb-3">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <b>Longitude</b><br>
                                                    <div class="row">
                                                        <div class="col-md-3" style="padding-right:2px">
                                                            Degree<br>
                                                            <input id="md1_1" disabled value="117" type="text" class="form-control dms-input" alt="posisi X">
                                                        </div>
                                                        <div class="col-md-3" style="padding-left:2px;padding-right:2px">
                                                            Minute<br>
                                                            <input id="md1_2" disabled value="2" type="text" class="form-control dms-input" alt="posisi X">
                                                        </div>
                                                        <div class="col-md-3" style="padding-left:2px;padding-right:2px">
                                                            Second<br>
                                                            <input id="md1_3" disabled value="24" type="text" class="form-control dms-input" alt="posisi X">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <b>Latitude</b><br>
                                                    <div class="row">
                                                        <div class="col-md-3" style="padding-right:2px">
                                                            Degree<br>
                                                            <input id="md2_1" disabled value="-1" type="text" class="form-control dms-input" alt="posisi Y">
                                                        </div>
                                                        <div class="col-md-3" style="padding-left:2px;padding-right:2px">
                                                            Minute<br>
                                                            <input id="md2_2" disabled value="10" type="text" class="form-control dms-input" alt="posisi Y">
                                                        </div>
                                                        <div class="col-md-3" style="padding-left:2px;padding-right:2px">
                                                            Second<br>
                                                            <input id="md2_3" disabled value="32" type="text" class="form-control dms-input" alt="posisi Y">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>
                                        <br>
                                    </div>
                                </div>
                                <div class="gap-2 float-end nav-koordinat">
                                    <span>Jumlah Titik:
                                        <span id="jumlahCounterK">1</span>
                                    </span>
                                    <button type="button" class="btn btn-outline-dark s-btn" id="reset_koordinat" onclick="resetKoordinat()">Reset</button>
                                    <button type="button" class="btn btn-outline-dark s-btn" id="hapus_koordinat" disabled="true" onclick="hapusKoordinat()">- Hapus Titik</button>
                                    <button type="button" class="btn btn-outline-dark s-btn" id="tambah_koordinat" onclick="tambahKoordinat()">+ Tambah Titik</button>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <div class="p-2">
                    <button type="button" class="btn btn-primary m-2" id="next_step">Lanjut</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Add cek kesesuaian 2 -->
    <div class="modalAdds" id="modalCekHasil">
        <div class="modalAdd-content">
            <div class="modal-header">
                <h3>Cek Informasi</h3>
                <button class="close-button" id="close-button2">&times;</button>
            </div>
            <hr>
            <div class="modalAdd-body">
                <div class="card-body">

                    <div class="div_hasilCek" id="div_hasilCek">
                        <img src="/img/loading.gif">
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <div class="p-2">
                </div>
            </div>
        </div>
    </div>

    <div id="button-section-group" class="">
        <div id="button-section" class="float-end m-1">
            <div class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Cek Kesesuaian
                </button>
                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <li id="modalAdd-button"><a class="dropdown-item" type="button" role="button">Masukkan Koordinat</a></li>
                    <li id="modalAdd-button2"><a class="dropdown-item" type="button" role="button">Gambar Polygon</a></li>
                </ul>
            </div>
            <?php if (logged_in()) : ?>
                <a class="btn btn-primary" href="/dashboard" role="button">Dashboard</a>
                <button type="button" id="logout-btn" class="btn btn-primary">Log Out</button>
                <button id="spinners" class="btn btn-primary" type="button" disabled>
                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Logout... </button>
            <?php else : ?>
                <button type="button" id="login-btn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
            <?php endif ?>
        </div>
        <!-- kolom cari -->
        <!-- <div class="search-container float-end">
            <form action="#" method="get">
                <div class="input-group">
                    <input type="text" id="cariMark" class="form-control input-cari" placeholder="Cari...">
                    <span class="input-group-btn">
                        <button type="button" role="button" class="btn btn-primary btn-cari"><i class="bi bi-search"></i></button>
                    </span>
                </div>
            </form>
        </div> -->



    </div>


    <div id="ruler-button" class="ol-control">
        <button><i class="bi bi-rulers"></i></button>
    </div>
    <div class="map" id="map">

    </div>
    <div class="footer-map">
        <p id="mouse-position"></p>
    </div>

    <div class="sidepanel">
        <div class="m-2 p-2">
            <div class="sidepanel-content">

                <div class="accordion" id="accordionPanelsStayOpenExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false" aria-controls="panelsStayOpen-collapseOne">
                                Layer KKPRL
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
                            <div class="accordion-body">

                                <div class="">
                                    <p>Transparansi</p>
                                    <div class="nouislider2" id="transparansi-slider2"></div>
                                </div>
                                <br>
                                <button class="btn btn-outline-dark xs-btn" onclick="centang(1)">Tampilkan Semua</button>
                                <button class="btn btn-outline-dark xs-btn" onclick="centang(0)">Sembunyikan Semua</button>
                                <br><br>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" checked="true" autocomplete="off" name="czona_15" id="czona_15" value="kb" onclick="set_zona(15)"><span style="min-width: 50px; background-image: url('/leaflet/icon/jar minyak.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Jaringan Minyak dan Gas Bumi</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" checked="true" autocomplete="off" name="czona_16" id="czona_16" value="kb" onclick="set_zona(16)"><span style="min-width: 50px; background-image: url('/leaflet/icon/jar telekom.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Jaringan Telekomunikasi</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_0" id="czona_0" value="kb" onclick="set_zona(0)"><span style="min-width: 50px; background-image: url('/leaflet/icon/konservasi.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Kawasan Konservasi Lainnya</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_1" id="czona_1" value="kb" onclick="set_zona(1)"><span style="min-width: 50px; background-image: url('/leaflet/icon/kkm.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Kawasan Konservasi Maritim</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_2" id="czona_2" value="kb" onclick="set_zona(2)"><span style="min-width: 50px; background-image: url('/leaflet/icon/konservasi2.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Pencadangan/Indikasi Kawasan Konservasi</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_3" id="czona_3" value="kb" onclick="set_zona(3)"><span style="min-width: 50px; background-image: url('/leaflet/icon/taman.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Taman</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_4" id="czona_4" value="kb" onclick="set_zona(4)"><span style="min-width: 50px; background-image: url('/leaflet/icon/bandarudara.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Bandar Udara</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_5" id="czona_5" value="kb" onclick="set_zona(5)"><span style="min-width: 50px; background-image: url('/leaflet/icon/industri2.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Industri</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_6" id="czona_6" value="kb" onclick="set_zona(6)"><span style="min-width: 50px; background-image: url('/leaflet/icon/wisata.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Pariwisata</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_7" id="czona_7" value="kb" onclick="set_zona(7)"><span style="min-width: 50px; background-image: url('/leaflet/icon/pelabuhan.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Pelabuhan Perikanan</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_8" id="czona_8" value="kb" onclick="set_zona(8)"><span style="min-width: 50px; background-image: url('/leaflet/icon/pelabuhan2.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Pelabuhan Umum</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_9" id="czona_9" value="kb" onclick="set_zona(9)"><span style="min-width: 50px; background-image: url('/leaflet/icon/dagangan.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Perdagangan Barang dan/atau Jasa</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_10" id="czona_10" value="kb" onclick="set_zona(10)"><span style="min-width: 50px; background-image: url('/leaflet/icon/budidayalaut.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Perikanan Budi Daya</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" checked="true" autocomplete="off" name="czona_11" id="czona_11" value="kb" onclick="set_zona(11)"><span style="min-width: 50px; background-image: url('/leaflet/icon/tangkap.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Perikanan Tangkap</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_12" id="czona_12" value="kb" onclick="set_zona(12)"><span style="min-width: 50px; background-image: url('/leaflet/icon/permukiman.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Permukiman</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_13" id="czona_13" value="kb" onclick="set_zona(13)"><span style="min-width: 50px; background-image: url('/leaflet/icon/pertahanan.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Pertahanan dan Keamanan</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_14" id="czona_14" value="kb" onclick="set_zona(14)"><span style="min-width: 50px; background-image: url('/leaflet/icon/zona tambangan.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Pertambangan Minyak dan Gas Bumi</label>

                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                Layer RZWP3K
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                            <div class="accordion-body">

                                <div class="">
                                    <p>Transparansi</p>
                                    <div class="nouislider" id="transparansi-slider"></div>
                                </div>
                                <br>
                                <button class="btn btn-outline-dark xs-btn" onclick="centang(3)">Tampilkan Semua</button>
                                <button class="btn btn-outline-dark xs-btn" onclick="centang(2)">Sembunyikan Semua</button>
                                <br><br>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_0" id="clahan_0" value="kb" onclick="set_subzona(0)"><span style="min-width: 50px; background-image: url('/leaflet/icon/migrasi.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Alur Migrasi Mamalia Laut</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_1" id="clahan_1" value="kb" onclick="set_subzona(1)"><span style="min-width: 50px; background-image: url('/leaflet/icon/budidayalaut.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Budidaya Laut</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_2" id="clahan_2" value="kb" onclick="set_subzona(2)"><span style="min-width: 50px; background-image: url('/leaflet/icon/dlkrdlkp.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Daerah Lingkungan Kerja (DLKr) & Daerah Lingkungan Kepentingan (DLKp)</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_3" id="clahan_3" value="kb" onclick="set_subzona(3)"><span style="min-width: 50px; background-image: url('/leaflet/icon/demersal.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>Demersal</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_4" id="clahan_4" value="kb" onclick="set_subzona(4)"><span style="min-width: 50px; background-image: url('/leaflet/icon/minyak.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Gas dan Minyak Bumi</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_5" id="clahan_5" value="kb" onclick="set_subzona(5)"><span style="min-width: 50px; background-image: url('/leaflet/icon/kkm.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Kawasan Konservasi Maritim</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_6" id="clahan_6" value="kb" onclick="set_subzona(6)"><span style="min-width: 50px; background-image: url('/leaflet/icon/kkp.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Kawasan Konservasi Perikanan</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_7" id="clahan_7" value="kb" onclick="set_subzona(7)"><span style="min-width: 50px; background-image: url('/leaflet/icon/konservasipesisir.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Kawasan Konservasi </label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_8" id="clahan_8" value="kb" onclick="set_subzona(8)"><span style="min-width: 50px; background-image: url('/leaflet/icon/kabel.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Kabel Telekomunikasi</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_9" id="clahan_9" value="kb" onclick="set_subzona(9)"><span style="min-width: 50px; background-image: url('/leaflet/icon/pelagis.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Pelagis</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_10" id="clahan_10" value="kb" onclick="set_subzona(10)"><span style="min-width: 50px; background-image: url('/leaflet/icon/pelagisdandemersal.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Pelagis dan Demersal</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_11" id="clahan_11" value="kb" onclick="set_subzona(11)"><span style="min-width: 50px; background-image: url('/leaflet/icon/pemukiman.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Permukiman Nelayan </label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_12" id="clahan_12" value="kb" onclick="set_subzona(12)"><span style="min-width: 50px; background-image: url('/leaflet/icon/kabel.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Pipa Minyak dan Gas</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_14" id="clahan_14" value="kb" onclick="set_subzona(14)"><span style="min-width: 50px; background-image: url('/leaflet/icon/wisata.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Taman Wisata Alam Bawah Laut</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_15" id="clahan_15" value="kb" onclick="set_subzona(15)"><span style="min-width: 50px; background-image: url('/leaflet/icon/wkopp.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Wilayah Kerja dan Wilayah Pengoperasian Pelabuhan Perikanan (WKOPP)</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_16" id="clahan_16" value="kb" onclick="set_subzona(16)"><span style="min-width: 50px; background-image: url('/leaflet/icon/wisata.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Wisata Alam Bawah Laut</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_17" id="clahan_17" value="kb" onclick="set_subzona(17)"><span style="min-width: 50px; background-image: url('/leaflet/icon/wisata.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Wisata Pantai/Pesisir dan Pulau-Pulau Kecil</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_18" id="clahan_18" value="kb" onclick="set_subzona(18)"><span style="min-width: 50px; background-image: url('/leaflet/icon/bandarudara.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Bandar Udara</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_19" id="clahan_19" value="kb" onclick="set_subzona(19)"><span style="min-width: 50px; background-image: url('/leaflet/icon/industri.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Industri</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_20" id="clahan_20" value="kb" onclick="set_subzona(20)"><span style="min-width: 50px; background-image: url('/leaflet/icon/Zona_Inti.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Inti</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_21" id="clahan_21" value="kb" onclick="set_subzona(21)"><span style="min-width: 50px; background-image: url('/leaflet/icon/dagangan2.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Jasa/Perdagangan</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_22" id="clahan_22" value="kb" onclick="set_subzona(22)"><span style="min-width: 50px; background-image: url('/leaflet/icon/Zona Lainnya.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Lainnya</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_23" id="clahan_23" value="kb" onclick="set_subzona(23)"><span style="min-width: 50px; background-image: url('/leaflet/icon/Zona Pemanfaatan Terbatas.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Pemanfaatan Terbatas</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_24" id="clahan_24" value="kb" onclick="set_subzona(24)"><span style="min-width: 50px; background-image: url('/leaflet/icon/polred.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Pertahanan dan Keamanan</label>



                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                Peta Dasar
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                            <div class="accordion-body">
                                <!--RADIO 1-->
                                <input type="radio" class="radio_item" value="bingAe" name="item" id="radio1" onclick="set_bing_aerial()">
                                <label class="label_item" for="radio1"> <img src="/leaflet/icon/here_satelliteday.png"> <span>Bing Aerial</span> </label>

                                <!--RADIO 2-->
                                <input type="radio" class="radio_item" value="osm" name="item" id="radio2" onclick="set_osm()" checked>
                                <label class="label_item" for="radio2"> <img src="/leaflet/icon/openstreetmap_mapnik.png"> <span>Open Street Map</span></label>

                                <!--RADIO 2-->
                                <input type="radio" class="radio_item" value="bing" name="item" id="radio3" onclick="set_mapbox_road()">
                                <label class="label_item" for="radio3"> <img src="/leaflet/icon/here_normalday.png"> <span>MapBox</span> </label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="toggle-sidepanel">
            <span>Layer</span>
        </div>
    </div>


    <!-- END ISI CONTENT -->

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.js"></script>
    <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js "></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js"></script>

    <!-- Template Javascript -->
    <!-- <script src="/assets/js/main.js"></script> -->
    <script>
        $(document).ready(function() {
            $(".menu-toggle").click(function() {
                $('nav').toggleClass('active');
            })
        })
    </script>
    <script>
        $(document).ready(function() {
            $("th").css("pointer-events", "none");
            $(".no-sort").css("pointer-events", "none");
        });
    </script>
    <script>
        $('.toggle-sidepanel').click(function() {
            $('.sidepanel').toggleClass('expanded');
        });

        $("#rd_file").click(function() {
            $(".dd-input").prop("disabled", true);
            $(".dms-input").prop("disabled", true);
            $('.form_isi_koordinat').addClass('d-none');
            $('.inputByFile').removeClass('d-none');
        });
        $("#rd_dd").click(function() {
            $(".dd-input").prop("disabled", false);
            $(".dms-input").prop("disabled", true);
            $('.form_isi_koordinat').removeClass('d-none');
            $('.inputByFile').addClass('d-none');
        });
        $("#rd_dms").click(function() {
            $(".dd-input").prop("disabled", true);
            $(".dms-input").prop("disabled", false);
            $('.form_isi_koordinat').removeClass('d-none');
            $('.inputByFile').addClass('d-none');
        });

        var counterK = 1;
        const newKoordinatInput = `
            <div class="form_sep ini_koordinat" id="isi_koordinat">
                                <div class="form-group pb-3">
                                    <div class='row'>
                                        <div class="col-md-6">
                                            Longitude<br>
                                            <input id="tx_x" value="117.040" type="text" class="form-control dd-input" alt="posisi X">
                                        </div>

                                        <div class="col-md-6">
                                            Latitude<br>
                                            <input id="tx_y" value="-1.175" type="text" class="form-control dd-input" alt="posisi Y">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group pb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            Longitude<br>
                                            <div class="row">
                                                <div class='col-md-3' style="padding-right:2px">
                                                    Degree<br>
                                                    <input id="md1_1" disabled value="117" type="text" class="form-control dms-input" alt="posisi X">
                                                </div>
                                                <div class='col-md-3' style="padding-left:2px;padding-right:2px">
                                                    Minute<br>
                                                    <input id="md1_2" disabled value="2" type="text" class="form-control dms-input" alt="posisi X">
                                                </div>
                                                <div class='col-md-3' style="padding-left:2px;padding-right:2px">
                                                    Second<br>
                                                    <input id="md1_3" disabled value="24" type="text" class="form-control dms-input" alt="posisi X">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            Latitude<br>
                                            <div class="row">
                                                <div class='col-md-3' style="padding-right:2px">
                                                    Degree<br>
                                                    <input id="md2_1" disabled value="-1" type="text" class="form-control dms-input" alt="posisi Y">
                                                </div>
                                                <div class='col-md-3' style="padding-left:2px;padding-right:2px">
                                                    Minute<br>
                                                    <input id="md2_2" disabled value="10" type="text" class="form-control dms-input" alt="posisi Y">
                                                </div>
                                                <div class='col-md-3' style="padding-left:2px;padding-right:2px">
                                                    Second<br>
                                                    <input id="md2_3" disabled value="32" type="text" class="form-control dms-input" alt="posisi Y">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <br>
                            </div>
                 `;

        function tambahKoordinat() {
            counterK++;
            $('#jumlahCounterK').html(counterK);
            $('#hapus_koordinat').prop('disabled', false);
            $('.ini_koordinat:last').after(newKoordinatInput);
            if ($('#rd_dd').is(":checked")) {
                $(".dd-input").prop("disabled", false);
                $(".dms-input").prop("disabled", true);
            } else {
                $(".dd-input").prop("disabled", true);
                $(".dms-input").prop("disabled", false);
            }
            if (counterK == 10) {
                $('#tambah_koordinat').prop('disabled', true);
            }
        }

        function hapusKoordinat() {
            counterK--;
            $('#jumlahCounterK').html(counterK);
            if (counterK === 1) {
                $('#hapus_koordinat').prop('disabled', true);
            }
            $('.ini_koordinat:last').remove();
        }

        function resetKoordinat() {
            counterK = 1;
            $('#jumlahCounterK').html(counterK);
            $('#hapus_koordinat').prop('disabled', true);
            $('#tambah_koordinat').prop('disabled', false);
            $('.ini_koordinat').remove('.ini_koordinat');
            $('#isi_koordinat').append(newKoordinatInput);
        }
    </script>

    <?php if (in_groups('Admin' && 'SuperAdmin')) : ?>
        <?php if (session()->getFlashdata('success')) : ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '<?= session()->getFlashdata('success'); ?>',
                    timer: 5000,
                    html: 'Data berhasil ditambahkan,  ' +
                        '<a href="/dashboard">lihat dashboard</a> ',
                });
            </script>
        <?php else : ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '<?= session()->getFlashdata('success'); ?>',
                    timer: 5000,
                    html: 'Menunggu verifikasi, lihat status data anda ' +
                        '<a href="/dashboard">disini</a> ' +
                        ' atau masuk ke dashboard',
                });
            </script>
        <?php endif; ?>
    <?php endif ?>


    <?php if (session()->getFlashdata('error')) : ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?= session()->getFlashdata('error'); ?>',
                timer: 1500,
            });
        </script>
    <?php endif; ?>

    <!-- modalAdd and modalCekHasil-->
    <script>
        const modal = document.getElementById("modalAdd");
        const modal2 = document.getElementById("modalCekHasil");
        // modaladd
        $('#modalAdd-button').click(function(e) {
            $('#modalAdd').show();
        });

        $('#close-button').click(function(e) {
            $('#modalAdd').hide();
        });

        window.addEventListener("click", function(event) {
            if (event.target == modal) {
                $('#modalAdd').hide();
            }
        });

        // modalCekHasil
        $('#modalAdd-button2').click(function(e) {
            startDrawing();
        });

        $('#close-button2').click(function(e) {
            $('#modalCekHasil').hide();
        });
    </script>
    <!-- login/logout -->
    <script>
        $(document).ready(function() {
            $('form[name="login"]').submit(function(event) {
                event.preventDefault(); // prevent default form submit behavior
                $('#loginError').text('');
                $('#passwordError').text('');
                var login = $('input[name="login"]').val().trim();
                var password = $('input[name="password"]').val().trim();
                if (login == '') {
                    $("#loginError").text('Masukkan email/username');
                    if (password == '' || password.length < 4) {
                        $("#passwordError").text('Masukkan password');
                    }
                    return;
                }
                if (password == '' || password.length < 4) {
                    $("#passwordError").text('Masukkan password');
                    return;
                }
                var form = $(this);
                var url = form.attr('action');
                var method = form.attr('method');
                var data = form.serialize();
                $('#login-submit').hide();
                $('#spinnerss').show();
                // AJAX request
                $.ajax({
                    url: url,
                    type: method,
                    data: data,
                    success: function(response) {
                        location.reload();
                        // Swal.fire({
                        //     title: "Login Berhasil!",
                        //     icon: "success",
                        //     showConfirmButton: false,
                        //     timer: 1000
                        // }).then(() => {
                        //     $('.modal').hide();
                        //     $('.modal-backdrop').hide();
                        //     $('#button-section-group').load(location.href + ' #button-section');
                        //     location.reload();
                        // });
                    },
                });
            });

            $('#logout-btn').click(function(e) {
                e.preventDefault();
                $('#logout-btn').hide();
                $('#spinners').show();
                // tunggu 500ms sebelum menjalankan AJAX
                $.ajax({
                    url: "/logout",
                    type: "GET",
                }).done(function() {
                    // $('#spinners').hide();
                    // $('#button-section-group').load(location.href + ' #button-section');
                    // Swal.fire({
                    //     icon: 'success',
                    //     title: 'Berhasil Logout.',
                    //     showConfirmButton: false,
                    //     timer: 1000
                    // }).then(() => {
                    location.reload();
                    // });
                });
            });
        });
    </script>
    <script>
        function cek() {
            $(".info_status").html('<img src="/img/loading.gif">');
            let valKegiatan = $('#pilihKegiatan').val();
            let getOverlap = overlappingFeatures;
            objectID = getOverlap.map(function(feature) {
                return feature.properties.OBJECTID;
            });
            kawasan = getOverlap.map(function(feature) {
                return feature.properties.JNSRPR;
            });
            namaZona = getOverlap.map(function(feature) {
                return feature.properties.NAMOBJ;
            });
            kodeKawasan = getOverlap.map(function(feature) {
                return feature.properties.KODKWS;
            });
            if (objectID != null) {
                objectID = Array.from(new Set(objectID));
                namaZona = Array.from(new Set(namaZona));
                kodeKawasan = Array.from(new Set(kodeKawasan));
                kawasan = Array.from(new Set(kawasan));
            } else {
                objectID = "";
                namaZona = "Maaf, Tidak ada data / Tidak terdeteksi";
                kodeKawasan = "";
                kawasan = "Maaf, Tidak ada data / Tidak terdeteksi";
            }
            let getOverlapProperties = {
                objectID,
                namaZona,
                kodeKawasan,
                kawasan
            }
            $.ajax({
                    method: "POST",
                    url: "/data/cekStatus",
                    data: {
                        valKegiatan,
                        getOverlapProperties
                    },
                    dataType: "json",
                })
                .done(function(response) {
                    console.log(response);
                    let data = response.hasil;
                    data = response.hasil[0];
                    let valZona = response.valZona;
                    console.log(valZona);
                    $("#idZona").val(valZona);
                    if (data != null) {
                        if (data.status == "diperbolehkan") {
                            $(".info_status").html('<p class="boleh">Aktifitas diberbolehkan</p>');
                        } else if (data.status == "diperbolehkan bersyarat") {
                            $(".info_status").html('<p class="bolehBersyarat">Aktifitas diberbolehkan bersyarat</p>');
                        } else {
                            $(".info_status").html('<p class="tidakBoleh">Aktifitas tidak diberbolehkan</p>');
                        }
                    } else {
                        $(".info_status").html('<p class="">No Data</p>');
                    }
                })
                .fail(function(error) {
                    console.error('Error:', error);
                })
        }
    </script>
    <script>
        const opacitySlider = document.getElementById('transparansi-slider');
        noUiSlider.create(opacitySlider, {
            start: [0.8],
            range: {
                'min': 0,
                'max': 1,
            },
            step: 0.01,
        });
        const opacitySlider2 = document.getElementById('transparansi-slider2');
        noUiSlider.create(opacitySlider2, {
            start: [0.8],
            range: {
                'min': 0,
                'max': 1,
            },
            step: 0.01,
        });
    </script>


    <!-- Open Layers Component -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.5.0/proj4.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/ol@v7.4.0/dist/ol.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/elm-pep@1.0.6/dist/elm-pep.js"></script>
    <script src="https://api.tiles.mapbox.com/mapbox.js/plugins/turf/v2.0.0/turf.min.js"></script>
    <script src="/leaflet/catiline.js"></script>
    <script src="https://unpkg.com/shpjs@latest/dist/shp.js"></script>
    <script src="/leaflet/turf.min.js"></script>

    <script type="text/javascript">
        <?php foreach ($tampilData as $D) : ?>
            <?php $koordinat = $D->coordinat_wilayah ?>
            <?php $zoomView = $D->zoom_view ?>
            <?php $splitKoordinat = explode(', ', $koordinat) ?>
            <?php $lon = $splitKoordinat[0] ?>
            <?php $lat = $splitKoordinat[1] ?>
        <?php endforeach ?>

        proj4.defs("EPSG:32750", "+proj=utm +zone=50 +south +datum=WGS84 +units=m +no_defs +type=crs");
        proj4.defs("EPSG:4326", "+proj=longlat +datum=WGS84 +no_defs +type=crs");

        var drawInteraction;
        var drawedVector;
        var styleDraw;
        var wkt;
        var coordinates;
        var jsonCoordinates;
        var geojsonFeature;
        var overlappingFeatures
        const KKPRL_Layer = [];
        const RZWP3K_Layer = [];


        const vectorSource = new ol.source.Vector();
        const KKPRLALLsource = new ol.source.TileWMS({
            url: 'https://simatalautkaltim.id/geoserver/KKPRL/wms',
            params: {
                'LAYERS': 'KKPRL:KKPRL_RTRW_KALTIM_10_03_2023_AR_FIX',
                'TILED': true
            },
            serverType: 'geoserver',
            crossOrigin: 'anonymous'
        });
        const RZWP3KALLsource = new ol.source.TileWMS({
            url: 'https://simatalautkaltim.id/geoserver/RZWP3K/wms',
            params: {
                'LAYERS': 'RZWP3K:RZ50K_AR_REVISIMAR_2021_FIX_29_Maret',
                'TILED': true
            },
            serverType: 'geoserver',
            crossOrigin: 'anonymous'
        });
        const projection = new ol.proj.Projection({
            code: 'EPSG:32750',
            units: 'm',
            axisOrientation: 'neu'
        });
        ol.proj.addProjection(projection);

        // BaseMap
        const osmBaseMap = new ol.layer.Tile({
            source: new ol.source.OSM(),
            crossOrigin: 'anonymous',
            visible: false,
        });

        const sourceBingMaps = new ol.source.BingMaps({
            key: 'AjQ2yJ1-i-j_WMmtyTrjaZz-3WdMb2Leh_mxe9-YBNKk_mz1cjRC7-8ILM7WUVEu',
            imagerySet: 'AerialWithLabels',
            maxZoom: 20,
        });
        const bingAerialBaseMap = new ol.layer.Tile({
            preload: Infinity,
            source: sourceBingMaps,
            crossOrigin: 'anonymous',
            visible: true,
        });

        const mapboxBaseURL = 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiNjg2MzUzMyIsImEiOiJjbDh4NDExZW0wMXZsM3ZwODR1eDB0ajY0In0.6jHWxwN6YfLftuCFHaa1zw';
        const mapboxStyleId = 'mapbox/streets-v11';
        const mapboxSource = new ol.source.XYZ({
            url: mapboxBaseURL.replace('{id}', mapboxStyleId),
        });
        const mapboxBaseMap = new ol.layer.Tile({
            source: mapboxSource,
            crossOrigin: 'anonymous',
            visible: false,
        });

        const baseMaps = [osmBaseMap, bingAerialBaseMap, mapboxBaseMap];

        function set_bing_aerial() {
            bingAerialBaseMap.setVisible(true);
            osmBaseMap.setVisible(false);
            mapboxBaseMap.setVisible(false);
        }

        function set_osm() {
            bingAerialBaseMap.setVisible(false);
            osmBaseMap.setVisible(true);
            mapboxBaseMap.setVisible(false);
        }

        function set_mapbox_road() {
            bingAerialBaseMap.setVisible(false);
            osmBaseMap.setVisible(false);
            mapboxBaseMap.setVisible(true);
        }

        // Init To Canvas/View
        const view = new ol.View({
            center: ol.proj.fromLonLat([<?= $lat; ?>, <?= $lon; ?>]),
            zoom: <?= $zoomView; ?>,
            Projection: projection
        });
        const viewMini = new ol.View({
            center: ol.proj.fromLonLat([<?= $lat; ?>, <?= $lon; ?>]),
            zoom: <?= $zoomView - 3; ?>,
        });
        var attribution = new ol.control.Attribution({
            collapsible: true,
        });
        const map = new ol.Map({
            layers: [
                new ol.layer.Group({
                    layers: baseMaps,
                }),
            ],
            target: 'map',
            controls: [
                new ol.control.Zoom(),
                new ol.control.ScaleLine(),

            ],
            view: view,
        });
        const mainMap = map;
        // map.addLayer(bingAerialBaseMap);
        // map.addLayer(wms_layer);

        // Membuat array lapisan WMS dari GeoServer
        const RZWP3KLayerNames = [
            'Alur_Migrasi_Mamalia_Laut',
            'Budidaya_Laut',
            'DLKr-DLKp',
            'Demersal',
            'Gas_dan_Minyak_Bumi',
            'KKM',
            'KKP',
            'KKP3K',
            'Kabel_Telekomunikasi',
            'Pelagis',
            'Pelagis_dan_Demersal',
            'Permukiman_Nelayan',
            'Pipa_Minyak_dan_Gas',
            'Taman_Wisata_Alam_Laut',
            'WKOPP',
            'Wisata_Alam_Bawah_Laut',
            'Wisata_Pantai_Pesisir_dan_Pulau-Pulau_Kecil',
            'Zona_Bandar_Udara',
            'Zona_Industri',
            'Zona_Inti',
            'Zona_Jasa__Perdagangan',
            'Zona_Lainnya',
            'Zona_Pemanfaatan_Terbatas',
            'Zona_Pertahanan_dan_Keamanan',
        ];
        const KKPRLLayerNames = [
            'Kawasan_Konservasi_Lainnya',
            'Kawasan_Konservasi_Maritim',
            'Pencadangan_Indikasi_Kawasan_Konservasi',
            'Taman',
            'Zona_Bandar_Udara',
            'Zona_Industri',
            'Zona_Pariwisata',
            'Zona_Pelabuhan_Perikanan',
            'Zona_Pelabuhan_Umum',
            'Zona_Perdagangan_Barang_dan_atau_Jasa',
            'Zona_Perikanan_Budi_Daya',
            'Zona_Perikanan_Tangkap',
            'Zona_Permukiman',
            'Zona_Pertahanan_dan_Keamanan',
            'Zona_Pertambangan_Minyak_dan_Gas_Bumi',
            'Sistem_Jaringan_Energi',
            'Sistem_Jaringan_Telekomunikasi',
            'Alur_Migrasi_Mamalia',
            'Alur_Migrasi_Penyu',
        ];
        const layersToShow = ['Zona_Perikanan_Tangkap', 'Sistem_Jaringan_Energi', 'Sistem_Jaringan_Telekomunikasi', 'Alur_Migrasi_Mamalia', 'Alur_Migrasi_Penyu'];
        // Loop untuk menambahkan setiap lapisan WMS ke dalam objek peta
        for (const layerName of RZWP3KLayerNames) {
            const wmsSource = new ol.source.TileWMS({
                url: 'https://simatalautkaltim.id/geoserver/RZWP3K/wms?',
                params: {
                    'LAYERS': `RZWP3K:${layerName}`,
                    'TILED': true,
                    'FORMAT': 'image/png',
                },
                serverType: 'geoserver',
                crossOrigin: 'anonymous',
            });
            var wms_layer = new ol.layer.Tile({
                source: wmsSource,
                visible: layersToShow.includes(layerName),
                opacity: 0.8
            });
            map.addLayer(wms_layer);
            RZWP3K_Layer.push(wms_layer);
        }

        for (const layerName of KKPRLLayerNames) {
            const wmsSource = new ol.source.TileWMS({
                url: 'https://simatalautkaltim.id/geoserver/KKPRL/wms?',
                params: {
                    'LAYERS': `KKPRL:${layerName}`,
                    'TILED': true,
                    'FORMAT': 'image/png',
                },
                serverType: 'geoserver',
                crossOrigin: 'anonymous',
            });
            var wms_layer = new ol.layer.Tile({
                source: wmsSource,
                visible: layersToShow.includes(layerName),
                opacity: 0.8
            });
            map.addLayer(wms_layer);
            KKPRL_Layer.push(wms_layer);
        }

        const overviewMapControl = new ol.control.OverviewMap({
            view: viewMini,
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM(),
                }),
            ],
        });
        map.addControl(overviewMapControl);
        map.addControl(attribution);

        set_osm();


        // Fungsi untuk menyembunyikan atau menampilkan lapisan WMS (per checkbox)
        function toggleWMSLayer(layerName, visibility) {
            const layers = map.getLayers();
            layers.forEach(layer => {
                if (layer instanceof ol.layer.Tile && layer.getSource() instanceof ol.source.TileWMS) {
                    const params = layer.getSource().getParams();
                    if (params.LAYERS === `RZWP3K:${layerName}`) {
                        layer.setVisible(visibility);
                    } else if (params.LAYERS === `KKPRL:${layerName}`) {
                        layer.setVisible(visibility);
                    }
                }
            });
        }

        function set_subzona(index) {
            const checkbox = document.getElementById(`clahan_${index}`);
            const layerName = RZWP3KLayerNames[index];
            const visibility = checkbox.checked;
            toggleWMSLayer(layerName, visibility);
        }

        function set_zona(index) {
            const checkbox = document.getElementById(`czona_${index}`);
            const layerName = KKPRLLayerNames[index];
            const visibility = checkbox.checked;
            toggleWMSLayer(layerName, visibility);
        }

        // Fungsi untuk mengubah transparansi lapisan WMS
        function updateWMSTransparency(opacity, wms) {
            if (wms == "RZWP3K_Layer") {
                RZWP3K_Layer.forEach(RZWP3K_Layer => {
                    RZWP3K_Layer.setOpacity(opacity);
                });
            } else {
                KKPRL_Layer.forEach(KKPRL_Layer => {
                    KKPRL_Layer.setOpacity(opacity);
                });
            }
        }
        opacitySlider.noUiSlider.on('update', function(values, handle) {
            wms = "RZWP3K_Layer";
            const opacity = parseFloat(values[handle]);
            updateWMSTransparency(opacity, wms);
        });
        opacitySlider2.noUiSlider.on('update', function(values, handle) {
            wms = "KKPRL_Layer";
            const opacity = parseFloat(values[handle]);
            updateWMSTransparency(opacity, wms);
        });

        // Fungsi check all/uncheck (show/hide all) layer wms
        function centang(cons) {
            if (cons == 1) {
                for (var i = 0; i < KKPRL_Layer.length; i++) {
                    $('#czona_' + i).prop('checked', true);
                    KKPRL_Layer[i].setVisible(true);
                }
            } else if (cons == 0) {
                for (var i = 0; i < KKPRL_Layer.length; i++) {
                    $('#czona_' + i).prop('checked', false);
                    KKPRL_Layer[i].setVisible(false);
                }
            } else if (cons == 3) {
                for (var i = 0; i < RZWP3K_Layer.length; i++) {
                    $('#clahan_' + i).prop('checked', true);
                    RZWP3K_Layer[i].setVisible(true);
                }
            } else if (cons == 2) {
                for (var i = 0; i < RZWP3K_Layer.length; i++) {
                    $('#clahan_' + i).prop('checked', false);
                    RZWP3K_Layer[i].setVisible(false);
                }
            }
        }

        // style vector geometry
        const markerStyle = new ol.style.Style({
            image: new ol.style.Icon({
                anchor: [0.5, 1],
                anchorXUnits: 'fraction',
                anchorYUnits: 'fraction',
                opacity: 1,
                src: '/leaflet/images/marker-icon.png'
            })
        });
        const lineStyle = new ol.style.Style({
            stroke: new ol.style.Stroke({
                color: 'red',
                width: 2,
            }),
        });
        const polygonStyle = new ol.style.Style({
            fill: new ol.style.Fill({
                color: 'rgba(255, 0, 0, 0.4)',
            }),
            stroke: new ol.style.Stroke({
                color: 'red',
                width: 2,
            }),
        });

        function modalLoading() {
            $("#div_hasilCek").html('<img src="/img/loading.gif">');
            $('#modalCekHasil').show();
        }

        // function cekHasil(lon, lat, url) {

        //     ue = encodeURIComponent(url);
        //     if (url) {
        //         var act = '/data/cekData?lon=' + lon + '&lat=' + lat + '&ue=' + ue;
        //         $.ajax({
        //             url: act,
        //             success: function(data) {
        //                 $('#div_hasilCek').html(data);
        //             },
        //             error: function(error) {
        //                 console.error('Error:', error);
        //             }
        //         });
        //     }
        // }

        function kirim() {
            // let valueKegiatan = $("#pilihKegiatan").val();
            let geojson = geojsonFeature;
            let getOverlap = overlappingFeatures;
            $("#geojson").val(JSON.stringify(geojson));
            $("#getOverlap").val(JSON.stringify(getOverlap));
        }

        function cekHasil(id, kawasan, name, kode, orde, remark, geojson) {
            var act = "/data/cekData";
            $.ajax({
                url: act,
                method: "POST",
                data: {
                    id,
                    kawasan,
                    name,
                    kode,
                    orde,
                    remark,
                    geojsonFeature,
                },
                dataType: "html",
            }).done(function(response) {
                // console.log(response);
                $("#div_hasilCek").html(response);
            }).fail(function(error) {
                console.error("Error: ", error);
            });
        }

        function prosesDetectInput(drawn, type = "polygon", geojson) {
            modalLoading();
            overlappingFeatures = [];
            if (type == "point") {
                try {
                    geoshp.features.forEach(function(layer) {
                        var shapefileGeoJSON = layer;
                        // console.log(shapefileGeoJSON);
                        var geojsonFeature = turf.point(drawn);
                        // console.log(geojsonFeature);
                        var shapefilePoly = turf.polygon(shapefileGeoJSON.geometry.coordinates);
                        // console.log(shapefilePoly);
                        var inside = turf.booleanPointInPolygon(geojsonFeature, shapefilePoly);
                        if (inside) {
                            console.log('Overlap detected!');
                            var overlappingFeature = {
                                geometry: shapefileGeoJSON.geometry,
                                properties: shapefileGeoJSON.properties,
                            };
                            // Tambahkan data ke dalam array overlappingFeatures
                            overlappingFeatures.push(overlappingFeature);
                        }
                    });
                } catch (error) {
                    alert("Terjadi Kesalahan, Mohon Reload Browser");
                }
            } else if (type == "line") {
                try {
                    geoshp.features.forEach(function(layer) {
                        var shapefileGeoJSON = layer;
                        // console.log(shapefileGeoJSON);
                        var geojsonFeature = turf.lineString(drawn);
                        // console.log(geojsonFeature);
                        var shapefilePoly = turf.polygon(shapefileGeoJSON.geometry.coordinates);
                        // console.log(shapefilePoly);
                        var intersect = turf.booleanIntersects(geojsonFeature, shapefilePoly);
                        if (intersect) {
                            console.log('Overlap detected!');
                            var overlappingFeature = {
                                geometry: shapefileGeoJSON.geometry,
                                properties: shapefileGeoJSON.properties,
                            };
                            // Tambahkan data ke dalam array overlappingFeatures
                            overlappingFeatures.push(overlappingFeature);
                        }
                    });
                } catch (error) {
                    alert("Terjadi Kesalahan, Mohon Reload Browser");
                }
            } else { //polygon
                try {
                    geoshp.features.forEach(function(layer) {
                        var shapefileGeoJSON = layer;
                        // console.log(shapefileGeoJSON);
                        var geojsonFeature = turf.polygon(drawn);
                        // console.log(geojsonFeature);
                        var shapefilePoly = turf.polygon(shapefileGeoJSON.geometry.coordinates);
                        // console.log(shapefilePoly);
                        var overlap = turf.booleanOverlap(geojsonFeature, shapefilePoly);
                        var within = turf.booleanWithin(geojsonFeature, shapefilePoly);
                        if (overlap || within) {
                            console.log('Overlap detected!');
                            var overlappingFeature = {
                                geometry: shapefileGeoJSON.geometry,
                                properties: shapefileGeoJSON.properties,
                            };
                            // Tambahkan data ke dalam array overlappingFeatures
                            overlappingFeatures.push(overlappingFeature);
                        }
                    });
                } catch (error) {
                    alert("Terjadi Kesalahan, Mohon Reload Browser");
                }
            }
            console.log(

            );
            var overlappingID = overlappingFeatures.map(function(feature) {
                return feature.properties.OBJECTID;
            });
            var overlappingKawasan = overlappingFeatures.map(function(feature) {
                return feature.properties.JNSRPR;
            });
            var overlappingObject = overlappingFeatures.map(function(feature) {
                return feature.properties.NAMOBJ;
            });
            var overlappingKode = overlappingFeatures.map(function(feature) {
                return feature.properties.KODKWS;
            });
            var overlappingOrde = overlappingFeatures.map(function(feature) {
                return feature.properties.ORDE01;
            });
            var overlappingRemark = overlappingFeatures.map(function(feature) {
                return feature.properties.REMARK;
            });
            cekHasil(overlappingID, overlappingKawasan, overlappingObject, overlappingKode, overlappingOrde, overlappingRemark, geojson);
        }

        // klik lanjut
        $('#next_step').click(function() {
            coordinates = [];
            jsonCoordinates = [];
            geojsonFeature = [];
            const selectedCounter = counterK;
            // console.log('Nilai CounterK: ', selectedCounter);
            // Ambil nilai koordinat
            $('.ini_koordinat').each(function() {
                const longitudeInput = parseFloat($(this).find('#tx_x').val());
                const latitudeInput = parseFloat($(this).find('#tx_y').val());
                if ($('#rd_dms').is(":checked")) {
                    const degree1 = $(this).find('#md1_1').val();
                    const minute1 = $(this).find('#md1_2').val();
                    const second1 = $(this).find('#md1_3').val();
                    const degree2 = $(this).find('#md2_1').val();
                    const minute2 = $(this).find('#md2_2').val();
                    const second2 = $(this).find('#md2_3').val();
                    longitude = parseFloat(degree1) + parseFloat(minute1 / 60) + parseFloat(second1 / 3600);
                    latitude = parseFloat(degree2) - parseFloat(minute2 / 60) - parseFloat(second2 / 3600);
                    coordinates.push([longitude + ' ' + latitude]);
                    jsonCoordinates.push([longitude, latitude]);
                } else if ($('#rd_dd').is(":checked")) {
                    coordinates.push([longitudeInput + ' ' + latitudeInput]);
                    jsonCoordinates.push([longitudeInput, latitudeInput]);
                }

            });
            console.log(jsonCoordinates);
            // console.log('Nilai Koordinat:', coordinates);
            vectorSource.clear();
            var format = new ol.format.WKT();
            if (counterK < 2) {
                var wkt = 'POINT (' + coordinates + ')';
                geojsonFeature = turf.point([jsonCoordinates[0][0], jsonCoordinates[0][1]]);
                styleDraw = markerStyle;
            } else if (counterK > 2) {
                var wkt = 'POLYGON ((' + coordinates + ',' + coordinates[0] + '))';
                jsonCoordinates.push(jsonCoordinates[0]);
                geojsonFeature = turf.polygon([jsonCoordinates]);
                styleDraw = polygonStyle;
            } else {
                var wkt = 'LINESTRING (' + coordinates + ')';
                geojsonFeature = turf.lineString(jsonCoordinates);
                styleDraw = lineStyle;
            }
            // console.log(geojsonFeature);
            var feature = format.readFeature(wkt, {
                dataProjection: 'EPSG:4326',
                featureProjection: 'EPSG:3857'
            });
            var drawedVector = new ol.layer.Vector({
                source: vectorSource,
                style: styleDraw,
            });
            vectorSource.addFeature(feature);
            map.addLayer(drawedVector);
            var extent = drawedVector.getSource().getExtent();
            map.getView().fit(extent, {
                padding: [100, 100, 100, 100],
                minResolution: map.getView().getResolutionForZoom(13),
            });

            if (counterK < 2) {
                // const viewResolution = view.getResolution();
                // var coordinates3857 = jsonCoordinates.map(coordinate => ol.proj.transform(coordinate, 'EPSG:4326', 'EPSG:3857'));
                // var url = KKPRLALLsource.getFeatureInfoUrl(coordinates3857[0], viewResolution, 'EPSG:3857', {
                //     'INFO_FORMAT': 'application/json',
                //     FEATURE_COUNT: 1
                // });
                // var lon = coordinates3857[0][0];
                // var lat = coordinates3857[0][1];
                // modalLoading();
                // cekHasil(lon, lat, url);
                prosesDetectInput(jsonCoordinates[0], "point", geojsonFeature);
            } else if (counterK > 2) {
                prosesDetectInput([jsonCoordinates], "polygon", geojsonFeature);
            } else {
                prosesDetectInput(jsonCoordinates, "line", geojsonFeature);
            }


        });

        $('#isi_koordinat').keyup(function(e) {

            coordinates = [];
            jsonCoordinates = [];
            geojsonFeature = [];
            const selectedCounter = counterK;
            // console.log('Nilai CounterK: ', selectedCounter);
            // Ambil nilai koordinat
            $('.ini_koordinat').each(function() {
                const longitudeInput = parseFloat($(this).find('#tx_x').val());
                const latitudeInput = parseFloat($(this).find('#tx_y').val());
                if ($('#rd_dms').is(":checked")) {
                    const degree1 = $(this).find('#md1_1').val();
                    const minute1 = $(this).find('#md1_2').val();
                    const second1 = $(this).find('#md1_3').val();
                    const degree2 = $(this).find('#md2_1').val();
                    const minute2 = $(this).find('#md2_2').val();
                    const second2 = $(this).find('#md2_3').val();
                    longitude = parseFloat(degree1) + parseFloat(minute1 / 60) + parseFloat(second1 / 3600);
                    latitude = parseFloat(degree2) - parseFloat(minute2 / 60) - parseFloat(second2 / 3600);
                    coordinates.push([longitude + ' ' + latitude]);
                    jsonCoordinates.push([longitude, latitude]);
                } else if ($('#rd_dd').is(":checked")) {
                    coordinates.push([longitudeInput + ' ' + latitudeInput]);
                    jsonCoordinates.push([longitudeInput, latitudeInput]);
                }
            });
            const iframe = document.getElementById("petaPreview");
            iframe.contentWindow.postMessage({
                jsonCoordinates,
                selectedCounter,
            }, '<?= base_url('/data/petaPreview'); ?>');
        });

        // Fungsi untuk memulai penggambaran
        function startDrawing() {
            if (drawInteraction) {
                map.removeInteraction(drawInteraction);
            }
            map.getViewport().style.cursor = "crosshair"
            vectorSource.clear();
            var drawedVector = new ol.layer.Vector({
                source: vectorSource,
                style: polygonStyle,
            });
            drawInteraction = new ol.interaction.Draw({
                source: new ol.source.Vector(),
                type: 'Polygon'
            });
            drawInteraction.on('drawend', function(event) {
                var drawnFeature = event.feature;
                jsonCoordinates = drawnFeature.getGeometry().getCoordinates();
                // console.log('Koordinat polygon yang digambar:', jsonCoordinates);
                var polygonFeature = new ol.Feature({
                    geometry: new ol.geom.Polygon(jsonCoordinates)
                });
                vectorSource.addFeature(polygonFeature);
                map.removeInteraction(drawInteraction);


                jsonCoordinates = drawnFeature.getGeometry();
                jsonCoordinates.transform('EPSG:3857', 'EPSG:4326');
                jsonCoordinates = jsonCoordinates.getCoordinates();
                // console.log('Koordinat polygon yang digambar:', jsonCoordinates);
                geojsonFeature = turf.polygon(jsonCoordinates);
                map.getViewport().style.cursor = "grab"
                prosesDetectInput(jsonCoordinates, "polygon", geojsonFeature);
            });
            map.addInteraction(drawInteraction);
            map.addLayer(drawedVector);
        }



        let geoshp;
        // // Membaca dan memproses file shapefile
        // // shp('<?= base_url('/geojson/KKPRL_RTRW.zip'); ?> ').then(function(geojson) {
        // shp('http://localhost:8080/geojson/KKPRL_RTRW.zip').then(function(data) {
        //     geoshp = data;
        //     console.log(geoshp);
        //     addTogeoshp(geoshp);

        //     var format = new ol.format.GeoJSON();
        //     var features = format.readFeatures(geoshp);
        //     features.forEach(function(feature) {
        //         feature.getGeometry().transform('EPSG:4326', 'EPSG:3857');
        //     });

        //     var vectorSource = new ol.source.Vector({
        //         features: features
        //     });
        //     var vectorLayer = new ol.layer.Vector({
        //         source: vectorSource,
        //         style: polygonStyle
        //     });
        //     map.addLayer(vectorLayer);
        // }).catch(function(error) {
        //     console.error("Error processing shapefile:", error);
        // });

        // function addTogeoshp(data) {
        //     console.log("Var Global:", data);
        // }

        try {
            var wfunc = function(base, cb) {
                importScripts('https://unpkg.com/shpjs@latest/dist/shp.js');
                shp(base).then(cb);
            }
            var worker = cw({
                data: wfunc
            }, 2);
            worker.data(cw.makeUrl('/geojson/KKPRL_RTRW_KALTIM_10_03_2023_AR_FIX_EXPLODE.zip')).then(function(data) {
                geoshp = data;
                console.log("Var Global:", data);
            }, function(a) {
                console.log(a)
            });
        } catch (error) {
            console.log(`error: ${error}`);
        }



        // map.on('singleclick', function(evt) {
        //     const viewResolution = view.getResolution();
        //     const coordinate = evt.coordinate;
        //     const projection = view.getProjection();
        //     console.log(coordinate);
        //     console.log(projection);
        //     KKPRL_Layer.forEach(layer => {
        //         const url = layer.getSource().getFeatureInfoUrl(
        //             coordinate,
        //             viewResolution,
        //             projection, {
        //                 INFO_FORMAT: 'application/json',
        //                 FEATURE_COUNT: 1
        //             }
        //         );

        //         if (url) {
        //             fetch(url)
        //                 .then(response => response.json())
        //                 .then(data => {
        //                     // Di sini Anda dapat memanipulasi data respons JSON
        //                     // untuk mengambil atribut yang Anda butuhkan.

        //                     if (data.features.length > 0) {
        //                         console.log(data); // Tampilkan data JSON di konsol
        //                         const attributes = data.features[0].properties;
        //                         console.log(attributes); // Tampilkan atribut fitur di konsol
        //                     }
        //                 })
        //         }
        //     });
        // });

        // mouse coordinate show
        const mousePositionControl = new ol.control.MousePosition({
            coordinateFormat: ol.coordinate.createStringXY(6),
            projection: 'EPSG:4326',
            // comment the following two lines to have the mouse position
            // be placed within the map.
            className: 'custom-mouse-position',
            target: document.getElementById('mouse-position'),
        });
        map.addControl(mousePositionControl);


        // Buat tombol kontrol
        var rulerControl = new ol.control.Control({
            element: document.getElementById('ruler-button'), // ID elemen tombol
        });
        map.addControl(rulerControl);
        $(rulerControl.element).click(function(e) {
            e.preventDefault();
            alert('Tombol belum siap');
        });


        $('#isiByFile').change(function(e) {
            var selectedCounter;
            const file = e.target.files[0];
            const reader = new FileReader();
            jsonCoordinates = [];
            vectorSource.clear();
            const readFile = new Promise((resolve, reject) => {
                reader.onload = function(event) {
                    const fileName = file.name;
                    const getExtension = fileName.split('.').pop();
                    if (getExtension == 'xlsx' || getExtension == 'xls' || getExtension == 'csv') {
                        const data = new Uint8Array(event.target.result);
                        const workbook = XLSX.read(data, {
                            type: 'array'
                        });
                        const firstSheetName = workbook.SheetNames[0];
                        const worksheet = workbook.Sheets[firstSheetName];
                        const json = XLSX.utils.sheet_to_json(worksheet, {
                            header: 1
                        });
                        var dataArr = [json][0];
                        dataArr.shift();
                        selectedCounter = dataArr.length;
                        if (selectedCounter < 2) {
                            jsonCoordinates = [dataArr[0].slice(1, 3)];
                            var pointFeature = new ol.Feature({
                                geometry: new ol.geom.Point(ol.proj.fromLonLat(jsonCoordinates[0]))
                            });
                            vectorSource.addFeature(pointFeature);
                            styleDraw = markerStyle;
                        } else {
                            dataArr.push(dataArr[0]);
                            for (let index = 0; index < dataArr.length; index++) {
                                var coord = dataArr[index].slice(1, 3);
                                jsonCoordinates.push(coord);
                            }
                            var polygonFeature = new ol.Feature({
                                geometry: new ol.geom.Polygon([jsonCoordinates.map(coordinate => ol.proj.transform(coordinate, 'EPSG:4326', 'EPSG:3857'))])
                            });
                            vectorSource.addFeature(polygonFeature);
                            styleDraw = polygonStyle;
                        }
                        const iframe = document.getElementById("petaPreview");
                        iframe.contentWindow.postMessage({
                            jsonCoordinates,
                            selectedCounter,
                        }, '<?= base_url('/data/petaPreview'); ?>');
                    } else {
                        alert("File Belum Support");




                    }
                    resolve(); // Selesaikan Promise saat selesai membaca file.
                };

                if (file) {
                    reader.readAsArrayBuffer(file);
                } else {
                    alert("Gagal!")
                    reject(new Error("File not found"));
                }
            });

            readFile.then(() => {
                var drawedVector = new ol.layer.Vector({
                    source: vectorSource,
                    style: styleDraw,
                });
                map.addLayer(drawedVector);

            }).catch(error => {
                console.error('Error:', error);
            });
        });
    </script>

    <!-- <script>
        var poly1 = turf.polygon([
        [
        [0, 0],
        [0, 5],
        [5, 5],
        [5, 0],
        [0, 0]
        ]
        ]);
        var poly2 = turf.polygon([
        [
        [1, 1],
        [1, 6],
        [6, 6],
        [6, 1],
        [1, 1]
        ]
        ]);
        var poly3 = turf.polygon([
        [
        [10, 10],
        [10, 15],
        [15, 15],
        [15, 10],
        [10, 10]
        ]
        ]);
        console.log(turf.booleanOverlap(poly1, poly2));
        console.log(turf.booleanOverlap(poly2, poly3));
    </script> -->

    <!-- <script>
        var a = "Pipa Minyak dan Gas";
        var b = "Kabel Telekomunikasi";
        var c = "Pipa Minyak dan Gas";
        var x = a === b;
        var z = a === c;
        console.log(x);
        console.log(z);
    </script> -->

</body>

</html>