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
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="/assets/css/style.css" rel="stylesheet">

    <!-- Open Layers Component -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v7.4.0/ol.css">
    <link rel="stylesheet" href="https://unpkg.com/ol-layerswitcher@4.1.1/dist/ol-layerswitcher.css" />

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
            <h4>Lengkapi Data Pengajuan Informasi</h4>


            <div class="row g-2">
                <div class="col col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            <form class="row g-3" action="/data/tambahAjuan" method="post" enctype="multipart/form-data">
                                <?= csrf_field(); ?>
                                <?php
                                $datas = session()->getFlashdata('data');
                                $geojson = json_decode($datas['geojson']);
                                $getOverlap = json_decode($datas['getOverlap']);
                                $valZona = json_decode($datas['valZona']);
                                // $propertiOverlap = $getOverlap[0]->properties;
                                // dd($propertiOverlap);
                                ?>


                                <input type="hidden" class="form-control" id="kawasan" aria-describedby="textlHelp" name="kawasan" value="">
                                <input type="hidden" class="form-control" id="idZona" aria-describedby="textlHelp" name="idZona" value="">
                                <input type="hidden" class="form-control" id="idKegiatan" aria-describedby="textlHelp" name="idKegiatan" value="<?= $datas['kegiatanValue']; ?>">
                                <input type="hidden" class="form-control" id="drawFeatures" aria-describedby="textlHelp" name="drawFeatures">

                                <h5>a. Identitas Pemohon</h5>

                                <div class="form-group">
                                    <label class="form-label">NIB (Nomor Induk Berusaha)</label>
                                    <input type="text" class="form-control" id="nib" aria-describedby="textlHelp" name="nib">
                                </div>
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
                                    <select class="form-select" id="pilihKegiatan" name="kegiatan" style="width: 100%;" required disabled>
                                        <option></option>
                                        <?php foreach ($jenisKegiatan as $K) : ?>
                                            <option value=" <?= $K->id_kegiatan ?>" <?= $K->id_kegiatan == $datas['kegiatanValue'] ? 'selected' : '' ?>><?= $K->nama_kegiatan ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-12 mb-2" for="SubZona">Zona Tercakup</label>

                                </div>

                                <div class="feedback">Keterangan Kesesuaian:</div>
                                <div class="info">
                                    <div class="feedback" id="showKegiatan"> </div>
                                </div>


                                <h5>c. Upload Berkas</h5>

                                <input type="file" class="filepond" name="filepond[]" multiple />

                                <button type="submit" class="btn btn-primary" onclick="kirim()">Kirim</button>
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
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

    <!-- Template Javascript -->
    <script src="/assets/js/main.js"></script>

    <script>
        $(document).ready(function() {
            $('#pilihKegiatan').select2({
                placeholder: "Pilih Jenis Kegiatan",
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

        let geojson = <?= json_encode($geojson); ?>;
        // console.log(geojson);

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
    <script>
        function kirim() {
            let idZona = <?= json_encode($valZona); ?>;
            $("#idZona").val(idZona);
            console.log(idZona);
            $("#drawFeatures").val(JSON.stringify(geojson));
            $("#pilihKegiatan").val($("#pilihKegiatan").val());
            let zona = <?= json_encode($getOverlap); ?>;
            var kawasan = zona.map(function(feature) {
                return feature.properties.KODKWS;
            });
            kawasan = Array.from(new Set(kawasan));
            $("#kawasan").val(kawasan);
            console.log(kawasan);
        }
    </script>

</body>

</html>