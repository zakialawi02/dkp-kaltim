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

    <!-- Modal Add Data -->
    <div class="modalAdds" id="modalAdd">
        <div class="modalAdd-content">
            <div class="modal-header">
                <h3>Cek Informasi</h3>
                <button class="close-button" id="close-button">&times;</button>
            </div>
            <hr>
            <div class="modalAdd-body">
                <div class="card-body">
                    <form class="row g-3" action="/data/isiAjuan" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>

                        <?php if (in_groups('User')) : ?>
                            <input type="hidden" class="form-control" for="stat_appv" id="stat_appv" name="stat_appv" value="0">
                        <?php else : ?>
                            <input type="hidden" class="form-control" for="stat_appv" id="stat_appv" name="stat_appv" value="0">
                        <?php endif ?>
                        <input type="hidden" class="form-control" for="koordinat" id="koordinat" name="koordinat" value="">
                        <input type="hidden" class="form-control" for="geojson" id="geojson" name="geojson" value="">

                        <div class="form-group">
                            <label class="col-md-12 mb-2">Jenis Kegiatan</label>
                            <select class="form-select" id="pilihKegiatan" name="kegiatan" for="kegiatan" style="width: 100%;" required>
                                <option></option>
                                <?php foreach ($jenisKegiatan as $K) : ?>
                                    <option value="<?= $K->id_kegiatan; ?>"><?= $K->nama_kegiatan; ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 mb-2" for="SubZona">Zona Kegiatan:</label>
                            <select class="form-select" name="SubZona" id="SubZona" style="width: 100%;" required disabled>
                                <option value="">Pilih Kegiatan terlebih dahulu</option>
                            </select>
                        </div>

                        <div class="feedback">Keterangan:</div>
                        <div class="info">
                            <div class="feedback" id="showKegiatan"> </div>
                        </div>

                        <button type="submit" id="lanjutKirim" class="btn btn-primary">Lanjutkan</button>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <div class="p-2"></div>
            </div>
        </div>
    </div>

    <!-- Modal alert -->
    <div class="modalAdds" id="modalAdd">
        <div class="modalAdd-content">
            <div class="modal-header">
                <h3>Cek Informasi</h3>
                <button class="close-button" id="close-button">&times;</button>
            </div>
            <hr>
            <div class="modalAdd-body">
                <div class="card-body">
                    <form class="row g-3" action="/data/isiAjuan" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>

                        <?php if (in_groups('User')) : ?>
                            <input type="hidden" class="form-control" for="stat_appv" id="stat_appv" name="stat_appv" value="0">
                        <?php else : ?>
                            <input type="hidden" class="form-control" for="stat_appv" id="stat_appv" name="stat_appv" value="0">
                        <?php endif ?>
                        <input type="hidden" class="form-control" for="koordinat" id="koordinat" name="koordinat" value="">
                        <input type="hidden" class="form-control" for="geojson" id="geojson" name="geojson" value="">

                        <div class="form-group">
                            <label class="col-md-12 mb-2">Jenis Kegiatan</label>
                            <select class="form-select" id="pilihKegiatan" name="kegiatan" for="kegiatan" style="width: 100%;" required>
                                <option></option>
                                <?php foreach ($jenisKegiatan as $K) : ?>
                                    <option value="<?= $K->id_kegiatan; ?>"><?= $K->nama_kegiatan; ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 mb-2" for="SubZona">Zona Kegiatan:</label>
                            <select class="form-select" name="SubZona" id="SubZona" style="width: 100%;" required disabled>
                                <option value="">Pilih Kegiatan terlebih dahulu</option>
                            </select>
                        </div>

                        <div class="feedback">Keterangan:</div>
                        <div class="info">
                            <div class="feedback" id="showKegiatan"> </div>
                        </div>

                        <button type="submit" id="lanjutKirim" class="btn btn-primary">Lanjutkan</button>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <div class="p-2"></div>
            </div>
        </div>
    </div>

    <div id="button-section-group" class="">
        <div id="button-section" class="float-end m-1">
            <button id="modal-button" class="btn btn-primary">Cek Kesesuaian</button>
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



    <div class="map" id="map">

    </div>
    <div class="sidepanel">
        <div class="m-2 p-2">
            <div class="sidepanel-content">

                <div class="accordion" id="accordionPanelsStayOpenExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false" aria-controls="panelsStayOpen-collapseOne">
                                Layer Zona
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
                            <div class="accordion-body">

                                <div class="nouislider" id="transparansi-slider"></div>
                                <br>
                                <button class="btn btn-outline-dark" onclick="centang(1)">check all</button>
                                <button class="btn btn-outline-dark" onclick="centang(0)">uncheck all</button>
                                <br><br>
                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_0" id="clahan_0" value="kb" onclick="set_lahan(0)"><span style="min-width: 50px; background-image: url('/leaflet/icon/migrasi.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Alur Migrasi Mamalia Laut</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_1" id="clahan_1" value="kb" onclick="set_lahan(1)"><span style="min-width: 50px; background-image: url('/leaflet/icon/budidayalaut.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Budidaya Laut</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_2" id="clahan_2" value="kb" onclick="set_lahan(2)"><span style="min-width: 50px; background-image: url('/leaflet/icon/dlkrdlkp.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Daerah Lingkungan Kerja (DLKr) & Daerah Lingkungan Kepentingan (DLKp)</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_3" id="clahan_3" value="kb" onclick="set_lahan(3)"><span style="min-width: 50px; background-image: url('/leaflet/icon/demersal.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>Demersal</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_4" id="clahan_4" value="kb" onclick="set_lahan(4)"><span style="min-width: 50px; background-image: url('/leaflet/icon/minyak.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Gas dan Minyak Bumi</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_5" id="clahan_5" value="kb" onclick="set_lahan(5)"><span style="min-width: 50px; background-image: url('/leaflet/icon/kabel.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>Kabel Telekomunikasi</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_6" id="clahan_6" value="kb" onclick="set_lahan(6)"><span style="min-width: 50px; background-image: url('/leaflet/icon/pelagis.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Pelagis</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_7" id="clahan_7" value="kb" onclick="set_lahan(7)"><span style="min-width: 50px; background-image: url('/leaflet/icon/pelagisdandemersal.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Pelagis dan Demersal</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_8" id="clahan_8" value="kb" onclick="set_lahan(8)"><span style="min-width: 50px; background-image: url('/leaflet/icon/pemukiman.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Permukiman Nelayan</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_9" id="clahan_9" value="kb" onclick="set_lahan(9)"><span style="min-width: 50px; background-image: url('/leaflet/icon/kabel.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Pipa Minyak dan Gas</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_10" id="clahan_10" value="kb" onclick="set_lahan(10)"><span style="min-width: 50px; background-image: url('/leaflet/icon/pol_white.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Tidak Dibagi Ke Dalam Subzona</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_11" id="clahan_11" value="kb" onclick="set_lahan(11)"><span style="min-width: 50px; background-image: url('/leaflet/icon/wkopp.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Wilayah Kerja dan Wilayah Pengoperasian Pelabuhan Perikanan (WKOPP) </label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_12" id="clahan_12" value="kb" onclick="set_lahan(12)"><span style="min-width: 50px; background-image: url('/leaflet/icon/'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Wisata Alam Bawah Laut</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_13" id="clahan_13" value="kb" onclick="set_lahan(13)"><span style="min-width: 50px; background-image: url('/leaflet/icon/wisata.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Wisata Pantai/Pesisir dan Pulau-Pulau Kecil</label>

                                <!-- <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_0" id="clahan_0" value="kb" onclick="set_lahan(0)"><span style="min-width: 50px; background-image: url('/leaflet/icon/migrasi.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Migrasi Biota Tertentu</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_1" id="clahan_1" value="kb" onclick="set_lahan(1)"><span style="min-width: 50px; background-image: url('/leaflet/icon/migrasi.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Migrasi Penyu</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_2" id="clahan_2" value="kb" onclick="set_lahan(2)"><span style="min-width: 50px; background-image: url('/leaflet/icon/kabel.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Pipa Air Bersih</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_3" id="clahan_3" value="kb" onclick="set_lahan(3)"><span style="min-width: 50px; background-image: url('/leaflet/icon/kabel.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Kabel Listrik</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_4" id="clahan_4" value="kb" onclick="set_lahan(4)"><span style="min-width: 50px; background-image: url('/leaflet/icon/kabel.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Kabel Telekomunikasi</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_5" id="clahan_5" value="kb" onclick="set_lahan(5)"><span style="min-width: 50px; background-image: url('/leaflet/icon/kabel.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Pipa Minyak dan Gas</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_6" id="clahan_6" value="kb" onclick="set_lahan(6)"><span style="min-width: 50px; background-image: url('/leaflet/icon/pelayaran.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Pelayaran-Perlintasan Lokal</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_7" id="clahan_7" value="kb" onclick="set_lahan(7)"><span style="min-width: 50px; background-image: url('/leaflet/icon/pelayaran.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Pelayaran-Perlintasan Nasional</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_8" id="clahan_8" value="kb" onclick="set_lahan(8)"><span style="min-width: 50px; background-image: url('/leaflet/icon/pelayaran.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Pelayaran-Perlintasan Regional</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_9" id="clahan_9" value="kb" onclick="set_lahan(9)"><span style="min-width: 50px; background-image: url('/leaflet/icon/konservasiperairan.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Inti KKP</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_10" id="clahan_10" value="kb" onclick="set_lahan(10)"><span style="min-width: 50px; background-image: url('/leaflet/icon/konservasipesisir.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Inti KKP3K </label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_11" id="clahan_11" value="kb" onclick="set_lahan(11)"><span style="min-width: 50px; background-image: url('/leaflet/icon/bandarudara.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Daerah Lingkungan Kerja Bandar Udara</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_12" id="clahan_12" value="kb" onclick="set_lahan(12)"><span style="min-width: 50px; background-image: url('/leaflet/icon/pltugu.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> PLTU/PLTGu</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_13" id="clahan_13" value="kb" onclick="set_lahan(13)"><span style="min-width: 50px; background-image: url('/leaflet/icon/industri.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Industri Maritim</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_14" id="clahan_14" value="kb" onclick="set_lahan(14)"> <span style="min-width: 50px; background-image: url('/leaflet/icon/industri.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Industri Manufaktur</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_15" id="clahan_15" value="kb" onclick="set_lahan(15)"><span style="min-width: 50px; background-image: url('/leaflet/icon/budidayalaut.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Budidaya Laut</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_16" id="clahan_16" value="kb" onclick="set_lahan(16)"><span style="min-width: 50px; background-image: url('/leaflet/icon/dlkrdlkp.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Daerah Lingkungan Kerja (DLKr) & Daerah Lingkungan Kepentingan (DLKp)</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_17" id="clahan_17" value="kb" onclick="set_lahan(17)"><span style="min-width: 50px; background-image: url('/leaflet/icon/wkopp.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Wilayah Kerja dan Wilayah Pengoperasian Pelabuhan Perikanan (WKOPP)</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_18" id="clahan_18" value="kb" onclick="set_lahan(18)"><span style="min-width: 50px; background-image: url('/leaflet/icon/minyak.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Minyak Bumi</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_19" id="clahan_19" value="kb" onclick="set_lahan(19)"><span style="min-width: 50px; background-image: url('/leaflet/icon/pasirlaut.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Pasir Laut</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_20" id="clahan_20" value="kb" onclick="set_lahan(20)"> <span style="min-width: 50px; background-image: url('/leaflet/icon/pelagis.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Pelagis</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_21" id="clahan_21" value="kb" onclick="set_lahan(21)"><span style="min-width: 50px; background-image: url('/leaflet/icon/pelagisdandemersal.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Pelagis dan Demersal</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_22" id="clahan_22" value="kb" onclick="set_lahan(22)"> <span style="min-width: 50px; background-image: url('/leaflet/icon/'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Wisata Alam Bawah Laut</label>

                                <label class="symbology" style="margin-left: 0px"><input type="checkbox" checked="true" autocomplete="off" name="clahan_23" id="clahan_23" value="kb" onclick="set_lahan(23)"><span style="min-width: 50px; background-image: url('/leaflet/icon/wisata.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Wisata Alam Pantai/Pesisir dan Pulau-pulau Kecil</label> -->
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                Peta Dasar
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                            <div class="accordion-body">
                                <!--RADIO 1-->
                                <input type="radio" class="radio_item" value="bingAe" name="item" id="radio1" onclick="set_bing_aerial()" checked>
                                <label class="label_item" for="radio1"> <img src="/leaflet/icon/here_satelliteday.png"> <span>Bing Aerial</span> </label>

                                <!--RADIO 2-->
                                <input type="radio" class="radio_item" value="osm" name="item" id="radio2" onclick="set_osm()">
                                <label class="label_item" for="radio2"> <img src="/leaflet/icon/openstreetmap_mapnik.png"> <span>Open Street Map</span></label>

                                <!--RADIO 2-->
                                <input type="radio" class="radio_item" value="bing" name="item" id="radio3" onclick="set_mapbox_road()">
                                <label class="label_item" for="radio3"> <img src="https://placedog.net/100/100"> <span>S99</span> </label>
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

    <!-- Template Javascript -->
    <!-- <script src="/assets/js/main.js"></script> -->
    <script>
        $('.toggle-sidepanel').click(function() {
            $('.sidepanel').toggleClass('expanded');
        });
    </script>
    <script>
        $(document).ready(function() {
            var dataKegiatan;
            $('#pilihKegiatan').change(function() {
                var kegiatanId = $(this).val();

                if (kegiatanId !== '') {
                    $('#SubZona').prop('disabled', false);

                    $.ajax({
                        url: "<?= base_url('admin/getZonaByKegiatan') ?>",
                        method: "POST",
                        data: {
                            kegiatanId: kegiatanId
                        },
                        dataType: 'json',
                        success: function(response) {
                            var options = '<option value="">Pilih Zona Kegiatan</option>';

                            if (response.length > 0) {
                                dataKegiatan = response;
                                $.each(response, function(index, SubZona) {
                                    options += '<option value="' + SubZona.id_sub + '">' + SubZona.nama_subzona + '</option>';
                                });
                            }
                            $('#SubZona').html(options);
                        }
                    });
                } else {
                    $('#SubZona').prop('disabled', true);
                    $('#SubZona').html('<option value="">Pilih Kegiatan terlebih dahulu</option>');
                }
            });

            $('#SubZona').change(function(e) {
                var zonaId = $(this).val();
                var result = dataKegiatan.filter(function(item) {
                    return item.id_sub === zonaId;
                });
                var status = result[0].status_zonasi;
                var showKegiatan = $('#showKegiatan');
                showKegiatan.removeClass().addClass('feedback');
                if (status === '1') {
                    $('#lanjutKirim').prop('disabled', false);
                    showKegiatan.text('Diperbolehkan').addClass('boleh');
                } else if (status === '2') {
                    $('#lanjutKirim').prop('disabled', false);
                    showKegiatan.text('Diperbolehkan Bersyarat').addClass('bolehBersyarat');
                } else if (status === '3') {
                    $('#lanjutKirim').prop('disabled', true);
                    showKegiatan.text('Tidak diperbolehkan').addClass('tidakBoleh');
                } else {
                    $('#lanjutKirim').prop('disabled', false);
                    showKegiatan.text('');
                }
            });
        });
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

    <!-- modalAdd -->
    <script>
        const modalButton = document.getElementById("modal-button");
        const modal = document.getElementById("modalAdd");
        const closeButton = document.getElementById("close-button");

        modalButton.addEventListener("click", function() {
            <?php if (logged_in()) : ?>
                $("#modal-button").addClass("btn-warning");
                map.pm.enableDraw("Polygon", {
                    snappable: true,
                    snapDistance: 20,
                });
                if (drawnLayer) {
                    map.removeLayer(drawnLayer);
                }
            <?php else : ?>
                $("#loading-spinner").removeClass("d-none");
                setTimeout(function() {
                    $("#loading-spinner").addClass("d-none");
                    Swal.fire({
                        title: 'Anda harus login terlebih dahulu',
                        customClass: {
                            container: 'my-swal',
                        },
                    })
                    var logModal = new bootstrap.Modal($('#loginModal'));
                    logModal.show();
                }, 500);
            <?php endif ?>
        });

        $('#close-button').click(function(e) {
            $('#modalAdd').hide();
        });

        window.addEventListener("click", function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
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
        $(document).ready(function() {
            $('#pilihKegiatan').select2({
                placeholder: "Pilih Jenis Kegiatan",
                allowClear: true
            });
            $('#SubZona').select2({
                placeholder: "Pilih Zona Wilayah Kegiatan",
                allowClear: true
            });
        });
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
    </script>



    <!-- Open Layers Component -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.5.0/proj4.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/ol@v7.4.0/dist/ol.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/elm-pep@1.0.6/dist/elm-pep.js"></script>


    <script type="text/javascript">
        <?php foreach ($tampilData as $D) : ?>
            <?php $koordinat = $D->coordinat_wilayah ?>
            <?php $zoomView = $D->zoom_view ?>
            <?php $splitKoordinat = explode(', ', $koordinat) ?>
            <?php $lon = $splitKoordinat[0] ?>
            <?php $lat = $splitKoordinat[1] ?>
        <?php endforeach ?>

        proj4.defs("EPSG:32750", "+proj=utm +zone=50 +south +ellps=WGS84 +datum=WGS84 +units=m +no_defs");
        proj4.defs("EPSG:23836", "+proj=tmerc +lat_0=0 +lon_0=112.5 +k=0.9999 +x_0=200000 +y_0=1500000 +ellps=WGS84 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs");

        const wmsLayers = [];


        const projection = new ol.proj.Projection({
            code: 'EPSG:32750',
            units: 'm',
            axisOrientation: 'neu'
        });

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
        const map = new ol.Map({
            layers: [
                new ol.layer.Group({
                    layers: baseMaps,
                }),
            ],
            target: 'map',
            controls: [
                //Define the default controls
                new ol.control.Zoom(),
                new ol.control.Rotate(),
                new ol.control.Attribution(),
                //Define some new controls
                // new ol.control.OverviewMap(),
                new ol.control.ScaleLine(),

            ],
            view: view,
        });
        const mainMap = map;
        // map.addLayer(bingAerialBaseMap);
        // map.addLayer(wms_layer);

        // Membuat array lapisan WMS dari GeoServer
        const wmsLayerNames = [
            'Alur_Migrasi_Mamalia_Laut',
            'Budidaya_Laut',
            'DLKr-DLKp',
            'Demersal',
            'Gas_dan_Minyak_Bumi',
            'Kabel_Telekomunikasi',
            'Pelagis',
            'Pelagis_dan_Demersal',
            'Permukiman_Nelayan',
            'Pipa_Minyak_dan_Gas',
            'Tidak_Dibagi_Ke_Dalam_Subzona',
            'WKOPP',
            'Wisata_Alam_Bawah_Laut',
            'Wisata_Pantai_Pesisir_dan_Pulau-Pulau_Kecil',

        ];

        // Loop untuk menambahkan setiap lapisan WMS ke dalam objek peta
        for (const layerName of wmsLayerNames) {
            const wmsSource = new ol.source.TileWMS({
                url: 'http://47.88.84.156:8080/geoserver/DKP-KALTIM/wms',
                params: {
                    'LAYERS': `DKP-KALTIM:${layerName}`,
                    'TILED': true,
                    'FORMAT': 'image/png',
                },
                serverType: 'geoserver',
            });
            var wms_layer = new ol.layer.Tile({
                source: wmsSource,
                visible: true,
                opacity: 0.8
            });

            map.addLayer(wms_layer);
            wmsLayers.push(wms_layer);
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

        set_bing_aerial();


        // Fungsi untuk menyembunyikan atau menampilkan lapisan WMS
        function toggleWMSLayer(layerName, visibility) {
            const layers = map.getLayers();
            layers.forEach(layer => {
                if (layer instanceof ol.layer.Tile && layer.getSource() instanceof ol.source.TileWMS) {
                    const params = layer.getSource().getParams();
                    if (params.LAYERS === `DKP-KALTIM:${layerName}`) {
                        layer.setVisible(visibility);
                    }
                }
            });
        }

        function set_lahan(index) {
            const checkbox = document.getElementById(`clahan_${index}`);
            const layerName = wmsLayerNames[index];
            const visibility = checkbox.checked;
            toggleWMSLayer(layerName, visibility);
        }

        // Fungsi untuk mengubah transparansi lapisan WMS
        function updateWMSTransparency(opacity) {
            wmsLayers.forEach(wmsLayers => {
                wmsLayers.setOpacity(opacity);
            });
        }
        opacitySlider.noUiSlider.on('update', function(values, handle) {
            const opacity = parseFloat(values[handle]);
            updateWMSTransparency(opacity);
        });

        // Fungsi check all/uncheck (show/hide all) layer wms
        function centang(cons) {
            var jumlahZona = wmsLayers.length;
            if (cons == 1) {
                for (var i = 0; i < jumlahZona; i++) {
                    $('#clahan_' + i).prop('checked', true);
                    wmsLayers[i].setVisible(true);
                }
            } else {
                for (var i = 0; i < jumlahZona; i++) {
                    $('#clahan_' + i).prop('checked', false);
                    wmsLayers[i].setVisible(false);
                }
            }
        }

        view.on('change:center', function() {
            // Mengambil koordinat tengah dari view saat ini
            const centerCoordinate = view.getCenter();

            // Konversi koordinat tengah ke koordinat lon-lat
            const lonLatCenter = ol.proj.toLonLat(centerCoordinate);

            // Tampilkan koordinat tengah pada konsol
            console.log('Koordinat Tengah (Lon, Lat) setelah digeser:', lonLatCenter);
        });
        // Fungsi untuk menampilkan koordinat pada log console saat peta diklik
        // function showCoordinateOnClick(event) {
        //     const coordinate = event.coordinate;
        //     const lonLat = ol.proj.toLonLat(coordinate);
        //     console.log(`Latitude: ${lonLat[1]}, Longitude: ${lonLat[0]}`);
        // }
        // Menambahkan event listener ke objek peta
        // map.on('click', showCoordinateOnClick);
        map.on('click', function(e) {
            console.log(e);
            const coordinate = e.coordinate;
            console.log(coordinate);
        });
    </script>

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