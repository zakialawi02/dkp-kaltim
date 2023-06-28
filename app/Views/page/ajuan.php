<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title><?= $title; ?></title>
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="/img/favicon.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <!-- Css assets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css" integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
    <link href="/leaflet/L.Control.MousePosition.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="/assets/css/style.css" rel="stylesheet">

    <style>
        #map {
            height: 60vh;
        }
    </style>

</head>

<body>

    <!-- HEADER -->
    <?= $this->include('_Layout/_template/_umum/header'); ?>



    <!-- ISI CONTENT -->
    <section class="contact" id="contact">

        <div class="container">
            <h4>Lengkapi Data Pengajuan Izin/Perizinan</h4>


            <div class="row g-2">
                <div class="col col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            <form class="row g-3" action="/data/tambahAjuan" method="post" enctype="multipart/form-data">
                                <?= csrf_field(); ?>
                                <?php $datas = session()->getFlashdata('data'); ?>
                                <input type="hidden" class="form-control" id="drawPolygon" aria-describedby="textlHelp" name="drawPolygon">

                                <h5>a. Identitas Pemohon</h5>

                                <div class="form-group">
                                    <label class="form-label">NIK (Nomor Induk Kependudukan)</label>
                                    <input type="text" class="form-control" id="nik" aria-describedby="textlHelp" name="nik" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="nama" aria-describedby="textlHelp" name="nama" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Alamat</label>
                                    <input type="text" class="form-control" id="alamat" aria-describedby="textlHelp" name="alamat" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">No. Telp/HP</label>
                                    <input type="text" class="form-control" id="kontak" aria-describedby="textlHelp" name="kontak" required>
                                </div>
                                <div class="mb-1"></div>

                                <h5>b. Pengajuan Izin</h5>

                                <div class="form-group">
                                    <label class="col-md-12 mb-2">Jenis Kegiatan</label>
                                    <select class="form-select" id="pilihKegiatan" name="kegiatan" for="kegiatan" style="width: 100%;" required>
                                        <option value="<?= $datas['kegiatanValue']; ?>"><?= $datas['kegiatanValue']; ?></option>
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
                                            <input type="text" class="form-control" id="longitude" aria-describedby="textlHelp" placeholder="longitude" name="longitude" value="" required>
                                        </div>
                                        <div class="col col-md-6">
                                            <input type="text" class="form-control" id="latitude" aria-describedby="textlHelp" placeholder="latitude" name="latitude" value="" required>
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
                <div class="col col-lg-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="map" id="map"></div>
                            <div id="koordinat"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>


    <!-- END ISI CONTENT -->



    <!-- FOOTER -->
    <?= $this->include('_Layout/_template/_umum/footer'); ?>



    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Template Javascript -->
    <script src="/assets/js/main.js"></script>

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

    <!-- Leaflet Component -->
    <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js" integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg=" crossorigin=""></script>
    <script src="https://unpkg.com/geojson-vt@3.2.0/geojson-vt.js"></script>
    <script src="/leaflet/leaflet.ajax.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-tilelayer-geojson/1.0.2/TileLayer.GeoJSON.min.js"></script>
    <script src="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-omnivore/v0.3.1/leaflet-omnivore.min.js"></script>
    <script src="/leaflet/L.Control.MousePosition.js"></script>
    <script src="/leaflet/catiline.js"></script>
    <script src="/leaflet/leaflet.shpfile.js"></script>
    <script src="/leaflet/shp.js"></script>
    <script src='https://unpkg.com/@turf/turf@6/turf.min.js'></script>


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

        var drawnPolygon = L.polygon(<?= $datas['geojson']; ?>).addTo(map);
        var centroid = turf.points(<?= $datas['geojson']; ?>);
        var center = turf.center(centroid);
        $('#latitude').val(center.geometry.coordinates[0]);
        $('#longitude').val(center.geometry.coordinates[1]);
        $("#drawPolygon").val(<?= $datas['geojson']; ?>);




        // shapefile untuk batas admin detectme()
        var geoshp = L.geoJson({
            features: []
        }, );

        var wfunc = function(base, cb) {
            importScripts('/leaflet/shp.js');
            shp(base).then(cb);
        }
        var worker = cw({
            data: wfunc
        }, 2);
        worker.data(cw.makeUrl('/geojson/batas_kelurahan_2021_sby_357820220801090416.zip')).then(function(data) {
            geoshp.addData(data);
        }, function(a) {
            console.log(a)
        });

        var polygon = geoshp.toGeoJSON();
        console.log(polygon);
    </script>

</body>

</html>