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

        .info_status {
            font-size: small;
            display: block;
        }

        p.boleh {
            font-size: small;
            display: block;
            background-color: #66ff66;
            width: 13rem;
            padding: 0.1rem 0.2rem 0.1rem 0.8rem;
            margin-left: 5px;
            font-weight: 700;
            border-radius: 12px;
        }

        p.bolehBersyarat {
            font-size: small;
            display: block;
            background-color: #ffff66;
            width: 22rem;
            padding: 0.1rem 0.2rem 0.1rem 0.8rem;
            margin-left: 5px;
            font-weight: 700;
            border-radius: 12px;
        }

        p.tidakBoleh {
            font-size: small;
            display: block;
            background-color: #ff6666;
            width: 19rem;
            padding: 0.1rem 0.2rem 0.1rem 0.8rem;
            margin-left: 5px;
            font-weight: 700;
            border-radius: 12px;
        }

        .filepond {
            width: 100% !important;
            height: auto;
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

                                        <form class="row g-3" action="/data/updateAjuan/<?= $tampilIzin->id_perizinan; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
                                            <?= csrf_field(); ?>

                                            <input type="hidden" class="form-control" id="drawFeatures" aria-describedby="textlHelp" name="drawFeatures">

                                            <h5>a. Identitas Pemohon</h5>

                                            <div class="form-group">
                                                <label class="form-label">NIK (Nomor Induk Kependudukan)</label>
                                                <input type="text" class="form-control" id="nik" aria-describedby="textlHelp" name="nik" value="<?= esc($tampilIzin->nik); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">NIB (Nomor Induk Berusaha)</label>
                                                <input type="text" class="form-control" id="nik" aria-describedby="textlHelp" name="nib" value="<?= esc($tampilIzin->nib); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Nama</label>
                                                <input type="text" class="form-control" id="nama" aria-describedby="textlHelp" name="nama" value="<?= esc($tampilIzin->nama); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Alamat</label>
                                                <input type="text" class="form-control" id="alamat" aria-describedby="textlHelp" name="alamat" value="<?= esc($tampilIzin->alamat); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">No. Telp/HP</label>
                                                <input type="text" class="form-control" id="kontak" aria-describedby="textlHelp" name="kontak" value="<?= esc($tampilIzin->kontak); ?>" required>
                                            </div>
                                            <div class="mb-1"></div>

                                            <h5>b. Pengajuan Informasi Ruang Laut</h5>

                                            <div class="form-group">
                                                <label class="col-md-12 mb-2">Jenis Kegiatan</label>
                                                <select class="form-select" id="pilihKegiatan" name="kegiatan" for="kegiatan" style="width: 100%;" onchange="cek()" required>
                                                    <option></option>
                                                    <?php foreach ($jenisKegiatan as $K) : ?>
                                                        <option value="<?= $K->id_kegiatan ?>" <?= $K->id_kegiatan == $tampilIzin->id_kegiatan ? 'selected' : '' ?>><?= esc($K->nama_kegiatan) ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-12 mb-2">Wilayah Kegiatan</label>
                                                <?php
                                                if (!empty($tampilIzin->id_zona)) {
                                                    $zoneName = explode(",", $tampilIzin->id_zona);
                                                    $zoneName = array_unique($zoneName);
                                                    foreach ($tampilZona as $value) {
                                                        if (in_array($value->id_zona, $zoneName)) {
                                                            echo "<span>" . esc($value->nama_zona) . "</span>"  . "<br>";
                                                        }
                                                    }
                                                } else {
                                                    echo "<span> - </span>"  . "<br>";
                                                }
                                                ?>
                                            </div>

                                            <div class="feedback fs-6">Keterangan:</div>
                                            <div class="info_status">
                                                <div class="info_status" id="showKegiatan"> - </div>
                                            </div>

                                            <h5>c. Upload Berkas</h5>
                                            <div id="tempatFile">
                                                <div class="p-md-2 gap-2">
                                                    <?php if ($tampilIzin->uploadFiles != null) : ?>
                                                        <?php foreach ($tampilIzin->uploadFiles as $file) : ?>
                                                            <div class="card mb-3" style="max-width: 500px;">
                                                                <div class="card-body file">
                                                                    <p class="card-text"><button type="button" class="asbn btn btn-danger bi bi-trash3-fill me-2" onclick="hapusFile('<?= $file->uploadFiles; ?>')"></button><a href="/dokumen/upload-dokumen/<?= $file->uploadFiles; ?>" target="_blank"><?= $file->uploadFiles; ?></a></p>
                                                                </div>
                                                            </div>
                                                        <?php endforeach ?>
                                                    <?php endif ?>
                                                </div>
                                            </div>

                                            <input type="file" class="filepond" name="filepond[]" value="" multiple data-dokumenUp="<?= $tampilIzin->id_perizinan; ?>" />


                                            <button type="submit" id="lanjutKirim" class="btn btn-primary lanjutKirim" onclick="kirim()">Perbarui</button>
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
        function hapusFile(file) {
            // console.log(file);
            $.ajax({
                type: "POST",
                url: `/data/delete_file`,
                data: {
                    file
                },
                dataType: "html",
                success: function(response) {
                    $("#tempatFile").html(response);
                }
            });
        }
    </script>
    <script>
        // Get a file input reference
        const input = document.querySelector('input[type="file"]');
        const dokumenUp = input.getAttribute('data-dokumenUp');
        // Create a FilePond instance
        const pond = FilePond.create(input, {
            allowMultiple: true,
            allowProcess: true,
            withCredentials: true,
            server: {
                process: {
                    url: `/data/uploadDoc?dokumenUp=${dokumenUp}`,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                    }
                },
                revert: (FileId, load, error) => {
                    const data = JSON.parse(FileId);
                    deleteFile(data.file);
                    error('Error terjadi saat delete file');
                    load();
                },
                headers: {
                    'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                },
                fetch: null,
            },
        });

        function deleteFile(nameFile) {
            $.ajax({
                url: '/data/revertDoc',
                type: "POST",
                data: {
                    fileName: nameFile
                }
            });
        }
    </script>

    <!-- Open Layers Component -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.5.0/proj4.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/ol@v7.4.0/dist/ol.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/elm-pep@1.0.6/dist/elm-pep.js"></script>
    <script src="https://unpkg.com/ol-layerswitcher@4.1.1"></script>
    <script src="https://api.tiles.mapbox.com/mapbox.js/plugins/turf/v2.0.0/turf.min.js"></script>
    <script src="/mapSystem/catiline.js"></script>
    <script src="https://unpkg.com/shpjs@latest/dist/shp.js"></script>
    <script src="/mapSystem/turf.min.js"></script>


    <script type="text/javascript">
        <?php foreach ($tampilData as $D) : ?>
            <?php $koordinat = $D->coordinat_wilayah ?>
            <?php $zoomView = $D->zoom_view ?>
            <?php $splitKoordinat = explode(', ', $koordinat) ?>
            <?php $lon = $splitKoordinat[0] ?>
            <?php $lat = $splitKoordinat[1] ?>
        <?php endforeach ?>

        proj4.defs("EPSG:54034", "+proj=cea +lat_ts=0 +lon_0=0 +x_0=0 +y_0=0 +datum=WGS84 +units=m +no_defs +type=crs");
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
                jsonCoordinates = getCoordinates(geojson);
                geojsonData = jsonCoordinates;
                // console.log(geometryType);
                prosesDetectInput(jsonCoordinates, geometryType, geojsonData);
                cek();
            }, function(a) {
                console.log(a)
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
            let valKegiatan = $('#pilihKegiatan').val();
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

        function kirim() {
            console.log("HELL");
            const newProperties = {
                "NAMA": $('[name="nama"]').val(),
                "NIK": $('[name="nik"]').val(),
                "NIB": $('[name="nib"]').val(),
                "ALAMAT": $('[name="alamat"]').val(),
                "KONTAK": $('[name="kontak"]').val(),
                "JNS_KEGIATAN": $('#pilihKegiatan option:selected').text(),
            };
            geojson.features.forEach(feature => {
                feature.properties = newProperties;
            });
            $("#drawFeatures").val(JSON.stringify(geojson));
        }
    </script>

</body>

</html>