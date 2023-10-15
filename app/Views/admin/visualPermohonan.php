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
    <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js "></script>

    <!-- Template Main JS File -->
    <script src="/js/scripts.js"></script>

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
    </script>

</body>

</html>