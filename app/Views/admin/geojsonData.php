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

    <!-- leaflet Component -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css" integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
    <link href="/leaflet/L.Control.MousePosition.css" rel="stylesheet">
    <link rel="stylesheet" href="//unpkg.com/leaflet-gesture-handling/dist/leaflet-gesture-handling.min.css" type="text/css">

    <style>
        .map {
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
                    <h1 class="mt-2 mb-3">Data Features</h1>

                    <div class="card mb-4">
                        <div class="card-body">

                            <a href="/admin/features/tambah" class="btn btn-primary m-1 mb-4 bi bi-plus" role="button">Tambah</a>

                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Features</th>
                                        <th>Warna</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($tampilGeojson as $G) : ?>
                                        <tr>
                                            <td><?= $G->nama_features; ?></td>
                                            <td><a href="<?= base_url() . "/geojson/" . $G->features; ?>" target="_blank"><?= $G->features; ?></a></td>
                                            <td><span style="color: <?= $G->warna; ?>; text-decoration-line: underline;  text-decoration-style: solid; text-decoration-color: <?= $G->warna; ?>;text-decoration-thickness: 10px;"><?= $G->warna; ?></span></td>
                                            <td>
                                                <div class="btn-group mr-2" role="group" aria-label="First group">
                                                    <a href="/admin/features/edit/<?= $G->id; ?>" class="asbn btn btn-primary bi bi-pencil-square" role="button"></a>
                                                </div>
                                                <div class="btn-group mr-2" role="group" aria-label="First group">
                                                    <!-- Trigger modal -->
                                                    <button type="button" role="button" id="infos" class="asbn btn btn-secondary bi bi-eye" data-bs-toggle="modal" data-bs-target="#infoModal-<?= $G->id ?>" onclick="showMap<?= $G->id; ?>()"></button>
                                                </div>
                                                <div class="btn-group mr-2" role="group" aria-label="First group">
                                                    <form action="/admin/delete_Geojson/<?= $G->id; ?>" method="post">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="asbn btn btn-danger bi bi-trash" onclick="return confirm('Yakin Hapus Data?')"></button>
                                                    </form>
                                                </div>

                                                <!-- Modal detail -->
                                                <div class=" modal fade" id="infoModal-<?= $G->id ?>" tabindex="-1" aria-labelledby="infoModalLabel-<?= $G->id ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl modal-fullscreen-lg-down">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="infoModalLabel-<?= $G->id ?>">Preview</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div id="mymap-<?= $G->id ?>" class="map"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>


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
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/816b3ace5c.js" crossorigin="anonymous"></script>
    <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js "></script>

    <!-- Template Main JS File -->
    <script src="/js/datatables-simple-demo.js"></script>
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

    <!-- Leaflet Component -->
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script src="/leaflet/catiline.js"></script>
    <script src="/leaflet/leaflet.shpfile.js"></script>

    // shapefile/geojson


    <?php foreach ($tampilData as $D) : ?>
        <?php $zoom = $D->zoom_view ?>
        <?php $koord = $D->coordinat_wilayah ?>
    <?php endforeach ?>
    <script>
        $(document).ready(function() {
            <?php foreach ($tampilGeojson as $G) : ?>

                function showMap<?= $G->id; ?>() {
                    var mymap = L.map('mymap-<?= $G->id; ?>').setView([<?= $koord; ?>], 12);

                    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                    }).addTo(mymap);

                    // shapefile
                    var geoshp = L.geoJson({
                        features: []
                    }, {
                        style: function(feature) {
                            return {
                                fillColor: '<?= $G->warna; ?>', // Ubah warna poligon
                                fillOpacity: 0.2, // Ubah tingkat kecerahan poligon
                                color: '<?= $G->warna; ?>', // Ubah warna garis batas poligon
                                weight: 1 // Ubah ketebalan garis batas poligon 
                            };
                        },
                        onEachFeature: function(feature, layer) {
                            var properties = feature.properties;
                            var popupContent = "";
                            for (var key in properties) {
                                if (properties.hasOwnProperty(key)) {
                                    popupContent += key + ": " + properties[key] + "<br>";
                                }
                            }
                            layer.bindPopup(popupContent);
                        }
                    });

                    var wfunc = function(base, cb) {
                        importScripts('/leaflet/shp.js');
                        shp(base).then(cb);
                    }
                    var worker = cw({
                        data: wfunc
                    }, 2);
                    worker.data(cw.makeUrl('/geojson/<?= $G->features; ?>')).then(function(data) {
                        geoshp.addData(data).addTo(mymap);
                    }, function(a) {
                        console.log(a)
                    });
                }
                $('#infoModal-<?= $G->id; ?>').on('shown.bs.modal', function() {
                    showMap<?= $G->id; ?>();
                })
            <?php endforeach ?>
        });
    </script>



</body>

</html>