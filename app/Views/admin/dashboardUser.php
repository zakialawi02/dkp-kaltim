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

    <!-- vendor css -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css " rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="/css/StyleAdmin.css" rel="stylesheet" />

    <style>
        .map {
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

                    <div class="pagetitle">
                        <h1><?= $title; ?></h1>
                    </div>

                    <div class="dashboard">

                        <!-- user view -->
                        <div class="row">

                            <div class="col-xl-4 p-3">
                                <div class="card">
                                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                                        <img src="/img/user/<?= user()->user_image; ?>" alt="Profile" class="rounded-circle">
                                        <h2 class="m-1 mt-2 text-center"><?= user()->full_name; ?></h2>

                                        <?php if (in_groups('Admin' && 'SuperAdmin')) : ?>
                                            <a class="badge bg-secondary"><?= user()->username; ?></a>
                                        <?php else : ?>
                                            <a class="badge bg-info"><?= user()->username; ?></a>
                                        <?php endif ?>
                                    </div>
                                    <a href="/MyProfile" class="btn btn-outline-primary m-4">Edit My Profile</a>
                                </div>
                            </div>


                            <div class="col-xl-8 p-3">
                                <?php $userSubmitPermohonan = $userSubmitPermohonan ?>
                                <?php $pendingIzin = []; ?>
                                <?php $terimaIzin = []; ?>
                                <?php $tolakIzin = []; ?>
                                <?php foreach ($userSubmitPermohonan as $submitedData) : ?>
                                    <?php if ($submitedData->stat_appv == 0) : ?>
                                        <?php $pendingIzin[] = $submitedData ?>
                                    <?php elseif ($submitedData->stat_appv == 1) : ?>
                                        <?php $terimaIzin[] = $submitedData ?>
                                    <?php else : ?>
                                        <?php $tolakIzin[] = $submitedData ?>
                                    <?php endif ?>
                                <?php endforeach ?>

                                <?php if (!empty($pendingIzin)) : ?>
                                    <?php $totalPending = count($pendingIzin); ?>
                                <?php else : ?>
                                    <?php $totalPending = 0 ?>
                                <?php endif ?>
                                <?php if (!empty($terimaIzin)) : ?>
                                    <?php $totalTerima = count($terimaIzin); ?>
                                <?php else : ?>
                                    <?php $totalTerima = 0 ?>
                                <?php endif ?>
                                <?php if (!empty($tolakIzin)) : ?>
                                    <?php $totalTolak = count($tolakIzin); ?>
                                <?php else : ?>
                                    <?php $totalTolak = 0 ?>
                                <?php endif ?>


                                <div class="card">
                                    <div class="card-body pt-3">
                                        <h3>Data Permohonan</h3>
                                        <div class="accordion" id="accordionExample">
                                            <?php if (empty($pendingIzin)) : ?>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                            Menunggu Jawaban<span class="badge bg-secondary m-1"><?= $totalPending; ?></span> &nbsp;<span type="button" class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Menunggu permohonan diverifikasi"></span>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <p>belum ada data</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php else : ?>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                            Menunggu Jawaban<span class="badge bg-secondary m-1"><?= $totalPending; ?></span> &nbsp;<span type="button" class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Menunggu permohonan diverifikasi"></span>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="table-responsive">

                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">Tanggal Pengajuan</th>
                                                                            <th scope="col">NIK</th>
                                                                            <th scope="col">Nama Pemohon</th>
                                                                            <th scope="col">Jenis Kegiatan</th>
                                                                            <th scope="col">Aksi</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php foreach ($pendingIzin as $pIzin) : ?>
                                                                            <tr class="">
                                                                                <td scope="row"><?= date('d M Y H:i:s', strtotime($pIzin->created_at)); ?></td>
                                                                                <td><?= $pIzin->nik; ?></td>
                                                                                <td><?= $pIzin->nama; ?></td>
                                                                                <td><?= $pIzin->nama_kegiatan ?>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="edit data">
                                                                                        <a href="/data/permohonan/<?= $pIzin->id_perizinan; ?>/edit/" class="asbn btn btn-primary bi bi-pencil-square" role="button"></a>
                                                                                    </div>
                                                                                    <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="hapus data">
                                                                                        <form id="delete-form-<?= $pIzin->id_perizinan; ?>" action="/data/delete_pengajuan/<?= $pIzin->id_perizinan; ?>" method="post">
                                                                                            <?= csrf_field(); ?>
                                                                                            <input type="hidden" name="_method" value="DELETE">
                                                                                            <button type="button" class="asbn btn btn-danger bi bi-trash delete-btn" data-id="<?= $pIzin->id_perizinan; ?>"></button>
                                                                                        </form>
                                                                                    </div>
                                                                                    <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="lihat data">
                                                                                        <a type="button" role="button" href="/admin/data/<?= ($pIzin->stat_appv == '1') ? 'telah-disetujui' : (($pIzin->stat_appv == '0') ? 'menunggu-jawaban' : 'tidak-disetujui'); ?>/lihat/<?= $pIzin->id_perizinan; ?>/<?= $pIzin->nama; ?>/" class="asbn btn btn-secondary bi bi-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat" target="_blank"></a>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        <?php endforeach ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif ?>
                                            <?php if (empty($terimaIzin)) : ?>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingTwo">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                            Disetujui<span class="badge bg-success m-1"><?= $totalTerima; ?></span> &nbsp;<span type="button" class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Permohonan anda disetujui"></span>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <p>belum ada data</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php else : ?>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingTwo">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                            Disetujui<span class="badge bg-success m-1"><?= $totalTerima; ?></span> &nbsp;<span type="button" class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Permohonan anda disetujui"></span>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">Tanggal Pengajuan</th>
                                                                            <th scope="col">NIK</th>
                                                                            <th scope="col">Nama Pemohon</th>
                                                                            <th scope="col">Jenis Kegiatan</th>
                                                                            <th scope="col">Tanggal Dibalas</th>
                                                                            <th scope="col">Aksi</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php foreach ($terimaIzin as $tIzin) : ?>
                                                                            <tr class="">
                                                                                <td scope="row"><?= date('d M Y H:i:s', strtotime($tIzin->created_at)); ?></td>
                                                                                <td><?= $tIzin->nik; ?></td>
                                                                                <td><?= $tIzin->nama; ?></td>
                                                                                <td><?= $pIzin->nama_kegiatan ?>
                                                                                <td><?= date('d M Y H:i:s', strtotime($tIzin->date_updated)); ?></td>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="edit data">
                                                                                        <a href="/data/permohonan/<?= $tIzin->id_perizinan; ?>/edit/" class="asbn btn btn-primary bi bi-pencil-square" role="button"></a>
                                                                                    </div>
                                                                                    <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="hapus data">
                                                                                        <form id="delete-form-<?= $tIzin->id_perizinan; ?>" action="/data/delete_pengajuan/<?= $tIzin->id_perizinan; ?>" method="post">
                                                                                            <?= csrf_field(); ?>
                                                                                            <input type="hidden" name="_method" value="DELETE">
                                                                                            <button type="button" class="asbn btn btn-danger bi bi-trash delete-btn" data-id="<?= $tIzin->id_perizinan; ?>"></button>
                                                                                        </form>
                                                                                    </div>
                                                                                    <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="lihat data">
                                                                                        <a type="button" role="button" href="/admin/data/<?= ($tIzin->stat_appv == '1') ? 'telah-disetujui' : 'tidak-disetujui'; ?>/lihat/<?= $tIzin->id_perizinan; ?>/<?= $tIzin->nama; ?>/" class="asbn btn btn-secondary bi bi-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat" target="_blank"></a>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        <?php endforeach ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif ?>
                                            <?php if (empty($tolakIzin)) : ?>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingThree">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                            Tidak Disetujui<span class="badge bg-danger m-1"><?= $totalTolak; ?></span> &nbsp;<span type="button" class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Permohonan anda tidak disetujui"></span>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <p>belum ada data</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php else : ?>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingThree">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                            Tidak Disetujui<span class="badge bg-danger m-1"><?= $totalTolak; ?></span> &nbsp;<span type="button" class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Data akan terhapus dalam 7 hari"></span>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">Tangaal Pengajuan</th>
                                                                            <th scope="col">NIK</th>
                                                                            <th scope="col">Nama Pemohon</th>
                                                                            <th scope="col">Jenis Kegiatan</th>
                                                                            <th scope="col">Tanggal Dibalas</th>
                                                                            <th scope="col" style="width: 7rem;">Aksi</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php foreach ($tolakIzin as $sIzin) : ?>
                                                                            <tr class="">
                                                                                <td scope="row"><?= date('d M Y H:i:s', strtotime($sIzin->created_at)); ?></td>
                                                                                <td><?= $sIzin->nik; ?></td>
                                                                                <td><?= $sIzin->nama; ?></td>
                                                                                <td><?= $sIzin->nama_kegiatan ?></td>
                                                                                <td><?= date('d M Y H:i:s', strtotime($sIzin->date_updated)); ?></td>

                                                                                <td>
                                                                                    <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="edit data">
                                                                                        <a href="/data/permohonan/<?= $sIzin->id_perizinan; ?>/edit/" class="asbn btn btn-primary bi bi-pencil-square" role="button"></a>
                                                                                    </div>
                                                                                    <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="hapus data">
                                                                                        <form id="delete-form-<?= $sIzin->id_perizinan; ?>" action="/data/delete_pengajuan/<?= $sIzin->id_perizinan; ?>" method="post">
                                                                                            <?= csrf_field(); ?>
                                                                                            <input type="hidden" name="_method" value="DELETE">
                                                                                            <button type="button" class="asbn btn btn-danger bi bi-trash delete-btn" data-id="<?= $sIzin->id_perizinan; ?>"></button>
                                                                                        </form>
                                                                                    </div>
                                                                                    <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="lihat data">
                                                                                        <a type="button" role="button" href="/admin/data/<?= ($sIzin->stat_appv == '1') ? 'telah-disetujui' : 'tidak-disetujui'; ?>/lihat/<?= $sIzin->id_perizinan; ?>/<?= $sIzin->nama; ?>/" class="asbn btn btn-secondary bi bi-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat" target="_blank"></a>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        <?php endforeach ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>

                    </div>

                </div>
            </main>

            <!-- FOOTER -->
            <?= $this->include('_Layout/_template/_admin/footer'); ?>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/816b3ace5c.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="/js/datatables-simple-demo.js"></script>
    <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js "></script>
    <script src="/js/scripts.js"></script>

    <script>
        $(document).ready(function() {
            $("th").css("pointer-events", "none");
            $(".no-sort").css("pointer-events", "none");
        });
    </script>
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
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

</body>

</html>