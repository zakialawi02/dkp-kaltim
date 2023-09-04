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
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />

    <!-- Open Layers Component -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v7.4.0/ol.css">
    <link rel="stylesheet" href="https://unpkg.com/ol-layerswitcher@4.1.1/dist/ol-layerswitcher.css" />

    <!-- Template Main CSS File -->
    <link href="/css/StyleAdmin.css" rel="stylesheet" />

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
                                                <label class="form-label">NIB (Nomor Induk Berusaha)</label>
                                                <input type="text" class="form-control" id="nik" aria-describedby="textlHelp" name="nib" value="<?= $tampilIzin->nib; ?>" required>
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
                                                <select class="form-select" id="pilihKegiatan" name="kegiatan" for="kegiatan" style="width: 100%;" onchange="cek()" required>
                                                    <option></option>
                                                    <?php foreach ($jenisKegiatan as $K) : ?>
                                                        <option value="<?= $K->id_kegiatan ?>" <?= $K->id_kegiatan == $tampilIzin->id_kegiatan ? 'selected' : '' ?>><?= $K->nama_kegiatan ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>

                                            <div class="feedback">Keterangan:</div>
                                            <div class="info_status">
                                                <div class="info_status" id="showKegiatan"> - </div>
                                            </div>

                                            <h5>c. Upload Berkas</h5>

                                            <?php if ($tampilIzin->uploadFiles != null) : ?>
                                                <?php $uploadFiles = explode(",", $tampilIzin->uploadFiles); ?>
                                                <?php foreach ($uploadFiles as $file) : ?>
                                                    <?php $file = trim($file, '()"'); ?>

                                                <?php endforeach ?>
                                                <input type="file" class="filepond" name="filepond[]" value="<?= $file; ?>" multiple />
                                            <?php else : ?>
                                                <input type="file" class="filepond" name="filepond[]" value="" multiple />
                                            <?php endif ?>


                                            <!-- <button type="submit" class="btn btn-primary">Kirim</button> -->
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
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

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
        // Get a file input reference
        const input = document.querySelector('input[type="file"]');

        // Create a FilePond instance
        FilePond.create(input, {
            storeAsFile: true,
            allowMultiple: true,
            credits: false,
        });
    </script>

    <!-- Open Layers Component -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.5.0/proj4.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/ol@v7.4.0/dist/ol.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/elm-pep@1.0.6/dist/elm-pep.js"></script>
    <script src="https://unpkg.com/ol-layerswitcher@4.1.1"></script>

    <script>
        function cek() {
            $(".info_status").html('<img src="/img/loading.gif">');
            let valKegiatan = $('#pilihKegiatan').val();
        }
    </script>

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

        let geojson = <?= $tampilIzin->lokasi; ?>;
        // console.log(geojson);

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
        var styleDraw;
        if (geojson.geometry.type == "Point") {
            styleDraw = markerStyle;
        } else if (geojson.geometry.type == "LineString") {
            styleDraw = lineStyle;
        } else {
            styleDraw = polygonStyle;
        }
        let vectorSource = new ol.source.Vector({
            features: new ol.format.GeoJSON().readFeatures(geojson, {
                featureProjection: 'EPSG:3857', // Proyeksi EPSG:3857 (Web Mercator)
            })
        });
        let vectorLayer = new ol.layer.Vector({
            source: vectorSource,
            style: styleDraw,
        });
        const projection = new ol.proj.Projection({
            code: 'EPSG:32750',
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
        });

        const baseMaps = [osmBaseMap, bingAerialBaseMap, mapboxBaseMap];

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
        var extent = vectorLayer.getSource().getExtent();
        map.getView().fit(extent, {
            padding: [100, 100, 100, 100],
            minResolution: map.getView().getResolutionForZoom(13),
            duration: 1500,
        });
    </script>

</body>

</html>