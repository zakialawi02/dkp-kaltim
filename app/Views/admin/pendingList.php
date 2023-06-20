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
                    <h1 class="mt-2 mb-3">Pending Data Kafe</h1>

                    <div class="card mb-4">
                        <div class="card-body">

                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal Masuk</th>
                                        <th>[From] Username</th>
                                        <th>Nama Kafe</th>
                                        <th>Alamat</th>
                                        <th>Reject/Accept</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($tampilKafe as $S) : ?>
                                        <tr>
                                            <th><?= $i++; ?></th>
                                            <th><?= date('d M Y H:i:s', strtotime($S->created_at)); ?></th>
                                            <td><?= $S->username; ?></td>
                                            <td><?= $S->nama_kafe; ?></td>
                                            <td><?= $S->alamat_kafe; ?></td>
                                            <td>
                                                <div class="btn-group mr-2" role="group" aria-label="First group">
                                                    <form action="/admin/rejectKafe/<?= $S->id_kafe; ?>" method="post">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="asbn btn btn-danger bi bi-x-octagon" data-bs-toggle="tooltip" data-bs-placement="top" title="Reject" onclick="return confirm('Yakin Tolak Data?')"></button>
                                                    </form>
                                                </div>
                                                <div class="btn-group mr-2" role="group" aria-label="First group">
                                                    <form action="/admin/approveKafe/<?= $S->id_kafe; ?>" method="post">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="asbn btn btn-success bi bi-check-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Accept" onclick="return confirm('Approve?')"></button>
                                                    </form>
                                                </div>
                                                <div class="btn-group mr-2" role="group" aria-label="First group">
                                                    <!-- Trigger modal -->
                                                    <button type="button" id="infos" class="asbn btn btn-secondary bi bi-eye" data-bs-toggle="modal" data-bs-target="#infoModal-<?= $S->id_kafe ?>" onclick="showMap<?= $S->id_kafe; ?>()"></button>
                                                </div>
                                                <!-- Modal detail -->
                                                <div class=" modal fade" id="infoModal-<?= $S->id_kafe ?>" tabindex="-1" aria-labelledby="infoModalLabel-<?= $S->id_kafe ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-fullscreen-lg-down">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="infoModalLabel-<?= $S->id_kafe ?>">Preview</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="card mb-2">
                                                                    <div class="card-body">
                                                                        <?php if (empty($S->nama_foto)) : ?>
                                                                            <img src="/img/kafe/no image.jpg" class="img-pending">
                                                                        <?php else : ?>
                                                                            <?php $foto_kafe = explode(', ', $S->nama_foto); ?>
                                                                            <?php foreach ($foto_kafe as $foto) : ?>
                                                                                <img src="<?= base_url('/img/kafe/' . $foto); ?>" class="img-pending">
                                                                            <?php endforeach ?>
                                                                        <?php endif ?>
                                                                    </div>
                                                                </div>
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-responsive">
                                                                                <thead class="thead-left">
                                                                                    <tr>
                                                                                        <th style="font-weight: 400; border-bottom-width: 1px; border-bottom-color: #dee2e6;">Nama Kafe</th>
                                                                                        <th style="border-bottom-width: 1px; border-bottom-color: #dee2e6;">:</th>
                                                                                        <th style="font-weight: 400; border-bottom-width: 1px; border-bottom-color: #dee2e6;"><?= $S->nama_kafe; ?></th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>Alamat</td>
                                                                                        <th>:</th>
                                                                                        <td><?= $S->alamat_kafe; ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Koordinat</td>
                                                                                        <th>:</th>
                                                                                        <td><?= $S->latitude; ?>, <?= $S->longitude; ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Wilayah Administrasi</td>
                                                                                        <th>:</th>
                                                                                        <td><?= $S->nama_kelurahan ?>, Kec. <?= $S->nama_kecamatan ?>, <?= $S->nama_kabupaten ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Instagram</td>
                                                                                        <th>:</th>
                                                                                        <td>
                                                                                            <?php if (empty($S->instagram_kafe)) : ?>
                                                                                                <p>-</p>
                                                                                            <?php else : ?>
                                                                                                <a href="https://www.instagram.com/<?= $S->instagram_kafe ?>" target="_blank" rel="noopener noreferrer" class="d-inline-flex align-items-center">
                                                                                                    <span>@<?= $S->instagram_kafe ?> <i class="ri-external-link-line"></i></span></a>
                                                                                            <?php endif ?>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Jam Oprasional</td>
                                                                                        <th>:</th>
                                                                                        <td><?php
                                                                                            $jam_oprasional = json_decode('[' . $S->jam_oprasional . ']', true);

                                                                                            // Urutkan array $jam_oprasional berdasarkan hari dalam seminggu
                                                                                            usort($jam_oprasional, function ($a, $b) {
                                                                                                $hari_a = array_search($a['hari'], array('Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'));
                                                                                                $hari_b = array_search($b['hari'], array('Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'));
                                                                                                return $hari_a - $hari_b;
                                                                                            });

                                                                                            // Tampilkan jam operasional dalam urutan yang diinginkan
                                                                                            foreach ($jam_oprasional[0] as $jam) {
                                                                                                $hari = $jam['hari'];
                                                                                                $open_time = $jam['open_time'];
                                                                                                $close_time = $jam['close_time'];

                                                                                                echo $hari . ": ";
                                                                                                if ($open_time != null && $close_time != null) {
                                                                                                    echo date("H:i", strtotime($open_time)) . "-" . date("H:i", strtotime($close_time));
                                                                                                } else {
                                                                                                    echo "Tutup";
                                                                                                }
                                                                                                echo "<br>";
                                                                                            }
                                                                                            ?>

                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Created at</td>
                                                                                        <th>:</th>
                                                                                        <td><?= date('d M Y H:i:s', strtotime($S->created_at)); ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>User by</td>
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
                                                                        <div id="mymap-<?= $S->id_kafe ?>" class="mymap"></div>
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

    <?php foreach ($tampilKafe as $S) : ?>
        <script>
            $(document).ready(function() {
                function showMap<?= $S->id_kafe; ?>() {
                    var mymap = L.map('mymap-<?= $S->id_kafe; ?>').setView([<?= $S->latitude; ?>, <?= $S->longitude; ?>], 14);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
                        maxZoom: 18,
                    }).addTo(mymap);
                    L.marker([<?= $S->latitude ?>, <?= $S->longitude ?>]).addTo(mymap)

                }
                $('#infoModal-<?= $S->id_kafe; ?>').on('shown.bs.modal', function() {
                    showMap<?= $S->id_kafe; ?>();
                })
            });
        </script>
    <?php endforeach ?>

</body>

</html>