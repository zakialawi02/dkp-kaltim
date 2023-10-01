<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta content="Simata Laut, Sistem Informasi Tata Ruang Laut, Dinas Kelautan dan Perikanan" name="keywords">
    <meta content="Aplikasi Simata Laut Kaltim (Sistem Informasi Tata Ruang Laut Kaltim) Dinas Kelautan dan Perikanan Provinsi Kalimantan Timur." name="description">


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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v8.1.0/ol.css">

</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->

    <header>
        <div class="logo"><a href="/"><img class="img-fluid navbar-logo me-2" src="/img/logo navbar.png" alt="DINAS KELAUTAN DAN PERIKANAN PROVINSI KALIMANTAN TIMUR" style="max-width: 12rem;"></a>
        </div>
        <nav>
            <ul>
                <li><a href="/" class="nav-link bi bi-house-door-fill">Beranda</a></li>
                <li class="nav-item dropdown ">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Cek Kesesuaian
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDarkDropdownMenuLink">
                        <li id="modalAdd-button"><a class="dropdown-item nav-link">Masukkan Koordinat</a></li>
                        <li id="modalAdd-button2"><a class="dropdown-item nav-link">Gambar Polygon</a></li>
                    </ul>
                </li>
                <?php if (logged_in()) : ?>
                    <li><a href="/dashboard" class="nav-link"> Dashboard</a></li>
                    <li><a id="logout-btn" href="/logout" class="nav-link bi bi-box-arrow-right"> Log Out</a></li>
                <?php else : ?>
                    <li><a id="login-btn" class="nav-link bi bi-box-arrow-in-right" data-bs-toggle="modal" data-bs-target="#loginModal"> Login</a></li>
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
                            <p class="text-center">Belum punya akun? <a href="<?= url_to('register') ?>" id="signup">Daftar disini</a></p>
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
                                        <input type="file" class="form-control file-input" name="isiByFile" id="isiByFile" accept=".zip,.kmz,.topojson,.xlsx,.xls,.csv" aria-describedby="fileHelpId">
                                        <div id="fileHelpId" class="form-text">Pilih file csv, xlsx, shp(zip), kml</div>
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
                    <button type="button" class="btn btn-primary m-2 d-none" id="next_step_byFile">Lanjut</button>
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




    </div>


    <div id="ruler-button" class="ol-control">
        <button><i class="bi bi-rulers" title="Ukur Area"></i></button>
    </div>
    <div class="map" id="map">
        <div id="measurement-tip"></div>

    </div>
    <div class="footer-map">
        <p id="copyright"> © Dinas Kelautan Dan Perikanan Provinsi Kalimantan Timur </p>
        <div id="mouse-position"></div>
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

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" checked autocomplete="off" name="czona_15" id="czona_15" value="kb" onclick="set_zona(15)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/jar minyak.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Jaringan Minyak dan Gas Bumi</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" checked autocomplete="off" name="czona_16" id="czona_16" value="kb" onclick="set_zona(16)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/jar telekom.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Jaringan Telekomunikasi</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_17" id="czona_17" value="kb" onclick="set_zona(17)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/mamaliaa.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Alur Migrasi Mamalia Laut</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_18" id="czona_18" value="kb" onclick="set_zona(18)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/penyu.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Alur Mingrasi Penyu</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" checked autocomplete="off" name="czona_19" id="czona_19" value="kb" onclick="set_zona(19)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/pelayaran3.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Alur Pelayaran Umum dan Perlintasan</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" checked autocomplete="off" name="czona_20" id="czona_20" value="kb" onclick="set_zona(20)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/lintas.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Lintas Penyeberangan Antar Provinsi</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" checked autocomplete="off" name="czona_21" id="czona_21" value="kb" onclick="set_zona(21)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/lintas2.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Lintas Penyeberangan Antar Kabupaten/Kota dalam Provinsi</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_0" id="czona_0" value="kb" onclick="set_zona(0)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/konservasi.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Kawasan Konservasi Lainnya</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_1" id="czona_1" value="kb" onclick="set_zona(1)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/kkm.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Kawasan Konservasi Maritim</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_2" id="czona_2" value="kb" onclick="set_zona(2)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/konservasi2.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Pencadangan/Indikasi Kawasan Konservasi</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_3" id="czona_3" value="kb" onclick="set_zona(3)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/taman.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Taman</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_4" id="czona_4" value="kb" onclick="set_zona(4)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/bandarudara.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Bandar Udara</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_5" id="czona_5" value="kb" onclick="set_zona(5)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/industri2.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Industri</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_6" id="czona_6" value="kb" onclick="set_zona(6)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/wisata.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Pariwisata</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_7" id="czona_7" value="kb" onclick="set_zona(7)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/pelabuhan.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Pelabuhan Perikanan</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" checked autocomplete="off" name="czona_8" id="czona_8" value="kb" onclick="set_zona(8)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/pelabuhan2.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Pelabuhan Umum</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_9" id="czona_9" value="kb" onclick="set_zona(9)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/dagangan.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Perdagangan Barang dan/atau Jasa</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_10" id="czona_10" value="kb" onclick="set_zona(10)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/budidayalaut.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Perikanan Budi Daya</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_11" id="czona_11" value="kb" onclick="set_zona(11)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/tangkap.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Perikanan Tangkap</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_12" id="czona_12" value="kb" onclick="set_zona(12)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/permukiman.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Permukiman</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_13" id="czona_13" value="kb" onclick="set_zona(13)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/pertahanan.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Pertahanan dan Keamanan</label>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_14" id="czona_14" value="kb" onclick="set_zona(14)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/zona tambangan.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Pertambangan Minyak dan Gas Bumi</label>

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

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_0" id="clahan_0" value="kb" onclick="set_subzona(0)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/budidayalaut.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Budidaya Laut</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_1" id="clahan_1" value="kb" onclick="set_subzona(1)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/dlkrdlkp.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Daerah Lingkungan Kerja (DLKr) & Daerah Lingkungan Kepentingan (DLKp)</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_2" id="clahan_2" value="kb" onclick="set_subzona(2)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/demersal.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>Demersal</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_3" id="clahan_3" value="kb" onclick="set_subzona(3)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/minyak.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Gas dan Minyak Bumi</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_4" id="clahan_4" value="kb" onclick="set_subzona(4)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/kkm.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Kawasan Konservasi Maritim</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_5" id="clahan_5" value="kb" onclick="set_subzona(5)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/kkp.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Kawasan Konservasi Perikanan</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_6" id="clahan_6" value="kb" onclick="set_subzona(6)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/konservasipesisir.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Kawasan Konservasi </label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_7" id="clahan_7" value="kb" onclick="set_subzona(7)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/kabel.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Kabel Telekomunikasi</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_8" id="clahan_8" value="kb" onclick="set_subzona(8)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/pelagis.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Pelagis</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_9" id="clahan_9" value="kb" onclick="set_subzona(9)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/pelagisdandemersal.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Pelagis dan Demersal</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_10" id="clahan_10" value="kb" onclick="set_subzona(10)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/pemukiman.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Permukiman Nelayan </label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_11" id="clahan_11" value="kb" onclick="set_subzona(11)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/kabel.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Pipa Minyak dan Gas</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_12" id="clahan_12" value="kb" onclick="set_subzona(12)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/wisata.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Taman Wisata Alam Bawah Laut</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_13" id="clahan_13" value="kb" onclick="set_subzona(13)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/wkopp.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Wilayah Kerja dan Wilayah Pengoperasian Pelabuhan Perikanan (WKOPP)</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_14" id="clahan_14" value="kb" onclick="set_subzona(14)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/wisata.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Wisata Alam Bawah Laut</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_15" id="clahan_15" value="kb" onclick="set_subzona(15)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/wisata.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Wisata Pantai/Pesisir dan Pulau-Pulau Kecil</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_16" id="clahan_16" value="kb" onclick="set_subzona(16)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/bandarudara.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Bandar Udara</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_17" id="clahan_17" value="kb" onclick="set_subzona(17)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/industri.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Industri</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_18" id="clahan_18" value="kb" onclick="set_subzona(18)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/Zona_Inti.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Inti</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_19" id="clahan_19" value="kb" onclick="set_subzona(19)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/dagangan2.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Jasa/Perdagangan</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_20" id="clahan_20" value="kb" onclick="set_subzona(20)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/Zona Lainnya.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Lainnya</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_22" id="clahan_22" value="kb" onclick="set_subzona(22)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/Zona Pemanfaatan Terbatas.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Pemanfaatan Terbatas</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="clahan_21" id="clahan_21" value="kb" onclick="set_subzona(21)"><span style="min-width: 50px; background-image: url('/mapSystem/icon/polred.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Pertahanan dan Keamanan</label>



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
                                <label class="label_item" for="radio1"> <img src="/mapSystem/icon/here_satelliteday.png"> <span>Bing Aerial</span> </label>

                                <!--RADIO 2-->
                                <input type="radio" class="radio_item" value="osm" name="item" id="radio2" onclick="set_osm()" checked>
                                <label class="label_item" for="radio2"> <img src="/mapSystem/icon/openstreetmap_mapnik.png"> <span>Open Street Map</span></label>

                                <!--RADIO 2-->
                                <input type="radio" class="radio_item" value="bing" name="item" id="radio3" onclick="set_mapbox_road()">
                                <label class="label_item" for="radio3"> <img src="/mapSystem/icon/here_normalday.png"> <span>MapBox</span> </label>
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
            $('#next_step_byFile').removeClass('d-none');
            $('#next_step').addClass('d-none');
        });
        $("#rd_dd").click(function() {
            $(".dd-input").prop("disabled", false);
            $(".dms-input").prop("disabled", true);
            $('.form_isi_koordinat').removeClass('d-none');
            $('.inputByFile').addClass('d-none');
            $('#next_step_byFile').addClass('d-none');
            $('#next_step').removeClass('d-none');
        });
        $("#rd_dms").click(function() {
            $(".dd-input").prop("disabled", true);
            $(".dms-input").prop("disabled", false);
            $('.form_isi_koordinat').removeClass('d-none');
            $('.inputByFile').addClass('d-none');
            $('#next_step_byFile').addClass('d-none');
            $('#next_step').removeClass('d-none');
        });

        let counterK = 1;
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
            if (counterK == 20) { //set maksimal jumlah titik
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

    <!-- modalAdd and modalCekHasil-->
    <script>
        const modal = document.getElementById("modalAdd");
        const modal2 = document.getElementById("modalCekHasil");
        // modaladd
        $('#modalAdd-button').click(function(e) {
            $('#modalAdd').show();
            $('nav').toggleClass('active');
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
            $('nav').toggleClass('active');
        });

        $('#close-button2').click(function(e) {
            $('#modalCekHasil').hide();
        });
    </script>
    <!-- login/logout -->
    <script>
        $(document).ready(function(e) {
            $('form[name="login"]').click(function(event) {
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
                $('#login-submit').hide();
                $('#spinnerss').show();
                e.preventDefault();
            });
        });
    </script>
    <script>
        // Cek kesesuaian dengan jenis kegiatan yang dipilih
        function cek() {
            $(".info_status").html('<img src="/img/loading.gif">');
            let valKegiatan = $('#pilihKegiatan').val();
            let getOverlap = overlappingFeatures;
            // console.log(getOverlap);
            // let properties = getOverlap.map(function(feature) {
            //     return feature.properties;
            // });
            objectID = getOverlap.map(function(feature) {
                return feature.properties.OBJECTID;
            });
            getOverlapProperties = [];
            if (objectID.length === 0) {
                getOverlapProperties = [
                    objectID = "",
                    namaZona = "Maaf, Tidak ada data / Tidak terdeteksi",
                    subZona = "",
                    kodeKawasan = "",
                    kawasan = "Maaf, Tidak ada data / Tidak terdeteksi",
                ];
            } else {
                for (let index = 0; index < getOverlap.length; index++) {
                    const objectID = getOverlap[index].properties.OBJECTID;
                    const namaZona = getOverlap[index].properties.NAMOBJ;
                    const subZona = getOverlap[index].properties.SUBZONA2;
                    const kodeKawasan = getOverlap[index].properties.KODKWS;
                    const kawasan = getOverlap[index].properties.JNSRPR;
                    const newObj = {
                        objectID: objectID,
                        namaZona: namaZona,
                        subZona: subZona,
                        kodeKawasan: kodeKawasan,
                        kawasan: kawasan
                    };
                    getOverlapProperties[index] = newObj;
                }
                // console.log(getOverlapProperties);
                const uniqueObjectsID = [];
                let temp = [];
                for (let index = 0; index < getOverlapProperties.length; index++) {
                    const data = getOverlapProperties[index];
                    const cek = data.objectID;
                    if (!temp.includes(cek)) {
                        uniqueObjectsID.push(data);
                        temp.push(cek);
                    }
                }
                // console.log(uniqueObjectsID);
                getOverlapProperties = [];
                let temp1 = [];
                let temp2 = [];
                for (let index = 0; index < uniqueObjectsID.length; index++) {
                    const data = uniqueObjectsID[index];
                    const cek1 = data.namaZona;
                    const cek2 = data.kodeKawasan;
                    if (!temp1.includes(cek1) || !temp2.includes(cek2)) {
                        getOverlapProperties.push(data);
                        temp1.push(cek1);
                        temp2.push(cek2);
                    }
                }
            }
            // console.log(getOverlapProperties);
            $('#lanjutKirim').prop('disabled', true);
            $.ajax({
                    method: "POST",
                    url: "/data/cekStatus",
                    data: {
                        valKegiatan,
                        getOverlapProperties,
                    },
                    dataType: "json",
                })
                .done(function(response) {
                    console.log(response);
                    let hasil = response.hasil;
                    let valZona = response.valZona;
                    // valZona = valZona.map(function(item) {
                    //     return item.id_zona;
                    // });
                    // console.log(valZona);
                    $("#idZona").val(valZona);

                    if (hasil.length !== 0) {
                        let diperbolehkan = hasil.filter(item => item.status === 'diperbolehkan');
                        let diperbolehkanBersyarat = hasil.filter(item => item.status === 'diperbolehkan bersyarat');
                        let tidakDiperbolehkan = hasil.filter(item => item.status === 'tidak diperbolehkan');
                        if (tidakDiperbolehkan.length !== 0) {
                            $('#lanjutKirim').prop(<?= (logged_in()) ?  "'disabled', true" : "'disabled', true" ?>);
                            $(".info_status").html('<p class="tidakBoleh">Aktivitas yang tidak diperbolehkan</p>');
                            hasilStatus = "tidak diperbolehkan";
                        } else if (diperbolehkanBersyarat.length !== 0) {
                            $('#lanjutKirim').prop(<?= (logged_in()) ?  "'disabled', false" : "'disabled', true" ?>);
                            $(".info_status").html('<p class="bolehBersyarat">Aktivitas diperbolehkan setelah memperoleh izin</p>');
                            hasilStatus = "diperbolehkan bersyarat";
                        } else {
                            $('#lanjutKirim').prop(<?= (logged_in()) ?  "'disabled', false" : "'disabled', true" ?>);
                            $(".info_status").html('<p class="boleh">Aktivitas yang diperbolehkan</p>');
                            hasilStatus = "diperbolehkan";
                        }
                    } else {
                        if (valZona == "") {
                            $('#lanjutKirim').prop(<?= (logged_in()) ?  "'disabled', false" : "'disabled', true" ?>);
                            $(".info_status").html('<p class="">Diluar Zona KKPRL Kalimantan Timur</p>');
                            hasilStatus = "Diluar Zona KKPRL Kalimantan Timur";
                        } else {
                            $('#lanjutKirim').prop(<?= (logged_in()) ?  "'disabled', false" : "'disabled', true" ?>);
                            $(".info_status").html('<p class="">No Data</p>');
                            hasilStatus = "No Data";
                        }
                    }
                    $("#hasilStatus").val(JSON.stringify(hasilStatus));
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
    <script src="https://cdn.jsdelivr.net/npm/ol@v8.1.0/dist/ol.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/elm-pep@1.0.6/dist/elm-pep.js"></script>
    <script src="https://api.tiles.mapbox.com/mapbox.js/plugins/turf/v2.0.0/turf.min.js"></script>
    <script src="/mapSystem/catiline.js"></script>
    <script src="https://unpkg.com/shpjs@latest/dist/shp.js"></script>
    <script src="/mapSystem/turf.min.js"></script>
    <script src="https://unpkg.com/togeojson@0.16.0/togeojson.js"></script>

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
        let styleDraw;
        var wkt;
        var coordinates;
        var jsonCoordinates;
        var geojsonFeature;
        var overlappingFeatures;
        let getOverlapProperties;
        let hasilStatus;
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
            // crossOrigin: 'anonymous',
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
            // crossOrigin: 'anonymous',
            visible: true,
        });

        const mapboxBaseURL = 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiNjg2MzUzMyIsImEiOiJjbDh4NDExZW0wMXZsM3ZwODR1eDB0ajY0In0.6jHWxwN6YfLftuCFHaa1zw';
        const mapboxStyleId = 'mapbox/streets-v11';
        const mapboxSource = new ol.source.XYZ({
            url: mapboxBaseURL.replace('{id}', mapboxStyleId),
        });
        const mapboxBaseMap = new ol.layer.Tile({
            source: mapboxSource,
            // crossOrigin: 'anonymous',
            visible: false,
        });

        const baseMaps = [osmBaseMap, bingAerialBaseMap, mapboxBaseMap];

        function set_bing_aerial() {
            bingAerialBaseMap.setVisible(true);
            osmBaseMap.setVisible(false);
            mapboxBaseMap.setVisible(false);
            localStorage.setItem('lastCheckedMap', 'bing_aerial');
        }

        function set_osm() {
            bingAerialBaseMap.setVisible(false);
            osmBaseMap.setVisible(true);
            mapboxBaseMap.setVisible(false);
            localStorage.setItem('lastCheckedMap', 'osm');
        }

        function set_mapbox_road() {
            bingAerialBaseMap.setVisible(false);
            osmBaseMap.setVisible(false);
            mapboxBaseMap.setVisible(true);
            localStorage.setItem('lastCheckedMap', 'mapbox_road');
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

        // Membuat array lapisan WMS dari GeoServer
        const RZWP3KLayerNames = [
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
            'Alur_Migrasi_Mamalia_Laut',
            'Alur_Migrasi_Penyu',
            'Alur_Pelayaran_Umum_dan_Perlintasan',
            'Lintas_Penyeberangan_Antarprovinsi',
            'Lintas_Penyeberangan_Antarkabupaten_Kota_dalam_Provinsi',
        ];
        const layersToShow = ['Zona_Pelabuhan_Umum', 'Sistem_Jaringan_Energi', 'Sistem_Jaringan_Telekomunikasi', 'Alur_Pelayaran_Umum_dan_Perlintasan', 'Lintas_Penyeberangan_Antarprovinsi', 'Lintas_Penyeberangan_Antarkabupaten_Kota_dalam_Provinsi'];
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
                // crossOrigin: 'anonymous',
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
                // crossOrigin: 'anonymous',
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

        function restoreLastCheckedMap() {
            const lastCheckedMap = localStorage.getItem('lastCheckedMap');
            if (lastCheckedMap === 'osm') {
                $('#radio2').prop('checked', true);
                set_osm();
            } else if (lastCheckedMap === 'bing_aerial') {
                $('#radio1').prop('checked', true);
                set_bing_aerial();
            } else if (lastCheckedMap === 'mapbox_road') {
                $('#radio3').prop('checked', true);
                set_mapbox_road();
            } else {
                $('#radio2').prop('checked', true);
                set_osm();
            }
        }
        restoreLastCheckedMap();



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
            localStorage.setItem(`clahan_${index}`, checkbox.checked);
        }

        function set_zona(index) {
            const checkbox = document.getElementById(`czona_${index}`);
            const layerName = KKPRLLayerNames[index];
            const visibility = checkbox.checked;
            toggleWMSLayer(layerName, visibility);
            localStorage.setItem(`czona_${index}`, checkbox.checked);
        }
        // fungsi untuk record kondisi checked layer ke localstorage
        function saveCheckedStatus() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"][name^="czona_"]');
            const checkboxes2 = document.querySelectorAll('input[type="checkbox"][name^="clahan_"]');
            checkboxes.forEach((checkbox) => {
                const index = checkbox.getAttribute('name').replace('czona_', '');
                const checked = checkbox.checked;
                localStorage.setItem(`czona_${index}`, checked);
            });
            checkboxes2.forEach((checkbox) => {
                const index2 = checkbox.getAttribute('name').replace('clahan_', '');
                const checked2 = checkbox.checked;
                localStorage.setItem(`clahan_${index2}`, checked2);
            });
        }

        // Fungsi untuk mengambil status checked dari local storage
        function restore_czona(index = "") {
            const checkboxes = document.querySelectorAll('input[type="checkbox"][name^="czona_"]');
            checkboxes.forEach((checkbox) => {
                const index = checkbox.getAttribute('name').replace('czona_', '');
                const checked = localStorage.getItem(`czona_${index}`) === 'true';
                checkbox.checked = checked;
                const layerName = KKPRLLayerNames[index];
                toggleWMSLayer(layerName, checked);
            });
        }

        function restore_clahan() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"][name^="clahan_"]');
            checkboxes.forEach((checkbox) => {
                const index = checkbox.getAttribute('name').replace('clahan_', '');
                const checked = localStorage.getItem(`clahan_${index}`) === 'true';
                checkbox.checked = checked;
                const layerName = RZWP3KLayerNames[index];
                toggleWMSLayer(layerName, checked);
            });
        }
        // Fungsi untuk inisialisasi komunikasi localstorage
        function initializeCheckboxes() {
            if (localStorage.getItem('layer_initialized') !== 'true') {
                saveCheckedStatus();
                localStorage.setItem('layer_initialized', 'true');
            } else {
                restore_czona();
                restore_clahan();
            }
        }
        initializeCheckboxes();

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
        function centang(cond) {
            if (cond == 1) {
                for (var i = 0; i < KKPRL_Layer.length; i++) {
                    $('#czona_' + i).prop('checked', true);
                    KKPRL_Layer[i].setVisible(true);
                    set_zona(i)
                }
            } else if (cond == 0) {
                for (var i = 0; i < KKPRL_Layer.length; i++) {
                    $('#czona_' + i).prop('checked', false);
                    KKPRL_Layer[i].setVisible(false);
                    set_zona(i)
                }
            } else if (cond == 3) {
                for (var i = 0; i < RZWP3K_Layer.length; i++) {
                    $('#clahan_' + i).prop('checked', true);
                    RZWP3K_Layer[i].setVisible(true);
                    set_subzona(i)
                }
            } else if (cond == 2) {
                for (var i = 0; i < RZWP3K_Layer.length; i++) {
                    $('#clahan_' + i).prop('checked', false);
                    RZWP3K_Layer[i].setVisible(false);
                    set_subzona(i)
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
                src: '/mapSystem/images/marker-icon.png'
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

        function kirim() {
            let geojson = geojsonFeature;
            let getOverlap = getOverlapProperties;
            $("#geojson").val(JSON.stringify(geojson));
            $("#getOverlap").val(JSON.stringify(getOverlap));
        }

        function modalLoading() {
            $("#div_hasilCek").html('<img src="/img/loading.gif">');
            $('#modalCekHasil').show();
        }

        // tampilin Cek overlap features
        function cekHasil(id, kawasan, name, kode, orde) {
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

        // Cek overlap features
        function prosesDetectInput(drawn, type = "polygon") {
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
                    alert("Terjadi kesalahan, mohon ulangi atau reload browser anda");
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
                    alert("Terjadi kesalahan, mohon ulangi atau reload browser anda");
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
                        var overlap = turf.booleanIntersects(geojsonFeature, shapefilePoly);
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
                    alert("Terjadi kesalahan, mohon ulangi atau reload browser anda");
                }
            }

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
            cekHasil(overlappingID, overlappingKawasan, overlappingObject, overlappingKode, overlappingOrde);
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
                prosesDetectInput(jsonCoordinates[0], "point", geojsonFeature);
            } else if (counterK > 2) {
                prosesDetectInput([jsonCoordinates], "polygon", geojsonFeature);
            } else {
                prosesDetectInput(jsonCoordinates, "line", geojsonFeature);
            }
        });
        let selectedCounter;
        $("#next_step_byFile").click(function(e) {
            console.log("KLIK");
            if (selectedCounter < 2) {
                prosesDetectInput(jsonCoordinates[0], "point", geojsonFeature);
            } else if (selectedCounter > 2) {
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
        try {
            var wfunc = function(base, cb) {
                importScripts('https://unpkg.com/shpjs@latest/dist/shp.js');
                shp(base).then(cb);
            }
            var worker = cw({
                data: wfunc
            }, 2);
            worker.data(cw.makeUrl('/geojson/KKPRL_joinTableWithRZWPCopy.zip')).then(function(data) {
                geoshp = data;
                // console.log("Var Global:", data);
                console.info("READY!!");
            }, function(a) {
                console.log(a)
            });
        } catch (error) {
            console.log(`error: ${error}`);
        }

        // mouse coordinate show
        const mousePositionControl = new ol.control.MousePosition({
            coordinateFormat: ol.coordinate.createStringXY(6),
            projection: 'EPSG:4326',
            // comment the following two lines to have the mouse position
            // be placed within the map.
            className: 'custom-mouse-position',
            target: document.getElementById('mouse-position'),
            undefinedHTML: '[Posisi Koordinat X,Y]'
        });

        $('#isiByFile').change(function(e) {
            const file = e.target.files[0];
            console.log(file);
            const reader = new FileReader();
            jsonCoordinates = [];
            vectorSource.clear();
            const readFile = new Promise((resolve, reject) => {
                reader.onload = function(event) {
                    const fileName = file.name;
                    const contents = event.target.result;
                    const getExtension = fileName.split('.').pop().toLowerCase();;
                    if (getExtension == 'xlsx' || getExtension == 'xls' || getExtension == 'csv') {
                        const data = new Uint8Array(contents);
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
                        console.log(selectedCounter);
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
                        // console.log(jsonCoordinates);
                        const iframe = document.getElementById("petaPreview");
                        iframe.contentWindow.postMessage({
                            jsonCoordinates,
                            selectedCounter,
                        }, '<?= base_url('/data/petaPreview'); ?>');
                    } else if (getExtension == 'zip') {
                        let geojson;
                        const shpPromise = new Promise((resolve, reject) => {
                            shp(contents)
                                .then(function(data) {
                                    geojson = data;
                                    resolve(geojson);
                                })
                                .catch(function(error) {
                                    console.error('Error:', error);
                                    reject('Terjadi kesalahan saat membaca file SHP zipped.');
                                });
                        });
                        shpPromise.then((geojson) => {
                            console.log(geojson);
                            geojsonFromFile(geojson);
                        }).catch((error) => {
                            console.error('Error:', error);
                            alert(error);
                        });
                    } else if (getExtension == 'kmz') {
                        let geojson;
                        const zip = new JSZip();
                        zip.loadAsync(contents).then(zipData => {
                            const kmlFile = Object.keys(zipData.files).find(filename =>
                                filename.toLowerCase().endsWith('.kml')
                            );
                            if (kmlFile) {
                                const kmlContent = zipData.files[kmlFile].async('text');
                                return kmlContent;
                            } else {
                                throw new Error('Tidak ada file KML dalam KMZ.');
                            }
                        }).then(kmlContent => {
                            const kml = new DOMParser().parseFromString(kmlContent, 'text/xml');
                            geojson = toGeoJSON.kml(kml);
                            geojsonFromFile(geojson);
                        }).catch(error => {
                            alert(error.message);
                        });
                    } else {
                        return alert("File tidak didukung!");
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
                var extent = drawedVector.getSource().getExtent();
                map.getView().fit(extent, {
                    padding: [100, 100, 100, 100],
                    minResolution: map.getView().getResolutionForZoom(8),
                    duration: 1500,
                });
            }).catch(error => {
                console.error('Error:', error);
            });
        });

        function geojsonFromFile(geojson) {
            geojsonFeature = [];
            const type = geojson.features[0].geometry.type;
            jsonCoordinates = geojson.features[0].geometry.coordinates[0];
            // console.log(jsonCoordinates);
            if (type == "Point") {
                selectedCounter = 1;
            } else {
                selectedCounter = 3;
            }
            if (selectedCounter < 2) {
                geojsonFeature = turf.point([jsonCoordinates[0][0], jsonCoordinates[0][1]]);
                var pointFeature = new ol.Feature({
                    geometry: new ol.geom.Point(ol.proj.fromLonLat(jsonCoordinates[0]))
                });
                vectorSource.addFeature(pointFeature);
                styleDraw = markerStyle;
            } else {
                geojsonFeature = turf.polygon([jsonCoordinates]);
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
        }
    </script>
    <script src="/js/meass-tool.js"></script>

</body>

</html>