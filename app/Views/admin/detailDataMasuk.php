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

    <style>
        #map {
            height: 70vh;
            cursor: grab;
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
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-responsive">
                                    <thead class="thead-left">
                                        <tr>
                                            <th style="font-weight: 400; border-bottom-width: 1px; border-bottom-color: #dee2e6;">Nama Pemohon</th>
                                            <th style="border-bottom-width: 1px; border-bottom-color: #dee2e6;">:</th>
                                            <th style="font-weight: 400; border-bottom-width: 1px; border-bottom-color: #dee2e6;"><?= $tampilDataIzin->nama; ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>NIK</td>
                                            <th>:</th>
                                            <td><?= $tampilDataIzin->nik; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Alamat</td>
                                            <th>:</th>
                                            <td><?= $tampilDataIzin->alamat; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Koordinat</td>
                                            <th>:</th>
                                            <td><?= $tampilDataIzin->latitude; ?>, <?= $tampilDataIzin->longitude; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Jenis Kegiatan</td>
                                            <th>:</th>
                                            <td><?= $tampilDataIzin->nama_kegiatan; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Created at</td>
                                            <th>:</th>
                                            <td><?= date('d M Y H:i:s', strtotime($tampilDataIzin->created_at)); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <div id="map" class="map"></div>
                        </div>
                    </div>
                    <div class="card">
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
                                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="reject" class="reject" value="2">
                                                        <label class="form-check-label" for="reject">
                                                            Tidak Disetujui
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="approve" class="approve" value="1">
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
                                                    <button type="submit" class="btn btn-primary" disabled>Kiriman</button>
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

    <script>
        $('input[type="radio"]').change(function(e) {
            $('button[type="submit"]').removeAttr('disabled');
        });
        $('#approve').click(function(e) {
            $('#lampiranFile').attr('required', true);
            $('#lampiran').show();
        });

        $('#reject').click(function(e) {
            $('#lampiranFile').removeAttr('required');
            $('#lampiran').hide();
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
            visible: false,
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
            visible: true,
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
        const viewMini = new ol.View({
            center: ol.proj.fromLonLat([<?= $lat; ?>, <?= $lon; ?>]),
            zoom: <?= $zoomView - 3; ?>,
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
    </script>

</body>

</html>