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
                    <h1 class="mt-2 mb-3">Semua Data Tidak Disetujui</h1>

                    <div class="card mb-4">
                        <div class="card-body">

                            <table id="datatablesSimple" class="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th class="tgl">Tangal Data Masuk</th>
                                        <th class="nama">NIK</th>
                                        <th class="nama">Nama</th>
                                        <th class="almkv">Alamat</th>
                                        <th class="almkv">Jenis Kegiatan</th>
                                        <th class="aks">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($tampilIzin as $Iz) : ?>
                                        <tr>
                                            <td class="tgl"><?= date('d M Y H:i:s', strtotime($Iz->created_at)); ?></td>
                                            <td class="nama"><?= $Iz->nik; ?></td>
                                            <td class="nama"><?= $Iz->nama; ?></td>
                                            <td class="almkv"><?= $Iz->alamat; ?></td>
                                            <td class="almkv"><?= $Iz->nama_kegiatan; ?></td>
                                            <td class="aks">
                                                <div class="btn-group mr-2" role="group" aria-label="First group">
                                                    <a type="button" role="button" href="/admin/data/<?= ($Iz->stat_appv == '1') ? 'telah-disetujui' : 'tidak-disetujui'; ?>/lihat/<?= $Iz->id_perizinan; ?>/<?= $Iz->nama; ?>/" class="asbn btn btn-secondary bi bi-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat" target="_blank"></a>
                                                </div>
                                                <div class="btn-group mr-2" role="group" aria-label="First group">
                                                    <a href="/data-perizinan/<?= $Iz->id_perizinan; ?>/edit/" class="asbn btn btn-primary bi bi-pencil-square" role="button"></a>
                                                </div>
                                                <div class="btn-group mr-2" role="group" aria-label="First group">
                                                    <form id="delete-form-<?= $Iz->id_perizinan; ?>" action="/admin/delete_izin/<?= $Iz->id_perizinan; ?>" method="post">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="button" class="asbn btn btn-danger bi bi-trash delete-btn" data-id="<?= $Iz->id_perizinan; ?>"></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>

                        </div>
                    </div>

                    <!-- <div class="card card-title">
                        <div class="card-body">
                            <div class="map" id="map"></div>
                        </div>
                    </div> -->

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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js "></script>

    <!-- Template Main JS File -->
    <script src="/js/datatables-simple-demo.js"></script>
    <script src="/js/scripts.js"></script>

    <script>
        $(document).ready(function() {
            $('.delete-btn').on('click', function() {
                var userId = $(this).data('id');
                Swal.fire({
                    title: 'Apakah Anda yakin ingin menghapus data ini?',
                    text: "Data yang sudah dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus data!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#delete-form-' + userId).submit();
                    }
                });
            });
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