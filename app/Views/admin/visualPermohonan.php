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
    <link href=" https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.css " rel="stylesheet">
    <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css " rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="/css/StyleAdmin.css" rel="stylesheet" />

    <!-- Open Layers Component -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v7.4.0/ol.css">
    <link rel="stylesheet" href="https://unpkg.com/ol-layerswitcher@4.1.1/dist/ol-layerswitcher.css" />
    <link href=" https://cdn.jsdelivr.net/npm/ol-ext@4.0.11/dist/ol-ext.min.css " rel="stylesheet">

    <style>
        #map {
            height: 90vh;
            /* cursor: grab; */
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
                    <h1 class="mt-2 mb-3">Semua Data Disetujui</h1>

                    <div class="card mb-4">
                        <div class="card-body">

                            <div class="map" id="map"></div>
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
                            <div id="Cbuttons"></div>

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
    <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js "></script>

    <!-- Template Main JS File -->
    <script src="/js/scripts.js"></script>

    <script>
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
    <?php if (session()->getFlashdata('success')) : ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '<?= session()->getFlashdata('success'); ?>',
                timer: 1500,
            });
        </script>
    <?php endif; ?>

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

    <!-- Open Layers Component -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.5.0/proj4.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/ol@v7.4.0/dist/ol.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/elm-pep@1.0.6/dist/elm-pep.js"></script>
    <script src="https://unpkg.com/ol-layerswitcher@4.1.1"></script>
    <script src=" https://cdn.jsdelivr.net/npm/ol-ext@4.0.11/dist/ol-ext.min.js "></script>
    <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL,Object.assign"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/eligrey/FileSaver.js/aa9f4e0e/FileSaver.min.js"></script>

    <script type="text/javascript">
        proj4.defs("EPSG:54034", "+proj=cea +lat_ts=0 +lon_0=0 +x_0=0 +y_0=0 +datum=WGS84 +units=m +no_defs +type=crs");
        proj4.defs("EPSG:23836", "+proj=tmerc +lat_0=0 +lon_0=112.5 +k=0.9999 +x_0=200000 +y_0=1500000 +ellps=WGS84 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs");

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
                color: 'rgba(232, 85, 72, 0.3)',
            }),
            stroke: new ol.style.Stroke({
                color: 'red',
                width: 2,
            }),
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
            center: ol.proj.fromLonLat([118, -1]),
            zoom: 5,
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

        <?php $geojsonData = [] ?>
        <?php foreach ($tampilIzin as $key => $value) : ?>
            <?php $geojsonData[] = $value->lokasi; ?>
        <?php endforeach ?>
        let geojsonData = <?= json_encode($geojsonData); ?>;

        let vectorSource = new ol.source.Vector();
        let vectorLayer;

        const allFeaturesPT = [];
        const allFeaturesPL = [];
        const allFeaturesLN = [];
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
        vectorSource.addFeatures(featuresPT);
        vectorSource.addFeatures(featuresPL);
        vectorSource.addFeatures(featuresLN);
        vectorLayer = new ol.layer.Vector({
            source: vectorSource,
            style: function(feature) {
                if (feature.getGeometry().getType() === 'Point') {
                    return markerStyle;
                } else if (feature.getGeometry().getType() === 'Polygon') {
                    return polygonStyle;
                } else {
                    return lineStyle;
                }
            },
            name: 'Data Telah Disetujui',
            zIndex: 5,
        });
        map.addLayer(vectorLayer);

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
            minResolution: map.getView().getResolutionForZoom(12),
            duration: 1500,
        });


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
    </script>

</body>

</html>