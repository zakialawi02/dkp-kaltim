<!DOCTYPE html>
<html lang="en">

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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Template Main CSS File -->
    <link href="/css/StyleAdmin.css" rel="stylesheet" />

    <!-- leaflet Component -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css" integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
    <link href="/leaflet/L.Control.MousePosition.css" rel="stylesheet">
    <link rel="stylesheet" href="//unpkg.com/leaflet-gesture-handling/dist/leaflet-gesture-handling.min.css" type="text/css">

    <style>
        #map {
            height: 70vh;
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

                    <div class="mb-4 mt-2">
                        <div class="pagetitle">
                            <h1><?= $title; ?></h1>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card">

                                    <div class="card-body">
                                        <h4 class="card-title">Edit Data</h4>


                                        <form class="row g-3" action="/admin/update_Kafe" method="post" enctype="multipart/form-data">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" class="form-control" for="id" id="id" name="id" value="<?= $tampilKafe->id_kafe; ?>">
                                            <input type="hidden" class="form-control" for="wilayahLama" id="wilayahLama" name="wilayahLama" value="<?= $tampilKafe->id_kelurahan; ?>">
                                            <?php foreach ($getFoto as $fotoKafe) : ?>
                                                <input type="hidden" class="form-control" for="fotoKafeLama" id="fotoKafeLama" name="fotoKafeLama[]" value="<?= $fotoKafe->nama_file_foto; ?>">
                                            <?php endforeach ?>

                                            <div class="">
                                                <label for="nama_kafe" class="form-label">Nama Kafe</label>
                                                <input type="text" class="form-control" id="nama_kafe" aria-describedby="textlHelp" name="nama_kafe" value="<?= $tampilKafe->nama_kafe; ?>">
                                            </div>
                                            <div class="">
                                                <label for="alamat_kafe" class="form-label">Alamat Kafe</label>
                                                <input type="text" class="form-control" id="alamat_kafe" aria-describedby="textlHelp" name="alamat_kafe" value="<?= $tampilKafe->alamat_kafe; ?>">
                                            </div>
                                            <div class="row g-2">
                                                <label for="koordinat" class="">Koordinat</label>
                                                <div class="form-group col-md-5">
                                                    <label for="latitude" class="">Latitude</label>
                                                    <input type="text" class="form-control" id="latitude" aria-describedby="textlHelp" name="latitude" value="<?= $tampilKafe->latitude; ?>" placeholder="-7.0385384" pattern="/^(\-?\d+(\.\d+)?)$/" title="Tuliskan Sesuai Format" required>
                                                </div>
                                                <div class="form-group col-md-5">
                                                    <label for="longitude" class="">Longitude</label>
                                                    <input type="text" class="form-control" id="longitude" aria-describedby="textlHelp" name="longitude" value="<?= $tampilKafe->longitude; ?>" placeholder="112.8998345" pattern="/^[^a-zA-Z]*(\-?\d+(\.\d+)?)$/" title="Tuliskan Sesuai Format" required>
                                                </div>
                                                <div class="col-md gps">
                                                    <button type="button" role="button" onclick="mygps()" id="myLoc" class="btn btn-primary bi bi-geo-alt" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Gunakan lokasi saya sekarang (GPS)"></button>
                                                </div>
                                                <div id="FileHelp" class="form-text"><span style="font-weight: bold;">NOTE:</span> Ketikan Koordinat Latitude dan Longitude atau klik lokasi pada peta atau gunakan lokasi anda sekarang (gps)</div>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">Wilayah Administrasi</label>
                                                <select class="form-control" id="wilayah" name="wilayah" value="">
                                                    <option value="<?= $tampilKafe->id_kelurahan; ?>"><?= $tampilKafe->nama_kelurahan; ?>, Kec. <?= $tampilKafe->nama_kecamatan; ?>, <?= $tampilKafe->nama_kabupaten; ?></option>

                                                </select>
                                            </div>

                                            <label for="instagram_kafe" class="form-label">Instagram</label>
                                            <div class="input-group form-group mt-1">
                                                <span class="input-group-text" id="basic-addon1">@</span>
                                                <input type="text" class="form-control" id="instagram_kafe" name="instagram_kafe" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" value="<?= $tampilKafe->instagram_kafe; ?>">
                                            </div>

                                            <?php $oprasional = json_decode($tampilKafe->jam_oprasional); ?>

                                            <div class="form-group">
                                                <label for="jam-oprasional" class="form-label">Waktu Oprasional</label>
                                                <div class="row mb-3">
                                                    <div class="col-4">
                                                        <h5 id="dayTitle">Senin</h5>
                                                        <label class="toggle toggle-alternative">
                                                            <input type="checkbox" id="checkboxB1" class="checkbox" name="day[]" onclick="senin()" <?= (!empty($oprasional['0']->open_time)) ? 'checked' : ''; ?> />
                                                            <span class="toggle-text"></span>
                                                            <span class="toggle-handle"></span>
                                                        </label>
                                                    </div>
                                                    <div class="row col" id="jamSenin" style="<?= (!empty($oprasional['0']->open_time)) ? '' : 'display:none;'; ?>;">
                                                        <div class="col">
                                                            <label for="open-time">Jam Buka:</label>
                                                            <input type="time" class="form-control" id="openSenin" name="open-time[]" value="<?= $oprasional['0']->open_time; ?>">
                                                        </div>
                                                        <div class="col">
                                                            <label for="close-time">Jam Tutup:</label>
                                                            <input type="time" class="form-control" id="closeSenin" name="close-time[]" value="<?= $oprasional['0']->close_time; ?>">
                                                        </div>
                                                        <a class="btn btn-primary mt-2" onclick="setTimeToMonday()" role=" button">Terapkan Ke Semua Hari</a>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-4">
                                                        <h5 id="dayTitle">Selasa</h5>
                                                        <label class="toggle toggle-alternative">
                                                            <input type="checkbox" id="checkboxB" class="checkbox" name="day[]" onclick="Selasa()" <?= (!empty($oprasional['1']->open_time)) ? 'checked' : ''; ?> />
                                                            <span class="toggle-text"></span>
                                                            <span class="toggle-handle"></span>
                                                        </label>
                                                    </div>
                                                    <div class="row col" id="jamSelasa" style="<?= (!empty($oprasional['1']->open_time)) ? '' : 'display:none;'; ?>;">
                                                        <div class="col">
                                                            <label for="open-time">Jam Buka:</label>
                                                            <input type="time" class="form-control" id="openSelasa" name="open-time[]" value="<?= $oprasional['1']->open_time; ?>">
                                                        </div>
                                                        <div class="col">
                                                            <label for="close-time">Jam Tutup:</label>
                                                            <input type="time" class="form-control" id="closeSelasa" name="close-time[]" value="<?= $oprasional['1']->close_time; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-4">
                                                        <h5 id="dayTitle">Rabu</h5>
                                                        <label class="toggle toggle-alternative">
                                                            <input type="checkbox" id="checkboxB" class="checkbox" name="day[]" onclick="Rabu()" <?= (!empty($oprasional['2']->open_time)) ? 'checked' : ''; ?> />
                                                            <span class="toggle-text"></span>
                                                            <span class="toggle-handle"></span>
                                                        </label>
                                                    </div>
                                                    <div class="row col" id="jamRabu" style="<?= (!empty($oprasional['2']->open_time)) ? '' : 'display:none;'; ?>;">
                                                        <div class="col">
                                                            <label for="open-time">Jam Buka:</label>
                                                            <input type="time" class="form-control" id="openRabu" name="open-time[]" value="<?= $oprasional['2']->open_time; ?>">
                                                        </div>
                                                        <div class="col">
                                                            <label for="close-time">Jam Tutup:</label>
                                                            <input type="time" class="form-control" id="closeRabu" name="close-time[]" value="<?= $oprasional['2']->close_time; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-4">
                                                        <h5 id="dayTitle">Kamis</h5>
                                                        <label class="toggle toggle-alternative">
                                                            <input type="checkbox" id="checkboxB" class="checkbox" name="day[]" onclick="Kamis()" <?= (!empty($oprasional['3']->open_time)) ? 'checked' : ''; ?> />
                                                            <span class="toggle-text"></span>
                                                            <span class="toggle-handle"></span>
                                                        </label>
                                                    </div>
                                                    <div class="row col" id="jamKamis" style="<?= (!empty($oprasional['3']->open_time)) ? '' : 'display:none;'; ?>;">
                                                        <div class="col">
                                                            <label for="open-time">Jam Buka:</label>
                                                            <input type="time" class="form-control" id="openKamis" name="open-time[]" value="<?= $oprasional['3']->open_time; ?>">
                                                        </div>
                                                        <div class="col">
                                                            <label for="close-time">Jam Tutup:</label>
                                                            <input type="time" class="form-control" id="closeKamis" name="close-time[]" value="<?= $oprasional['3']->close_time; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-4">
                                                        <h5 id="dayTitle">Jum'at</h5>
                                                        <label class="toggle toggle-alternative">
                                                            <input type="checkbox" id="checkboxB" class="checkbox" name="day[]" onclick="Jumat()" <?= (!empty($oprasional['4']->open_time)) ? 'checked' : ''; ?> />
                                                            <span class="toggle-text"></span>
                                                            <span class="toggle-handle"></span>
                                                        </label>
                                                    </div>
                                                    <div class="row col" id="jamJumat" style="<?= (!empty($oprasional['4']->open_time)) ? '' : 'display:none;'; ?>;">
                                                        <div class="col">
                                                            <label for="open-time">Jam Buka:</label>
                                                            <input type="time" class="form-control" id="openJumat" name="open-time[]" value="<?= $oprasional['4']->open_time; ?>">
                                                        </div>
                                                        <div class="col">
                                                            <label for="close-time">Jam Tutup:</label>
                                                            <input type="time" class="form-control" id="closeJumat" name="close-time[]" value="<?= $oprasional['4']->close_time; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-4">
                                                        <h5 id="dayTitle">Sabtu</h5>
                                                        <label class="toggle toggle-alternative">
                                                            <input type="checkbox" id="checkboxB" class="checkbox" name="day[]" onclick="Sabtu()" <?= (!empty($oprasional['5']->open_time)) ? 'checked' : ''; ?> />
                                                            <span class="toggle-text"></span>
                                                            <span class="toggle-handle"></span>
                                                        </label>
                                                    </div>
                                                    <div class="row col" id="jamSabtu" style="<?= (!empty($oprasional['5']->open_time)) ? '' : 'display:none;'; ?>;">
                                                        <div class="col">
                                                            <label for="open-time">Jam Buka:</label>
                                                            <input type="time" class="form-control" id="openSabtu" name="open-time[]" value="<?= $oprasional['5']->open_time; ?>">
                                                        </div>
                                                        <div class="col">
                                                            <label for="close-time">Jam Tutup:</label>
                                                            <input type="time" class="form-control" id="closeSabtu" name="close-time[]" value="<?= $oprasional['5']->close_time; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-4">
                                                        <h5 id="dayTitle">Minggu</h5>
                                                        <label class="toggle toggle-alternative">
                                                            <input type="checkbox" id="checkboxB" class="checkbox" name="day[]" onclick="Minggu()" <?= (!empty($oprasional['6']->open_time)) ? 'checked' : ''; ?> />
                                                            <span class="toggle-text"></span>
                                                            <span class="toggle-handle"></span>
                                                        </label>
                                                    </div>
                                                    <div class="row col" id="jamMinggu" style="<?= (!empty($oprasional['6']->open_time)) ? '' : 'display:none;'; ?>;">
                                                        <div class="col">
                                                            <label for="open-time">Jam Buka:</label>
                                                            <input type="time" class="form-control" id="openMinggu" name="open-time[]" value="<?= $oprasional['6']->open_time; ?>">
                                                        </div>
                                                        <div class="col">
                                                            <label for="close-time">Jam Tutup:</label>
                                                            <input type="time" class="form-control" id="closeMinggu" name="close-time[]" value="<?= $oprasional['6']->close_time; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="formFile" class="form-label">Tambah Foto Kafe</label>
                                                <input class="form-control" type="file" name="foto_kafe[]" id="foto_kafe" accept="image/*" multiple>
                                                <div id="FileHelp" class="form-text">.jpg/.png</div>
                                                <div id="imgPreview"></div>
                                                <div id="image">
                                                    <?php foreach ($getFoto as $fotoKafe) { ?>
                                                        <div class="img-box" id="imgb_<?= $fotoKafe->id; ?>">
                                                            <img class="img-kafeEdit" src="<?= base_url('/img/kafe/' . $fotoKafe->nama_file_foto); ?>">
                                                            <a href="javascript:void(0);" class="dellbut badge bg-danger btn-delete" data-id="<?= $fotoKafe->id; ?>" data-kafe="<?= $fotoKafe->id_kafe; ?>" onclick=" deleteImage('<?= $fotoKafe->id; ?>')">Hapus</a>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>



                                            <button type="submit" onclick="submitWaktu()" class="btn btn-primary">Submit</button>
                                        </form>

                                    </div>
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="card card-title">
                                    <div class="card-body">
                                        <div class="map" id="map"></div>
                                        <span id="koordinat"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </section>

                </div>

            </main><!-- End #main -->

            <!-- FOOTER -->
            <?= $this->include('_Layout/_template/_admin/footer'); ?>
        </div>
    </div>



    <!-- Vendor JS Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://kit.fontawesome.com/816b3ace5c.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/proj4js/1.1.0/proj4js-compressed.min.js"></script>

    <!-- Template Main JS File -->
    <script src="/js/Scripts.js"></script>

    <script>
        $(document).ready(function() {
            $(".alert");
            setTimeout(function() {
                $(".alert").fadeOut(800);
            }, 2500);
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#wilayah').select2({
                ajax: {
                    url: "<?= base_url('admin/getDataAjaxRemote') ?>",
                    dataType: "json",
                    type: "POST",
                    delay: 300,
                    data: function(params) {
                        console.log(params.term);
                        return {
                            search: params.term,
                        }
                    },
                    processResults: function(data, page) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                placeholder: 'Ketik nama desa atau kecamatan',
                minimumInputLength: 3,
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Ketika tombol di klik, kirim request Ajax
            $(document).on('click', '.btn-delete', function(e) {
                var result = confirm("Are you sure to delete?");
                // ambil ID gambar dari atribut data-id tombol
                var id = $(this).data('id');
                var kafe = $(this).data('kafe');

                // kirim request Ajax ke server
                $.ajax({
                    url: '<?= base_url('Admin/deleteImage') ?>', // URL untuk memproses delete
                    type: 'POST', // metode request POST atau GET
                    cache: false,
                    data: {
                        id: id,
                        kafe: kafe
                    }, // data yang akan dikirim ke server
                    success: function(response) {
                        // jalankan logic setelah menerima response dari server
                        console.log(response);
                        $('#image').load("<?php echo base_url(); ?>/admin/previewImg/<?= $tampilKafe->id_kafe; ?>");
                    }
                });
            });
        });
    </script>
    <script>
        function readURL(input) {
            if (input.files) {
                $('#imgPreview').html(''); // mengosongkan preview
                for (var i = 0; i < input.files.length; i++) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imgPreview').append('<div><img src="' + e.target.result + '" class="img-kafeEdit"></div>');
                    }
                    reader.readAsDataURL(input.files[i]);
                }
            }
        }
        $("#foto_kafe").change(function() {
            readURL(this);
        });
        // $('#imgPreview').on('click', '.remove-preview', function() {
        //     $(this).parent().remove(); // menghapus preview yang dipilih
        // });
    </script>
    <script>
        function setTimeToMonday() {
            // ambil nilai dari input time hari Senin
            var openTimeMonday = document.getElementById('openSenin').value;
            var closeTimeMonday = document.getElementById('closeSenin').value;

            // ubah nilai dari input time hari Selasa
            document.getElementById('openSelasa').value = openTimeMonday;
            document.getElementById('closeSelasa').value = closeTimeMonday;
            document.getElementById('openRabu').value = openTimeMonday;
            document.getElementById('closeRabu').value = closeTimeMonday;
            document.getElementById('openKamis').value = openTimeMonday;
            document.getElementById('closeKamis').value = closeTimeMonday;
            document.getElementById('openJumat').value = openTimeMonday;
            document.getElementById('closeJumat').value = closeTimeMonday;
            document.getElementById('openSabtu').value = openTimeMonday;
            document.getElementById('closeSabtu').value = closeTimeMonday;
            document.getElementById('openMinggu').value = openTimeMonday;
            document.getElementById('closeMinggu').value = closeTimeMonday;
        }

        function submitWaktu() {
            var senin = document.getElementById("jamSenin");
            var clear = document.getElementById("openSenin");
            var clears = document.getElementById("closeSenin");
            if (senin.style.display === "none") {
                clear.value = "";
                clears.value = "";
            }
            var selasa = document.getElementById("jamSelasa");
            var clear = document.getElementById("openSelasa");
            var clears = document.getElementById("closeSelasa");
            if (selasa.style.display === "none") {
                clear.value = "";
                clears.value = "";
            }
            var Rabu = document.getElementById("jamRabu");
            var clear = document.getElementById("openRabu");
            var clears = document.getElementById("closeRabu");
            if (Rabu.style.display === "none") {
                clear.value = "";
                clears.value = "";
            }
            var Kamis = document.getElementById("jamKamis");
            var clear = document.getElementById("openKamis");
            var clears = document.getElementById("closeKamis");
            if (Kamis.style.display === "none") {
                clear.value = "";
                clears.value = "";
            }
            var Jumat = document.getElementById("jamJumat");
            var clear = document.getElementById("openJumat");
            var clears = document.getElementById("closeJumat");
            if (Jumat.style.display === "none") {
                clear.value = "";
                clears.value = "";
            }
            var Sabtu = document.getElementById("jamSabtu");
            var clear = document.getElementById("openSabtu");
            var clears = document.getElementById("closeSabtu");
            if (Sabtu.style.display === "none") {
                clear.value = "";
                clears.value = "";
            }
            var Minggu = document.getElementById("jamMinggu");
            var clear = document.getElementById("openMinggu");
            var clears = document.getElementById("closeMinggu");
            if (Minggu.style.display === "none") {
                clear.value = "";
                clears.value = "";
            }
        }

        function senin() {
            var senin = document.getElementById("jamSenin");
            var clear = document.getElementById("openSenin");
            var clears = document.getElementById("closeSenin");
            if (senin.style.display === "none") {
                senin.style.display = "";
                clear.value = "";
                clears.value = "";
            } else {
                senin.style.display = "none";
            }
        }

        function Selasa() {
            var Selasa = document.getElementById("jamSelasa")
            var clear = document.getElementById("openSelasa");;
            var clears = document.getElementById("closeSelasa");;
            if (Selasa.style.display === "none") {
                Selasa.style.display = "";
                clear.value = "";
                clears.value = "";
            } else {
                Selasa.style.display = "none";
            }
        }

        function Rabu() {
            var Rabu = document.getElementById("jamRabu");
            var clear = document.getElementById("openRabu");
            var clears = document.getElementById("closeRabu");
            if (Rabu.style.display === "none") {
                Rabu.style.display = "";
                clear.value = "";
                clears.value = "";
            } else {
                Rabu.style.display = "none";
            }
        }

        function Kamis() {
            var Kamis = document.getElementById("jamKamis");
            var clear = document.getElementById("openKamis");
            var clears = document.getElementById("closeKamis");
            if (Kamis.style.display === "none") {
                Kamis.style.display = "";
                clear.value = "";
                clears.value = "";
            } else {
                Kamis.style.display = "none";
            }
        }

        function Jumat() {
            var Jumat = document.getElementById("jamJumat");
            var clear = document.getElementById("openJumat");
            var clears = document.getElementById("closeJumat");
            if (Jumat.style.display === "none") {
                Jumat.style.display = "";
                clear.value = "";
                clears.value = "";
            } else {
                Jumat.style.display = "none";
            }
        }

        function Sabtu() {
            var Sabtu = document.getElementById("jamSabtu");
            var clear = document.getElementById("openSabtu");
            var clears = document.getElementById("closeSabtu");
            if (Sabtu.style.display === "none") {
                Sabtu.style.display = "";
                clear.value = "";
                clears.value = "";
            } else {
                Sabtu.style.display = "none";
            }
        }

        function Minggu() {
            var Minggu = document.getElementById("jamMinggu");
            var clear = document.getElementById("openMinggu");
            var clears = document.getElementById("closeMinggu");
            if (Minggu.style.display === "none") {
                Minggu.style.display = "";
                clear.value = "";
                clears.value = "";
            } else {
                Minggu.style.display = "none";
            }
        }
    </script>


    <!-- Js Leaflet Setting -->
    <!-- Leafleat js Component -->
    <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js" integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg=" crossorigin=""></script>
    <script src="https://unpkg.com/geojson-vt@3.2.0/geojson-vt.js"></script>
    <script src="/leaflet/leaflet-geojson-vt.js"></script>
    <script src="/leaflet/leaflet.ajax.min.js"></script>
    <script src="/leaflet/leaflet.ajax.js"></script>
    <script src="/leaflet/L.Control.MousePosition.js"></script>
    <script src="//unpkg.com/leaflet-gesture-handling"></script>

    <!-- Leafleat Setting js-->
    <!-- initialize the map on the "map" div with a given center and zoom -->
    <script>
        // Base map
        var peta1 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiNjg2MzUzMyIsImEiOiJjbDh4NDExZW0wMXZsM3ZwODR1eDB0ajY0In0.6jHWxwN6YfLftuCFHaa1zw', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            maxZoom: 22,
            maxNativeZoom: 19
        });

        var peta2 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiNjg2MzUzMyIsImEiOiJjbDh4NDExZW0wMXZsM3ZwODR1eDB0ajY0In0.6jHWxwN6YfLftuCFHaa1zw', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox/satellite-v9',
            maxZoom: 22,
            maxNativeZoom: 19
        });

        var peta3 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 22,
            maxNativeZoom: 19
        });

        var peta4 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiNjg2MzUzMyIsImEiOiJjbDh4NDExZW0wMXZsM3ZwODR1eDB0ajY0In0.6jHWxwN6YfLftuCFHaa1zw', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox/dark-v10',
            maxZoom: 22,
            maxNativeZoom: 19
        });

        // set frame view
        <?php foreach ($tampilData as $D) : ?>
            var map = L.map('map', {
                center: [<?= $D->coordinat_wilayah; ?>],
                zoom: <?= $D->zoom_view; ?>,
                layers: [peta1],
                attributionControl: false,
                gestureHandling: true,
            })
        <?php endforeach ?>


        // controller
        var baseLayers = {
            "Map": peta1,
            "Satellite": peta2,
            "OSM": peta3,
        };

        L.control.layers(baseLayers).addTo(map);
        L.control.mousePosition().addTo(map);
        L.control.scale().addTo(map);


        // set marker place
        <?php foreach ($tampilKafe as $K) : ?>
            var marker = [<?= $tampilKafe->latitude; ?>, <?= $tampilKafe->longitude; ?>];
        <?php endforeach ?>
        marker = L.marker(marker).addTo(map);


        // set marker place from input
        $(document).ready(function() {
            $("#latitude, #longitude").on('keyup', function() {
                var lat = document.getElementById("latitude").value;
                var lng = document.getElementById("longitude").value;
                if (marker) map.removeLayer(marker);
                marker = L.marker([lat, lng]).addTo(map);
                document.getElementById("koordinat").textContent = koordinat;
                map.panTo(new L.LatLng(lat, lng));
            });
        });

        // get coordinat on map to input
        var koordinat, marker;
        map.on("click", function(e) {
            if (marker) map.removeLayer(marker);
            lat = e.latlng.lat;
            lng = e.latlng.lng;
            koordinat = lat + ", " + lng;
            // console.log(lat);
            // console.log(lng);
            console.log(koordinat);
            marker = L.marker([lat, lng]).addTo(map);
            document.getElementById("koordinat").textContent = koordinat;
            $('#latitude').val(lat);
            $('#longitude').val(lng);
        });

        function mygps() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                alert("Geolokasi tidak didukung oleh peramban ini.");
            }
        }

        function showPosition(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            if (marker) map.removeLayer(marker);
            marker = L.marker([latitude, longitude]).addTo(map);
            $('#latitude').val(latitude);
            $('#longitude').val(longitude);
            map.flyTo([latitude, longitude], 13)
        }
    </script>


</body>

</html>