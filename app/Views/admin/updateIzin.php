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

                                        <form class="row g-3" action="/data/updateAjuan" method="post" enctype="multipart/form-data">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" class="form-control" id="id" aria-describedby="textlHelp" name="id" value="<?= $tampilIzin->id_perizinan; ?>">
                                            <input type="hidden" class="form-control" id="drawPolygon" aria-describedby="textlHelp" name="drawPolygon">

                                            <h5>a. Identitas Pemohon</h5>

                                            <div class="form-group">
                                                <label class="form-label">NIK (Nomor Induk Kependudukan)</label>
                                                <input type="text" class="form-control" id="nik" aria-describedby="textlHelp" name="nik" value="<?= $tampilIzin->nik; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Nama</label>
                                                <input type="text" class="form-control" id="nama" aria-describedby="textlHelp" name="nama" value="<?= $tampilIzin->nama; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Alamat</label>
                                                <input type="text" class="form-control" id="alamat" aria-describedby="textlHelp" name="alamat" value="<?= $tampilIzin->alamat; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">No. Telp/HP</label>
                                                <input type="text" class="form-control" id="kontak" aria-describedby="textlHelp" name="kontak" value="<?= $tampilIzin->kontak; ?>" required>
                                            </div>
                                            <div class="mb-1"></div>

                                            <h5>b. Pengajuan Izin</h5>

                                            <div class="form-group">
                                                <label class="col-md-12 mb-2">Jenis Kegiatan</label>
                                                <select class="form-select" id="pilihKegiatan" name="kegiatan" for="kegiatan" style="width: 100%;" required>
                                                    <option value="<?= $tampilIzin->jenis_kegiatan; ?>"><?= $tampilIzin->jenis_kegiatan; ?></option>
                                                    <option value="Kegiatan A1">Kegiatan A1</option>
                                                    <option value="Kegiatan A2">Kegiatan A2</option>
                                                    <option value="Kegiatan A3">Kegiatan A3</option>
                                                    <option value="Kegiatan A4">Kegiatan A4</option>
                                                    <option value="Kegiatan A5">Kegiatan A5</option>
                                                    <option value="Kegiatan B1">Kegiatan B1</option>
                                                    <option value="Kegiatan B2">Kegiatan B2</option>
                                                    <option value="Kegiatan B3">Kegiatan B3</option>
                                                    <option value="Kegiatan B4">Kegiatan B4</option>
                                                    <option value="Kegiatan AA1">Kegiatan AA1</option>
                                                    <option value="Kegiatan AA2">Kegiatan AA2</option>
                                                    <option value="Kegiatan AA3">Kegiatan AA3</option>
                                                    <option value="Kegiatan AA4">Kegiatan AA4</option>
                                                    <option value="Kegiatan AA5">Kegiatan AA5</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Masukkan Lokasi</label>
                                                <div class="row g-2">
                                                    <div class="col col-md-6">
                                                        <input type="text" class="form-control" id="longitude" aria-describedby="textlHelp" placeholder="longitude" name="longitude" value="<?= $tampilIzin->longitude; ?>" required>
                                                    </div>
                                                    <div class="col col-md-6">
                                                        <input type="text" class="form-control" id="latitude" aria-describedby="textlHelp" placeholder="latitude" name="latitude" value="<?= $tampilIzin->latitude; ?>" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="feedback">Keterangan Kesesuaian:</div>
                                            <div class="info">
                                                <div class="feedback" id="showKegiatan"> </div>
                                            </div>

                                            <button type="submit" class="btn btn-primary">Kirim</button>
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
            $('.form-select').select2({
                placeholder: "Pilih Kegiatan",
                allowClear: true
            });
        });
    </script>
    <script>
        function detectKegiatan() {
            var kegiatanValue = $('#pilihKegiatan').val();
            var boleh = ["Kegiatan AA1", "Kegiatan A1", "Kegiatan B1", "Kegiatan AA3", "Kegiatan A3", "Kegiatan B3"];
            var bolehBesyarat = ["Kegiatan AA2", "Kegiatan A2", "Kegiatan B2", "Kegiatan AA4", "Kegiatan A4", "Kegiatan B4"];
            var tidakBoleh = ["Kegiatan A5", "Kegiatan AA5"];
            var showKegiatan = $('#showKegiatan');

            showKegiatan.removeClass().addClass('feedback');
            if (boleh.includes(kegiatanValue)) {
                showKegiatan.text('Diperbolehkan').addClass('boleh');
            } else if (bolehBesyarat.includes(kegiatanValue)) {
                showKegiatan.text('Diperbolehkan Bersyarat').addClass('bolehBersyarat');
            } else if (tidakBoleh.includes(kegiatanValue)) {
                showKegiatan.text('Tidak diperbolehkan').addClass('tidakBoleh');
            } else {
                showKegiatan.text('');
            }
        }
        detectKegiatan();
        $('#pilihKegiatan').change(function() {
            detectKegiatan();
        })
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
        var map = L.map('map', {
            center: [<?= $tampilIzin->latitude; ?>, <?= $tampilIzin->longitude; ?>],
            zoom: 10,
            layers: [peta1],
            attributionControl: false,
            gestureHandling: true,
        })


        // controller
        var baseLayers = {
            "Map": peta1,
            "Satellite": peta2,
            "OSM": peta3,
        };

        L.control.layers(baseLayers).addTo(map);
        L.control.mousePosition().addTo(map);
        L.control.scale().addTo(map);
    </script>


</body>

</html>