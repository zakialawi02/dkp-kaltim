<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Preview</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v7.4.0/ol.css">
    <style>
        * {
            margin: 0;
            box-sizing: border-box;
        }

        #mymap {
            height: 100vh;
            width: 100%;
        }
    </style>

</head>

<body>

    <div class="mymap" id="mymap"></div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.5.0/proj4.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/ol@v7.4.0/dist/ol.js"></script>

    <script type="text/javascript">
        <?php foreach ($tampilData as $D) : ?>
            <?php $koordinat = $D->coordinat_wilayah ?>
            <?php $zoomView = $D->zoom_view ?>
            <?php $splitKoordinat = explode(', ', $koordinat) ?>
            <?php $lon = $splitKoordinat[0] ?>
            <?php $lat = $splitKoordinat[1] ?>
        <?php endforeach ?>

        proj4.defs("EPSG:54034", "+proj=cea +lat_ts=0 +lon_0=0 +x_0=0 +y_0=0 +datum=WGS84 +units=m +no_defs +type=crs");
        proj4.defs("EPSG:4326", "+proj=longlat +datum=WGS84 +no_defs +type=crs");
        const vectorSource = new ol.source.Vector();
        const projection = new ol.proj.Projection({
            code: 'EPSG:54034',
            units: 'm',
            axisOrientation: 'neu'
        });
        ol.proj.addProjection(projection);
        // BaseMap
        const osmBaseMap = new ol.layer.Tile({
            source: new ol.source.OSM(),
            crossOrigin: 'anonymous',
            visible: true,
        });
        // Init To Canvas/View
        const view = new ol.View({
            center: ol.proj.fromLonLat([<?= $lat; ?>, <?= $lon; ?>]),
            zoom: <?= $zoomView; ?> - 1,
            Projection: projection
        });
        const mymap = new ol.Map({
            layers: [osmBaseMap],
            target: 'mymap',
            view: view,
        });
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
    </script>
    <script>
        window.addEventListener('message', function(event) {
            let data = event.data;
            let geometryType = event.data.geometryType;
            let geojsonData = data.geojson;
            // console.log(geometryType);
            // console.log(geojsonData);
            vectorSource.clear();
            if (geometryType == "Point") {
                styleDraw = markerStyle;
            } else if (geometryType == "Polygon") {
                styleDraw = polygonStyle;
            } else {
                styleDraw = lineStyle;
            }
            const features = new ol.format.GeoJSON().readFeatures(geojsonData);
            features.forEach((feature) => {
                feature.getGeometry().transform('EPSG:4326', 'EPSG:3857');
                vectorSource.addFeature(feature);
            });
            var drawedVector = new ol.layer.Vector({
                source: vectorSource,
                style: styleDraw,
            });
            mymap.addLayer(drawedVector);
            var extent = drawedVector.getSource().getExtent();
            mymap.getView().fit(extent, {
                padding: [100, 100, 100, 100],
                minResolution: mymap.getView().getResolutionForZoom(14),
                duration: 1500,
            });
        });
    </script>
</body>

</html>