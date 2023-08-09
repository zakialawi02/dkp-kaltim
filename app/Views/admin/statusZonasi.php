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
                    <h1 class="mt-2 mb-3">Status Zonasi</h1>

                    <div class="card mb-4">
                        <div class="card-body">

                            <a href="/admin/kegiatan/tambah" class="btn btn-primary m-1 mb-4 bi bi-plus" role="button">Tambah</a>

                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Nama Kegiatan</th>
                                        <?php foreach ($zona as $z) : ?>
                                            <th><?= $z->kode_zonasi; ?></th>
                                        <?php endforeach ?>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($kegiatan as $keg) : ?>
                                        <tr>
                                            <td><?= $keg->nama_kegiatan; ?></td>
                                            <?php $foundStatus = false; ?>
                                            <?php foreach ($dataStatusZonasi as $status) : ?>
                                                <?php if ($status->id_kegiatan == $keg->id_kegiatan) : ?>
                                                    <td><?= $status->status_zonasi; ?></td>
                                                    <?php $foundStatus = true; ?>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                            <?php if (!$foundStatus) : ?>
                                                <td><a href="/admin/data/zonasi/<?= $keg->id_kegiatan; ?>/add/">Add</a></td>
                                            <?php else : ?>
                                                <td>
                                                    <a href="/admin/data/zonasi/<?= $keg->id_kegiatan; ?>/edit/">Edit</a>
                                                    <a href="<?= base_url('kegiatan/delete/' . $keg->id_kegiatan) ?>">Hapus</a>
                                                </td>
                                            <?php endif ?>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>

                            <?php foreach ($zona as $z) : ?>
                                <p><?= $z->kode_zonasi; ?> : <?= $z->nama_subzona; ?></p>
                            <?php endforeach ?>


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



</body>

</html>