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
    <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css " rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="/css/StyleAdmin.css" rel="stylesheet" />

    <!-- Leaflet Component -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />

    <style>
        .mymap {
            position: relative;
            height: 50vh;
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
                    <h1 class="mt-2 mb-3">Data Perizinan Masuk</h1>

                    <div class="card mb-4">
                        <div class="card-body">

                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Nama Pemohon</th>
                                        <th>NIK</th>
                                        <th>Alamat</th>
                                        <th>Jenis Kegiatan</th>
                                        <th>Reject/Accept</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($tampilDataIzin as $S) : ?>
                                        <tr>
                                            <th><?= $i++; ?></th>
                                            <th><?= date('d M Y H:i:s', strtotime($S->created_at)); ?></th>
                                            <td><?= $S->nama; ?></td>
                                            <td><?= $S->nik; ?></td>
                                            <td><?= $S->alamat; ?></td>
                                            <td><?= $S->jenis_kegiatan; ?></td>
                                            <td>
                                                <div class="btn-group mr-2" role="group" aria-label="First group">
                                                    <form action="/admin/tolakIzin/<?= $S->id_perizinan; ?>" method="post">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="asbn btn btn-danger bi bi-x-octagon" data-bs-toggle="tooltip" data-bs-placement="top" title="Reject" onclick="return confirm('Yakin Tolak Data?')"></button>
                                                    </form>
                                                </div>
                                                <div class="btn-group mr-2" role="group" aria-label="First group">
                                                    <form action="/admin/approveIzin/<?= $S->id_perizinan; ?>" method="post">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="asbn btn btn-success bi bi-check-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Accept" onclick="return confirm('Approve?')"></button>
                                                    </form>
                                                </div>
                                                <div class="btn-group mr-2" role="group" aria-label="First group">
                                                    <!-- Trigger modal -->
                                                    <button type="button" id="infos" class="asbn btn btn-secondary bi bi-eye" data-bs-toggle="modal" data-bs-target="#infoModal-<?= $S->id_perizinan ?>" onclick="showMap<?= $S->id_perizinan; ?>()"></button>
                                                </div>
                                                <!-- Modal detail -->
                                                <div class=" modal fade" id="infoModal-<?= $S->id_perizinan ?>" tabindex="-1" aria-labelledby="infoModalLabel-<?= $S->id_perizinan ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-fullscreen-lg-down">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="infoModalLabel-<?= $S->id_perizinan ?>">Pratinjau</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-responsive">
                                                                                <thead class="thead-left">
                                                                                    <tr>
                                                                                        <th style="font-weight: 400; border-bottom-width: 1px; border-bottom-color: #dee2e6;">Nama Pemohon</th>
                                                                                        <th style="border-bottom-width: 1px; border-bottom-color: #dee2e6;">:</th>
                                                                                        <th style="font-weight: 400; border-bottom-width: 1px; border-bottom-color: #dee2e6;"><?= $S->nama; ?></th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>NIK</td>
                                                                                        <th>:</th>
                                                                                        <td><?= $S->nik; ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Alamat</td>
                                                                                        <th>:</th>
                                                                                        <td><?= $S->alamat; ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Jenis Kegiatan</td>
                                                                                        <th>:</th>
                                                                                        <td><?= $S->jenis_kegiatan; ?>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Koordinat</td>
                                                                                        <th>:</th>
                                                                                        <td><?= $S->latitude; ?>, <?= $S->longitude; ?></td>
                                                                                    </tr>

                                                                                    <tr>
                                                                                        <td>Created at</td>
                                                                                        <th>:</th>
                                                                                        <td><?= date('d M Y H:i:s', strtotime($S->created_at)); ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Username</td>
                                                                                        <th>:</th>
                                                                                        <td><?= $S->username; ?></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div id="mymap-<?= $S->id_perizinan ?>" class="mymap"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
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

    <script>
        $(document).ready(function() {
            $(".alert");
            setTimeout(function() {
                $(".alert").fadeOut(800);
            }, 2500);
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

    <!-- Leaflet Component -->
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>

    <?php foreach ($tampilDataIzin as $S) : ?>
        <script>
            $(document).ready(function() {
                function showMap<?= $S->id_perizinan; ?>() {
                    var mymap = L.map('mymap-<?= $S->id_perizinan; ?>').setView([<?= $S->latitude; ?>, <?= $S->longitude; ?>], 14);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
                        maxZoom: 18,
                    }).addTo(mymap);
                    L.marker([<?= $S->latitude ?>, <?= $S->longitude ?>]).addTo(mymap);
                    var polygon = L.polygon([<?= $S->polygon; ?>]).addTo(map);

                }
                $('#infoModal-<?= $S->id_perizinan; ?>').on('shown.bs.modal', function() {
                    showMap<?= $S->id_perizinan; ?>();
                })
            });
        </script>
    <?php endforeach ?>

</body>

</html>