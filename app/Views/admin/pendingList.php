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
                    <h1 class="mt-2 mb-3">Data Permohonan Masuk</h1>

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
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($tampilDataIzin as $S) : ?>
                                        <tr>
                                            <th><?= $i++; ?></th>
                                            <th><?= date('d M Y H:i:s', strtotime($S->created_at)); ?></th>
                                            <td><?= esc($S->nama); ?></td>
                                            <td><?= esc($S->nik); ?></td>
                                            <td><?= esc($S->alamat); ?></td>
                                            <td><?= esc($S->nama_kegiatan); ?></td>
                                            <td>
                                                <a type="button" role="button" href="/admin/data/permohonan/<?= ($S->stat_appv == '0') ? 'menunggu-jawaban' : ''; ?>/lihat/<?= $S->id_perizinan; ?>" class="asbn btn btn-info bi bi-binoculars" data-bs-toggle="tooltip" data-bs-placement="top" title="Aksi" target="_blank"> Periksa</a>
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


</body>

</html>