<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title><?= $title; ?></title>
    <!-- Favicons -->
    <link href="/img/favicon.png" rel="icon">

    <!-- Vendor CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css " rel="stylesheet">
    <link href=" https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.css " rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="/css/StyleAdmin.css" rel="stylesheet" />

    <!-- Open Layers Component -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v7.4.0/ol.css">
    <link rel="stylesheet" href="https://unpkg.com/ol-layerswitcher@4.1.1/dist/ol-layerswitcher.css" />
    <link href=" https://cdn.jsdelivr.net/npm/ol-ext@4.0.11/dist/ol-ext.min.css " rel="stylesheet">

    <style>
        #map {
            height: 75vh;
            cursor: grab;
        }

        .ol-ext-print-dialog {
            z-index: 10000000;
        }

        .ol-scale-line {
            right: 0;
            left: auto;
            bottom: 2em;
        }

        .ol-control-title {
            height: 2em;
        }

        .ol-print-compass {
            top: 1.5em !important;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <!-- NAV HAEADER -->
    <?= $this->include('_Layout/_template/_admin/header'); ?>
    <div id="layoutSidenav">
        <!-- SIDEBAR -->
        <?= $this->include('_Layout/_template/_admin/sidebar'); ?>

        <div id="layoutSidenav_content">

            <!-- MAIN CONTENT -->
            <main>
                <div class="container-fluid px-4">
                    <h3 class="mt-3 mb-3">Data Pengajuan Informasi</h3>

                    <div class="alert alert-<?= ($tampilDataIzin->stat_appv == 0) ? 'warning' : 'secondary'; ?> d-flex align-items-center" role="alert">
                        <div>
                            <i class="bi <?= ($tampilDataIzin->stat_appv == 0) ? 'bi-exclamation-triangle' : 'bi-check2-circle'; ?> " style="font-size: x-large;"></i>
                            <?= ($tampilDataIzin->stat_appv == 0) ? 'Data Permohanan Informasi Ruang Laut Oleh <u>' . esc($tampilDataIzin->nama) . '</u> <b>Memerlukan Tindakan/Jawaban</b> Oleh Admin' : 'Data Permohanan Informasi Ruang Laut Oleh <u>' . esc($tampilDataIzin->nama) . '</u> <b>Telah Dibalas</b>'; ?>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">

                            <div class="p-md-2">
                                <h4 class="m-0">STATUS : <span class="badge bg-<?= ($tampilDataIzin->stat_appv == 0) ? 'warning' : (($tampilDataIzin->stat_appv == 1) ? 'success' : 'danger'); ?>"> <?= ($tampilDataIzin->stat_appv == 0) ? 'Menunggu Tindakan...' : (($tampilDataIzin->stat_appv == 1) ? 'Disetujui' : 'Tidak Disetujui'); ?> </span></h4>
                                <?php if ($tampilDataIzin->stat_appv != 0) : ?>
                                    <p style="font-size: smaller;">Pada: <?= date('d M Y H:i:s', strtotime($tampilDataIzin->date_updated)); ?></p>
                                <?php endif ?>
                                <?php if ($tampilDataIzin->stat_appv == 1) : ?>
                                    <p class="card-text"><a <?= empty($tampilDataIzin->dokumen_lampiran) ?  'href="#" data-bs-toggle="tooltip" data-bs-title="Dokumen Belum Dikirim"' : 'href="/dokumen/lampiran-balasan/' . $tampilDataIzin->dokumen_lampiran . '" data-bs-toggle="tooltip" data-bs-title="Lihat Dokumen" target="_blank"'; ?>><i class="bi bi-file-earmark-pdf-fill" style="color: #6697de;"></i> Lihat Dokumen Balasan</a></p>
                                <?php endif ?>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-responsive">
                                    <thead class="thead-left">
                                        <tr>
                                            <th style="font-weight: 400; border-bottom-width: 1px; border-bottom-color: #dee2e6;">Nama Pemohon</th>
                                            <th style="border-bottom-width: 1px; border-bottom-color: #dee2e6;">:</th>
                                            <th style="font-weight: 400; border-bottom-width: 1px; border-bottom-color: #dee2e6;"><?= esc($tampilDataIzin->nama); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>NIK (Nomor Induk Kependudukan)</td>
                                            <th>:</th>
                                            <td><?= esc($tampilDataIzin->nik); ?></td>
                                        </tr>
                                        <tr>
                                            <td>NIB (Nomor Izin Berusaha)</td>
                                            <th>:</th>
                                            <td><?= (!empty($tampilDataIzin->nib)) ? esc($tampilDataIzin->nib) : '-'; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Alamat</td>
                                            <th>:</th>
                                            <td><?= esc($tampilDataIzin->alamat); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Kontak</td>
                                            <th>:</th>
                                            <td><?= esc($tampilDataIzin->kontak); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Jenis Kegiatan</td>
                                            <th>:</th>
                                            <td><?= esc($tampilDataIzin->nama_kegiatan); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Wilayah Kegiatan</td>
                                            <th>:</th>
                                            <td>
                                                <?php
                                                if (!empty($tampilDataIzin->id_zona)) {
                                                    $zoneName = explode(",", $tampilDataIzin->id_zona);
                                                    $zoneName = array_unique($zoneName);
                                                    foreach ($tampilZona as $value) {
                                                        if (in_array($value->id_zona, $zoneName)) {
                                                            echo "<span>" . esc($value->nama_zona) . "</span>"  . "<br>";
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php if (!in_groups('User')) : ?>
                                            <tr>
                                                <td>Kesesuaian Kegiatan</td>
                                                <th>:</th>
                                                <td>
                                                    <div class="feedback fs-6">Keterangan:</div>
                                                    <div class="info_status">
                                                        <div class="info_status" id="showKegiatan"> <button type="button" id="cekKesesuaian" class="asbn btn btn-primary bi bi-search-heart"> Cek kesesuaian</button>
                                                            <button class="asbn btn btn-primary d-none" id="loadCekKesesuaian" type="button" disabled>
                                                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                                Loading...
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endif ?>
                                        <tr>
                                            <td>Tanggal Pengajuan</td>
                                            <th>:</th>
                                            <td><?= date('d M Y H:i:s', strtotime($tampilDataIzin->created_at)); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <h5>Berkas</h5>
                            <div class="p-md-2 d-flex flex-wrap gap-2 overflow-auto" style="width: 100%;">
                                <?php if ($tampilDataIzin->uploadFiles != null) : ?>
                                    <?php foreach ($tampilDataIzin->uploadFiles as $file) : ?>
                                        <div class="card mb-3 flex-grow-1" style="max-width: 500px;">
                                            <div class="card-body file">
                                                <p class="card-text"><a href="/dokumen/upload-dokumen/<?= $file->uploadFiles; ?>" target="_blank"><?= $file->uploadFiles; ?></a></p>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <p class="form-text">Tidak ada berkas</p>
                                <?php endif ?>
                            </div>

                        </div>

                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <div id="map" class="map"> </div>
                            <div class="sidepanel">
                                <div class="m-2 p-2">
                                    <div class="sidepanel-content">


                                        <div class="">
                                            <p>Transparansi</p>
                                            <div class="nouislider2" id="transparansi-slider2"></div>
                                        </div>
                                        <br>
                                        <button class="btn btn-outline-dark xs-btn" onclick="centang(1)">Tampilkan Semua</button>
                                        <button class="btn btn-outline-dark xs-btn" onclick="centang(0)">Sembunyikan Semua</button>
                                        <br><br>
                                        <div class="d-grid">
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
                                <div class="toggle-sidepanel">
                                    <span>KKPRL Layer</span>
                                </div>
                            </div>
                            <div id="Cbuttons">
                                <?php if (!in_groups('User')) : ?>
                                    <button type="button" id="muatEksisting" class="asbn btn btn-primary bi bi-arrow-clockwise"> Muat Data Eksisting</button>
                                    <button class="asbn btn btn-primary d-none" id="loadMuatEksisting" type="button" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Loading...
                                    </button>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                    <div class="card ambilTindakanJawaban">
                        <div class="card-body d-flex justify-content-end">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Ambil Tindakan
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Ambil Tindakan</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <form action="/admin/kirimTindakan/<?= $tampilDataIzin->id_perizinan; ?>" method="post" enctype="multipart/form-data">
                                                <div class="form-check mb-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="reject" class="reject" value="2" <?= $tampilDataIzin->stat_appv == 2 ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="reject">
                                                            Tidak Disetujui
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="approve" class="approve" value="1" <?= $tampilDataIzin->stat_appv == 1 ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="approve">
                                                            Disetujui
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="mb-3" id="lampiran" style="display: none;">
                                                    <label for="formFile" class="form-label">Lampirkan Dokumen</label>
                                                    <input class="form-control" name="lampiranFile" type="file" id="lampiranFile">
                                                </div>
                                                <div class="mt-3 gap-2 d-flex justify-content-end ">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                    <button type="submit" class="btn btn-primary">Kiriman</button>
                                                </div>
                                            </form>

                                        </div>
                                        <div class="modal-footer">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main><!-- End #main -->

            <!-- FOOTER -->
            <?= $this->include('_Layout/_template/_admin/footer'); ?>

        </div>
    </div>

    <!-- Vendor JS Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.js"></script>
    <script src="/js/scripts.js"></script>

    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
    <script>
        $("th").css("pointer-events", "none");
        $(".no-sort").css("pointer-events", "none");

        $(".toggle-sidepanel").click(function() {
            $(".sidepanel").toggleClass('expanded');
        });
        $(document).on("click", function(event) {
            if (!$(event.target).closest(".sidepanel").length && !$(event.target).hasClass("toggle-sidepanel")) {
                $(".sidepanel").removeClass('expanded');
            }
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
    <script>
        <?php if (in_groups('User')) : ?>
            $('.ambilTindakanJawaban').remove('.ambilTindakanJawaban');
        <?php endif ?>
        <?php if (!empty($tampilDataIzin->dokumen_lampiran)) : ?>
            $('.ambilTindakanJawaban').remove('.ambilTindakanJawaban');
        <?php endif ?>
    </script>
    <script>
        <?php if ($tampilDataIzin->stat_appv != 0) : ?>
            $('#lampiran').show();
        <?php else : ?>
            $('#approve').click(function(e) {
                $('#lampiran').show();
            });

            $('#reject').click(function(e) {
                $('#lampiran').hide();
            });
        <?php endif ?>
    </script>

    <!-- Open Layers Component -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.5.0/proj4.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/ol@v7.4.0/dist/ol.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/elm-pep@1.0.6/dist/elm-pep.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://unpkg.com/ol-layerswitcher@4.1.1"></script>
    <script src=" https://cdn.jsdelivr.net/npm/ol-ext@4.0.11/dist/ol-ext.min.js "></script>
    <script src="/mapSystem/catiline.js"></script>
    <script src="https://unpkg.com/shpjs@latest/dist/shp.js"></script>
    <script src="/mapSystem/turf.min.js"></script>
    <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL,Object.assign"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/eligrey/FileSaver.js/aa9f4e0e/FileSaver.min.js"></script>
    <script src="/js/write-shp.js"></script>

    <script type="text/javascript">
        <?php foreach ($tampilData as $D) : ?>
            <?php $koordinat = $D->coordinat_wilayah ?>
            <?php $zoomView = $D->zoom_view ?>
            <?php $splitKoordinat = explode(', ', $koordinat) ?>
            <?php $lon = $splitKoordinat[0] ?>
            <?php $lat = $splitKoordinat[1] ?>
        <?php endforeach ?>

        proj4.defs('EPSG:54034', '+proj=cea +lat_ts=0 +lon_0=0 +x_0=0 +y_0=0 +datum=WGS84 +units=m +no_defs +type=crs');
        proj4.defs('EPSG:32750', '+proj=utm +zone=50 +south +ellps=WGS84 +datum=WGS84 +units=m +no_defs');

        const geojson = <?= $tampilDataIzin->lokasi; ?>;
        // console.log(geojson);

        try {
            const btnshp = document.createElement("a");
            btnshp.innerHTML = " Shapefile";
            btnshp.id = "btnshp";
            btnshp.className = "bi bi-cloud-arrow-down asbn btn btn-primary m-md-3";
            btnshp.onclick = function() {
                try {
                    // proj4.defs('EPSG:32750', '+proj=utm +zone=50 +south +datum=WGS84 +units=m +no_defs +type=crs');
                    proj4.defs('EPSG:4326', '+proj=longlat +datum=WGS84 +no_defs');
                    const geojsonData = geojson;
                    const options = {
                        folder: '<?= date("Y"); ?>_<?= date("m"); ?>_<?= esc(urlencode($tampilDataIzin->nama)); ?>_<?= $tampilDataIzin->nik; ?>',
                        filename: "<?= date("Y"); ?>_<?= date("m"); ?>_<?= $tampilDataIzin->nik; ?>",
                        outputType: "blob",
                        types: {
                            point: "<?= $tampilDataIzin->nik; ?>_PT",
                            polygon: "<?= $tampilDataIzin->nik; ?>_AR",
                            polyline: "<?= $tampilDataIzin->nik; ?>_LN",
                        },
                    };
                    try {
                        geojsonData.features.forEach(feature => {
                            feature.geometry.coordinates = feature.geometry.coordinates.map(coordinates => {
                                return coordinates.map(coord => {
                                    return proj4('EPSG:4326', 'EPSG:4326', [coord[0], coord[1]]);
                                });
                            });
                            if (feature.geometry.bbox) {
                                const [minLon, minLat, maxLon, maxLat] = feature.geometry.bbox;
                                const transformedMin = proj4('EPSG:4326', 'EPSG:4326', [minLon, minLat]);
                                const transformedMax = proj4('EPSG:4326', 'EPSG:4326', [maxLon, maxLat]);
                                // Menetapkan ulang nilai bbox yang telah diubah
                                feature.geometry.bbox = [
                                    transformedMin[0], transformedMin[1],
                                    transformedMax[0], transformedMax[1]
                                ];
                            }
                        });
                    } catch (error) {
                        try {
                            geojson.features.forEach(feature => {
                                feature.geometry.coordinates = proj4('EPSG:4326', 'EPSG:4326', feature.geometry.coordinates);
                            });
                        } catch (error) {
                            console.error(error);
                        }
                    }
                    shpwrite.download(geojsonData, options);
                    // console.log(geojsonData);
                } catch (error) {
                    alert("Gagal memproses data!");
                    console.error("Gagal convert to shp" + error);
                }
            };
            const containerElement = document.getElementById("Cbuttons");
            containerElement.appendChild(btnshp);
        } catch (error) {
            $("#btnshp").removeAttr("#btnshp");
            console.error(error);
        }
        try {
            const btnplot = document.createElement("a");
            btnplot.innerHTML = " Export";
            btnplot.id = "btnplot";
            btnplot.className = "bi bi-cloud-arrow-down asbn btn btn-primary m-md-3";
            btnplot.onclick = function() {
                printControl.print();
            };
            const containerElement = document.getElementById("Cbuttons");
            containerElement.appendChild(btnplot);
        } catch (error) {
            $("#btnplot").removeAttr("#btnplot");
            console.error(error);
        }


        // style vector geometry
        const markerStyle = new ol.style.Style({
            image: new ol.style.Icon({
                anchor: [0.5, 1],
                anchorXUnits: 'fraction',
                anchorYUnits: 'fraction',
                opacity: 1,
                src: '/mapSystem/images/marker-icon.png',
                scale: 0.8,
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
                color: 'rgba(210, 0, 0, 0.4)',
            }),
            stroke: new ol.style.Stroke({
                color: 'red',
                width: 2,
            }),
        });
        // style vector geometry eksisting
        const markerStyleEks = new ol.style.Style({
            image: new ol.style.Icon({
                anchor: [0.5, 1],
                anchorXUnits: 'fraction',
                anchorYUnits: 'fraction',
                opacity: 1,
                src: '/mapSystem/images/marker-icon2.png',
                scale: 0.8,
            })
        });
        const lineStyleEks = new ol.style.Style({
            stroke: new ol.style.Stroke({
                color: 'rgba(255, 191, 0)',
                width: 2,
            }),
        });
        const polygonStyleEks = new ol.style.Style({
            fill: new ol.style.Fill({
                color: 'rgba(255, 191, 0, 0.7)',
            }),
            stroke: new ol.style.Stroke({
                color: 'rgba(255, 191, 0)',
                width: 2,
            }),
        });

        var styleDraw;
        let geometryType = geojson.features[0].geometry.type;
        if (geometryType == "Point") {
            styleDraw = markerStyle;
        } else if (geometryType == "Polygon") {
            styleDraw = polygonStyle;
        } else {
            styleDraw = lineStyle;
        }
        let vectorSource = new ol.source.Vector({
            features: new ol.format.GeoJSON().readFeatures(geojson, {
                featureProjection: 'EPSG:3857', // Proyeksi EPSG:3857 (Web Mercator)
            })
        });
        let vectorLayer = new ol.layer.Vector({
            source: vectorSource,
            style: styleDraw,
            name: 'Data Pemohon',
            zIndex: 5
        });
        const projection = new ol.proj.Projection({
            code: 'EPSG:54034',
            units: 'm',
            axisOrientation: 'neu'
        });

        // BaseMap
        const osmBaseMap = new ol.layer.Tile({
            title: 'Open Street Map',
            type: 'base',
            source: new ol.source.OSM(),
            crossOrigin: 'anonymous',
            visible: true,
            baseLayer: true,
        });

        const sourceBingMaps = new ol.source.BingMaps({
            key: 'AjQ2yJ1-i-j_WMmtyTrjaZz-3WdMb2Leh_mxe9-YBNKk_mz1cjRC7-8ILM7WUVEu',
            imagerySet: 'AerialWithLabels',
            maxZoom: 20,
        });
        const bingAerialBaseMap = new ol.layer.Tile({
            title: 'Bing Aerial',
            type: 'base',
            preload: Infinity,
            source: sourceBingMaps,
            crossOrigin: 'anonymous',
            visible: false,
            baseLayer: true,
        });

        const mapboxBaseURL = 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiNjg2MzUzMyIsImEiOiJjbDh4NDExZW0wMXZsM3ZwODR1eDB0ajY0In0.6jHWxwN6YfLftuCFHaa1zw';
        const mapboxStyleId = 'mapbox/streets-v11';
        const mapboxSource = new ol.source.XYZ({
            url: mapboxBaseURL.replace('{id}', mapboxStyleId),
        });
        const mapboxBaseMap = new ol.layer.Tile({
            title: 'MapBox Road',
            type: 'base',
            visible: false,
            source: mapboxSource,
            crossOrigin: 'anonymous',
            baseLayer: true,
        });

        const baseMaps = new ol.layer.Group({
            title: 'Base Layers',
            openInLayerSwitcher: true,
            layers: [
                osmBaseMap, bingAerialBaseMap, mapboxBaseMap
            ]
        });

        // Init To Canvas/View
        const view = new ol.View({
            center: ol.proj.fromLonLat([<?= $lat; ?>, <?= $lon; ?>]),
            zoom: <?= $zoomView; ?>,
            Projection: projection
        });
        const map = new ol.Map({
            layers: baseMaps,
            target: 'map',
            controls: [
                //Define the default controls
                new ol.control.Zoom(),
                new ol.control.Attribution(),
                //Define some new controls
                new ol.control.ScaleLine(),

            ],
            view: view,
        });
        const mainMap = map;

        var layerSwitcher = new ol.control.LayerSwitcher({
            tipLabel: 'Legend', // Optional label for button
            groupSelectStyle: 'children' // Can be 'children' [default], 'group' or 'none'
        });
        map.addControl(layerSwitcher);
        map.addLayer(vectorLayer);

        // Add a title control
        map.addControl(new ol.control.CanvasTitle({
            title: 'my title',
            visible: false,
            style: new ol.style.Style({
                text: new ol.style.Text({
                    font: '24px Verdana,Geneva,Lucida,Arial,Helvetica,sans-serif'
                })
            })
        }));
        var legend = new ol.legend.Legend({
            title: 'Legenda',
            margin: 5,
            items: [{
                title: 'Data Pemohon',
                typeGeom: 'Point',
                style: markerStyle,
            }, {
                title: 'Data Pemohon',
                typeGeom: 'LineString',
                style: lineStyle
            }, {
                title: 'Data Pemohon',
                typeGeom: 'Polygon',
                style: polygonStyle
            }, {
                title: 'Data Eksisting Disetujui',
                typeGeom: 'Point',
                style: markerStyleEks,
            }, {
                title: 'Data Eksisting Disetujui',
                typeGeom: 'LineString',
                style: lineStyleEks
            }, {
                title: 'Data Eksisting Disetujui',
                typeGeom: 'Polygon',
                style: polygonStyleEks
            }]
        });
        // Add a legend to the print
        var legendCtrl = new ol.control.Legend({
            legend: legend
        });
        map.addControl(legendCtrl);
        // Add a ScaleLine control 
        map.addControl(new ol.control.CanvasScaleLine());
        // Print control
        var printControl = new ol.control.PrintDialog({
            // target: document.querySelector('.info'),
            // targetDialog: map.getTargetElement(),
            save: true,
            copy: true,
            pdf: true,
            print: false,
        });
        printControl.setSize('A4');
        printControl.setOrientation('landscape');
        printControl.setMargin(5);
        map.addControl(printControl);
        let defaultPrintButton = document.querySelector('.ol-print');
        if (defaultPrintButton) {
            defaultPrintButton.remove();
        }
        /* On print > save image file */
        printControl.on(['print', 'error'], function(e) {
            // Print success
            if (e.image) {
                if (e.pdf) {
                    // Export pdf using the print info
                    var pdf = new jsPDF({
                        orientation: e.print.orientation,
                        unit: e.print.unit,
                        format: e.print.size
                    });
                    pdf.addImage(e.image, 'JPEG', e.print.position[0], e.print.position[0], e.print.imageWidth, e.print.imageHeight);
                    pdf.save(e.print.legend ? 'legend.pdf' : 'Plot.pdf');
                } else {
                    // Save image as file
                    e.canvas.toBlob(function(blob) {
                        var name = (e.print.legend ? 'legend.' : 'Plot.') + e.imageType.replace('image/', '');
                        saveAs(blob, name);
                    }, e.imageType, e.quality);
                }
            } else {
                console.warn('No canvas to export');
            }
        });

        var extent = vectorLayer.getSource().getExtent();
        map.getView().fit(extent, {
            padding: [100, 100, 100, 100],
            minResolution: map.getView().getResolutionForZoom(16),
            duration: 1500,
        });

        let vectorSourceEks = new ol.source.Vector();
        let vectorLayerEks;

        $("#muatEksisting").click(function(e) {
            $("#muatEksisting").addClass("d-none");
            $("#loadMuatEksisting").removeClass("d-none");
            $.ajax({
                type: "GET",
                url: "/data/loadDataEksisting",
                dataType: "json",
            }).done(function(response) {
                $("#muatEksisting").removeClass("d-none");
                $("#loadMuatEksisting").addClass("d-none");
                // console.log(response);
                let data = response;
                let geojsonData = [];
                const allFeaturesPT = [];
                const allFeaturesPL = [];
                const allFeaturesLN = [];
                data.forEach(item => {
                    geojsonData.push(item.lokasi);
                });
                // console.log(geojsonData);
                geojsonData.forEach((geojson) => {
                    geojson = JSON.parse(geojson);
                    // console.log(geojson);
                    // console.log(geojson.features.length);
                    geojson.features.map((feature) => {
                        // console.log(feature);
                        // console.log(feature.geometry.type);
                        if (feature.geometry.type == "Point") {
                            allFeaturesPT.push(feature);
                        } else if (feature.geometry.type == "Polygon") {
                            allFeaturesPL.push(feature);
                        } else {
                            allFeaturesLN.push(feature);
                        }
                    });
                });
                let featureCollectionPT = {
                    "type": "FeatureCollection",
                    "features": allFeaturesPT,
                };
                let featureCollectionPL = {
                    "type": "FeatureCollection",
                    "features": allFeaturesPL,
                };
                let featureCollectionLN = {
                    "type": "FeatureCollection",
                    "features": allFeaturesLN,
                };
                // console.log(featureCollectionPT);
                // console.log(featureCollectionPL);
                // console.log(featureCollectionLN);

                let featuresPT = new ol.format.GeoJSON().readFeatures(featureCollectionPT, {
                    featureProjection: 'EPSG:3857', // Proyeksi EPSG:3857 (Web Mercator)
                });
                let featuresPL = new ol.format.GeoJSON().readFeatures(featureCollectionPL, {
                    featureProjection: 'EPSG:3857', // Proyeksi EPSG:3857 (Web Mercator)
                });
                let featuresLN = new ol.format.GeoJSON().readFeatures(featureCollectionLN, {
                    featureProjection: 'EPSG:3857', // Proyeksi EPSG:3857 (Web Mercator)
                });
                vectorSourceEks.addFeatures(featuresPT);
                vectorSourceEks.addFeatures(featuresPL);
                vectorSourceEks.addFeatures(featuresLN);
                vectorLayerEks = new ol.layer.Vector({
                    source: vectorSourceEks,
                    style: function(features) {
                        if (features.getGeometry().getType() === 'Point') {
                            return markerStyleEks;
                        } else if (features.getGeometry().getType() === 'Polygon') {
                            return polygonStyleEks;
                        } else {
                            return lineStyleEks;
                        }
                    },
                    name: 'Data Telah Disetujui',
                    zIndex: 1
                });

                map.addLayer(vectorLayerEks);
                $("#muatEksisting").prop('disabled', true);
            }).fail(function(error) {
                $("#muatEksisting").removeClass("d-none");
                $("#loadMuatEksisting").addClass("d-none");
                console.error("Error: ", error);
            });
        });

        // Select  interaction
        var select = new ol.interaction.Select({
            hitTolerance: 5,
            multi: true,
            condition: ol.events.condition.singleClick
        });
        map.addInteraction(select);
        // Select control
        var popup = new ol.Overlay.PopupFeature({
            popupClass: 'default anim',
            select: select,
            canFix: true,
            template: function(f) {
                return {
                    // title: function(f) {
                    //     return f.get('NAMA')
                    // },
                    attributes: {
                        NAMA: 'nama',
                        NIK: 'nik',
                        NIB: 'nib',
                        ALAMAT: 'alamat',
                        JNS_KEGIATAN: 'kegiatan',
                    }
                }
            }
        });
        map.addOverlay(popup);

        // KKPRL Layer
        let sidepanel = new ol.control.Control({
            element: document.querySelector(".sidepanel"),
        });
        map.addControl(sidepanel);
        const KKPRL_Layer = [];
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
        for (const layerName of KKPRLLayerNames) {
            const wmsSource = new ol.source.TileWMS({
                url: '<?= $_ENV['BASE_URL_GEOSERVER'] ?>/KKPRL/wms?',
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
                opacity: 0.8,
                displayInLayerSwitcher: false,
            });
            map.addLayer(wms_layer);
            KKPRL_Layer.push(wms_layer);
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
        // Fungsi untuk inisialisasi komunikasi localstorage
        function initializeCheckboxes() {
            if (localStorage.getItem('layer_initialized') !== 'true') {
                saveCheckedStatus();
                localStorage.setItem('layer_initialized', 'true');
            } else {
                restore_czona();
            }
        }
        initializeCheckboxes();


        $("#cekKesesuaian").click(function(e) {
            cekKesesuaian();
            $("#cekKesesuaian").addClass("d-none");
            $("#loadCekKesesuaian").removeClass("d-none");
        });

        function cekKesesuaian() {
            let geoshp;
            let jsonCoordinates;
            let geojsonData;
            var overlappingFeatures;
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
                    console.log("READY!");
                    // console.log(geojson);
                    jsonCoordinates = getCoordinates(geojson);
                    geojsonData = jsonCoordinates;
                    // console.log(geometryType);
                    prosesDetectInput(jsonCoordinates, geometryType, geojsonData);
                    cek();
                }, function(a) {
                    console.log("a" + a)
                });
            } catch (error) {
                console.log(`error: ${error}`);
            }

            function prosesDetectInput(drawn, type = "polygon") {
                overlappingFeatures = [];
                let tot = drawn.length;
                console.log(tot);
                try {
                    for (let ii = 0; ii < tot; ii++) {
                        if (type == "Point" || type == "point") {
                            geoshp.features.forEach(function(layer) {
                                var shapefileGeoJSON = layer;
                                // console.log(shapefileGeoJSON);
                                var geojsonFeature = turf.point(drawn[ii]);
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
                        } else if (type == "line" || type == "Line" || type == "LineString") {
                            geoshp.features.forEach(function(layer) {
                                var shapefileGeoJSON = layer;
                                // console.log(shapefileGeoJSON);
                                var coord = [drawn[ii][0], drawn[ii][1]];
                                var geojsonFeature = turf.lineString(coord);
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
                        } else { //polygon
                            geoshp.features.forEach(function(layer) {
                                var shapefileGeoJSON = layer;
                                // console.log(shapefileGeoJSON);
                                var geojsonFeature = turf.polygon(drawn[ii]);
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
                    }
                } catch (error) {
                    console.log(error);
                    alert("Terjadi kesalahan, mohon ulangi atau reload browser anda");
                }
                // console.log(overlappingID);
                // console.log(overlappingFeatures);
            }

            // Cek kesesuaian dengan jenis kegiatan yang dipilih
            function cek() {
                $(".info_status").html('<img src="/img/loading.gif">');
                let valKegiatan = <?= !empty($tampilDataIzin->id_kegiatan) ? $tampilDataIzin->id_kegiatan : 0; ?>;
                // console.log(valKegiatan);
                let getOverlap = overlappingFeatures;
                // console.log(getOverlap);
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
                // $('#lanjutKirim').prop('disabled', true);
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
                        // console.log(response);
                        let hasil = response.hasil;
                        let valZona = response.valZona;
                        // console.log(valZona);
                        $("#idZona").val(valZona);
                        if (hasil.length !== 0) {
                            let diperbolehkan = hasil.filter(item => item.status === 'diperbolehkan');
                            let diperbolehkanBersyarat = hasil.filter(item => item.status === 'diperbolehkan bersyarat');
                            let tidakDiperbolehkan = hasil.filter(item => item.status === 'tidak diperbolehkan');
                            if (tidakDiperbolehkan.length !== 0) {
                                // $('#lanjutKirim').prop('disabled', true);
                                $(".info_status").html('<p class="tidakBoleh">Aktivitas yang tidak diperbolehkan</p>');
                            } else if (diperbolehkanBersyarat.length !== 0) {
                                // $('#lanjutKirim').prop('disabled', false);
                                $(".info_status").html('<p class="bolehBersyarat">Aktivitas diperbolehkan setelah memperoleh izin</p>');
                            } else {
                                // $('#lanjutKirim').prop('disabled', false);
                                $(".info_status").html('<p class="boleh">Aktivitas yang diperbolehkan</p>');
                            }
                        } else {
                            // $('#lanjutKirim').prop('disabled', false);
                            $(".info_status").html('<p class="">No Data</p>');
                        }
                    })
                    .fail(function(error) {
                        $(".info_status").html('<p class="fs-6">Error!!</p>');
                        console.error('Error:', error);
                    })
            }

            // Fungsi untuk mengambil koordinat dari fitur GeoJSON
            function getCoordinates(geojson) {
                jsonCoordinates = [];
                if (geojson.type === 'FeatureCollection') {
                    // Jika GeoJSON adalah koleksi fitur (multi-fitur)
                    geojson.features.forEach((feature) => {
                        extractCoordinatesFromFeature(feature, jsonCoordinates);
                    });
                } else if (geojson.type === 'Feature') {
                    // Jika GeoJSON adalah fitur tunggal
                    extractCoordinatesFromFeature(geojson, jsonCoordinates);
                } else {
                    console.error('Tipe GeoJSON tidak didukung.');
                }
                // console.log(jsonCoordinates);
                return jsonCoordinates;
            }
            // Fungsi rekursif untuk mengambil koordinat dari fitur
            function extractCoordinatesFromFeature(feature, coordinates) {
                if (feature.geometry) {
                    geometryType = feature.geometry.type;
                    const geometryCoordinates = feature.geometry.coordinates;
                    switch (geometryType) {
                        case 'Point':
                        case 'MultiPoint':
                        case 'LineString':
                        case 'MultiLineString':
                        case 'Polygon':
                        case 'MultiPolygon':
                            coordinates.push(geometryCoordinates);
                            break;
                        case 'GeometryCollection':
                            // Jika fitur berisi koleksi geometri lainnya, ulangi proses untuk setiap geometri
                            geometryCoordinates.forEach((geometry) => {
                                extractCoordinatesFromFeature({
                                    geometry,
                                    type: 'Feature'
                                }, coordinates[0]);
                            });
                            break;
                        default:
                            console.error(`Tipe geometri tidak didukung: ${geometryType}`);
                            break;
                    }
                }
            }
        }
    </script>

</body>

</html>