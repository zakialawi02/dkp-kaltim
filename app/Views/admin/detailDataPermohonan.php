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

    <!-- Template Main CSS File -->
    <link href="/css/StyleAdmin.css" rel="stylesheet" />

    <!-- Open Layers Component -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v7.4.0/ol.css">
    <link rel="stylesheet" href="https://unpkg.com/ol-layerswitcher@4.1.1/dist/ol-layerswitcher.css" />
    <link href=" https://cdn.jsdelivr.net/npm/ol-ext@4.0.11/dist/ol-ext.min.css " rel="stylesheet">

    <style>
        #map {
            height: 70vh;
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
                                <?php if ($tampilDataIzin->stat_appv != 0) : ?>
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
                            <div id="map" class="map"></div>
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
    <script src="/js/scripts.js"></script>

    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
    <script>
        $(document).ready(function() {
            $("th").css("pointer-events", "none");
            $(".no-sort").css("pointer-events", "none");
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
                    proj4.defs('EPSG:54034', '+proj=cea +lat_ts=0 +lon_0=0 +x_0=0 +y_0=0 +datum=WGS84 +units=m +no_defs +type=crs');
                    // proj4.defs('EPSG:32750', '+proj=utm +zone=50 +south +datum=WGS84 +units=m +no_defs +type=crs');
                    proj4.defs('EPSG:4326', '+proj=longlat +datum=WGS84 +no_defs');
                    const geojsonData = geojson;
                    const options = {
                        folder: '<?= date("Y"); ?>_<?= date("m"); ?>_<?= $tampilDataIzin->nama; ?>_<?= $tampilDataIzin->nik; ?>',
                        filename: "<?= date("Y"); ?>_<?= date("m"); ?>_<?= $tampilDataIzin->nik; ?>",
                        outputType: "blob",
                        types: {
                            point: "<?= $tampilDataIzin->nik; ?>_PT",
                            polygon: "<?= $tampilDataIzin->nik; ?>_AR",
                            polyline: "<?= $tampilDataIzin->nik; ?>_LN",
                        },
                        prj: 'PROJCS["World_Cylindrical_Equal_Area",GEOGCS["GCS_WGS_1984",DATUM["D_WGS_1984",SPHEROID["WGS_1984",6378137.0,298.257223563]],PRIMEM["Greenwich",0.0],UNIT["Degree",0.0174532925199433]],PROJECTION["Cylindrical_Equal_Area"],PARAMETER["False_Easting",0.0],PARAMETER["False_Northing",0.0],PARAMETER["Central_Meridian",0.0],PARAMETER["Standard_Parallel_1",0.0],UNIT["Meter",1.0]]',
                    };
                    try {
                        geojsonData.features.forEach(feature => {
                            feature.geometry.coordinates = feature.geometry.coordinates.map(coordinates => {
                                return coordinates.map(coord => {
                                    return proj4('EPSG:4326', 'EPSG:32750', [coord[0], coord[1]]);
                                });
                            });
                            if (feature.geometry.bbox) {
                                const [minLon, minLat, maxLon, maxLat] = feature.geometry.bbox;
                                const transformedMin = proj4('EPSG:4326', 'EPSG:32750', [minLon, minLat]);
                                const transformedMax = proj4('EPSG:4326', 'EPSG:32750', [maxLon, maxLat]);
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
                                feature.geometry.coordinates = proj4('EPSG:4326', 'EPSG:32750', feature.geometry.coordinates);
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
            name: 'Data Pemohon',
            zIndex: 1
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

        // Add a title control
        map.addControl(new ol.control.CanvasTitle({
            title: 'my title',
            visible: false,
            style: new ol.style.Style({
                text: new ol.style.Text({
                    font: '20px "Lucida Grande",Verdana,Geneva,Lucida,Arial,Helvetica,sans-serif'
                })
            })
        }));
        // Add a ScaleLine control 
        map.addControl(new ol.control.CanvasScaleLine());
        // Print control
        var printControl = new ol.control.PrintDialog({
            // target: document.querySelector('.info'),
            // targetDialog: map.getTargetElement() 
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

        // style vector geometry eksisting
        const markerStyleEks = new ol.style.Style({
            image: new ol.style.Icon({
                anchor: [0.5, 1],
                anchorXUnits: 'fraction',
                anchorYUnits: 'fraction',
                opacity: 1,
                src: '/mapSystem/images/marker-icon2.png',
                scale: 0.5,
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
                console.log(geojsonData);
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
                console.log(featureCollectionPT);
                console.log(featureCollectionPL);
                console.log(featureCollectionLN);

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
                    name: 'Semua Data Telah Disetujui',
                    zIndex: 2
                });

                map.addLayer(vectorLayerEks);
            }).fail(function(error) {
                $("#muatEksisting").removeClass("d-none");
                $("#loadMuatEksisting").addClass("d-none");
                console.error("Error: ", error);
            });
        });
    </script>

</body>

</html>