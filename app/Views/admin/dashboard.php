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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css" integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />

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
                        <?php if (in_groups('SuperAdmin') || in_groups('Admin')) :; ?>
                            <div class="row">

                                <!-- Left side columns -->
                                <div class="col-lg-8">
                                    <div class="row">

                                        <!--  Card -->
                                        <div class="col-xxl-4 col-md-6 mb-3">
                                            <div class="card info-card kaffe-card">

                                                <div class="card-body">
                                                    <h5 class="card-title">Jumlah Perizinan</h5>

                                                    <div class="d-flex align-items-center">
                                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                            <i class="bi bi-file-earmark-text"></i>
                                                        </div>
                                                        <div class="ps-3">
                                                            <h6><?= $countAllPerizinan; ?></h6>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div><!-- End  Card -->

                                        <!-- Incrase Card -->
                                        <div class="col-xxl-4 col-md-6 mb-3">
                                            <div class="card info-card pending-card">
                                                <div class="card-body">
                                                    <h5 class="card-title">Data Masuk/Pending</h5>

                                                    <div class="d-flex align-items-center">
                                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                            <i class="bi bi-hourglass-top"></i>
                                                        </div>
                                                        <div class="ps-3">
                                                            <h6><?= $countAllPending; ?></h6>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div><!-- End Incrase Card -->

                                        <!-- user Card -->
                                        <div class="col-xxl-4 col-xl-12 mb-3">

                                            <div class="card info-card users-card">

                                                <div class="card-body">
                                                    <h5 class="card-title">Jumlah Pengguna</h5>

                                                    <div class="d-flex align-items-center">
                                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                            <i class="bi bi-people"></i>
                                                        </div>
                                                        <div class="ps-3">
                                                            <h6><?= $countAllUser; ?></h6>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div><!-- End user Card -->

                                        <!-- Daftar Pemohon -->
                                        <div class="col-12 p-2 pr-2 mb-3">
                                            <div class="card recent-sales overflow-auto p-2">
                                                <div class="card-body">
                                                    <h5 class="card-title">Daftar Perizinan | 5 Terbaru</h5>

                                                    <table id="tabels" class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>NIK</th>
                                                                <th>Nama Pemohon</th>
                                                                <th style="min-width:10em">Alamat</th>
                                                                <th>Kontak</th>
                                                                <th>Data Masuk</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($tampilIzin as $izin) : ?>
                                                                <tr>
                                                                    <td><?= $izin->nik; ?></td>
                                                                    <td><?= $izin->nama; ?></td>
                                                                    <td><?= $izin->alamat; ?></td>
                                                                    <td><?= $izin->kontak; ?></td>
                                                                    <td><?= date('d M Y', strtotime($izin->created_at)); ?></td>
                                                                </tr>
                                                            <?php endforeach ?>
                                                        </tbody>
                                                    </table>

                                                    <a type="button" class="btn btn-primary" href="/admin/data/data-perizinan">Lihat Lebih Banyak</a>
                                                </div>

                                            </div>
                                        </div><!-- End Daftar pemohon -->

                                    </div>

                                </div><!-- End Left side columns -->

                                <!-- Right side columns -->
                                <div class="col-lg-4">

                                    <!-- New users -->
                                    <div class="card">

                                        <div class="card-body mb-3">
                                            <h5 class="card-title">Pengguna Baru <span>| 30 Hari Terakhir</span></h5>

                                            <div class="activity">

                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Username</th>
                                                            <th scope="col">Tanggal Daftar</th>
                                                            <th scope="col">Role</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($userMonth as $newUs) : ?>
                                                            <tr>
                                                                <td><?= $newUs->username; ?></td>
                                                                <td> <?= date('d M Y', strtotime($newUs->created_at)); ?></td>
                                                                <td><span class="badge bg-<?= ($newUs->name == 'Admin' or $newUs->name == 'SuperAdmin') ? 'info' : 'secondary'; ?>"> <?= $newUs->name; ?> </span></td>
                                                            </tr>
                                                        <?php endforeach ?>
                                                    </tbody>
                                                </table>
                                                <center>
                                                    <p><?= ($userMonth == null) ? 'Tidak ada Data' : null; ?> </p>
                                                </center>

                                            </div>
                                            <a type="button" class="btn btn-primary" href="/user/list">Lihat Lebih Banyak</a>

                                        </div>

                                    </div>


                                </div><!-- End user Activity -->

                            </div>
                        <?php else : ?>
                            <!-- user -->
                            <div class="row">

                                <div class="col-xl-4 p-3">
                                    <div class="card">
                                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center"> <img src="/img/user/<?= user()->user_image; ?>" alt="Profile" class="rounded-circle">
                                            <h2 class="m-1 mt-2"><?= user()->full_name; ?></h2>

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
                                    <?php $userSubmitIzin = $userSubmitIzin ?>
                                    <?php $pendingIzin = []; ?>
                                    <?php $terimaIzin = []; ?>
                                    <?php $tolakIzin = []; ?>
                                    <?php foreach ($userSubmitIzin as $submitedData) : ?>
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
                                            <h3>Data</h3>
                                            <div class="accordion" id="accordionExample">
                                                <?php if (empty($pendingIzin)) : ?>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingOne">
                                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                Pending<span class="badge bg-secondary m-1"><?= $totalPending; ?></span> &nbsp;<span type="button" class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Menunggu permohonan diverifikasi"></span>
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
                                                                Pending<span class="badge bg-secondary m-1"><?= $totalPending; ?></span> &nbsp;<span type="button" class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Menunggu permohonan diverifikasi"></span>
                                                            </button>
                                                        </h2>
                                                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="table-responsive">

                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col">Data Masuk</th>
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
                                                                                    <td><?= $pIzin->jenis_kegiatan ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="edit data">
                                                                                            <a href="/data-perizinan/<?= $pIzin->id_perizinan; ?>/edit/" class="asbn btn btn-primary bi bi-pencil-square" role="button"></a>
                                                                                        </div>
                                                                                        <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="hapus data">
                                                                                            <form id="delete-form-<?= $pIzin->id_perizinan; ?>" action="/admin/delete_izin/<?= $pIzin->id_perizinan; ?>" method="post">
                                                                                                <?= csrf_field(); ?>
                                                                                                <input type="hidden" name="_method" value="DELETE">
                                                                                                <button type="button" class="asbn btn btn-danger bi bi-trash delete-btn" data-id="<?= $pIzin->id_perizinan; ?>"></button>
                                                                                            </form>
                                                                                        </div>
                                                                                        <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="lihat data">
                                                                                            <!-- Trigger modal -->
                                                                                            <button type="button" role="button" id="infos" class="asbn btn btn-secondary bi bi-eye" data-bs-toggle="modal" data-bs-target="#infoModal-<?= $pIzin->id_perizinan ?>" onclick="showMap<?= $pIzin->id_perizinan; ?>()"></button>
                                                                                        </div>
                                                                                        <!-- Modal detail -->
                                                                                        <div class=" modal fade" id="infoModal-<?= $pIzin->id_perizinan ?>" tabindex="-1" aria-labelledby="infoModalLabel-<?= $pIzin->id_perizinan ?>" aria-hidden="true">
                                                                                            <div class="modal-dialog modal-lg modal-fullscreen-lg-down">
                                                                                                <div class="modal-content">
                                                                                                    <div class="modal-header">
                                                                                                        <h5 class="modal-title" id="infoModalLabel-<?= $pIzin->id_perizinan ?>">Pratinjau</h5>
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
                                                                                                                                <th style="font-weight: 400; border-bottom-width: 1px; border-bottom-color: #dee2e6;"><?= $pIzin->nama; ?></th>
                                                                                                                            </tr>
                                                                                                                        </thead>
                                                                                                                        <tbody>
                                                                                                                            <tr>
                                                                                                                                <td>NIK</td>
                                                                                                                                <th>:</th>
                                                                                                                                <td><?= $pIzin->nik; ?></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td>Alamat</td>
                                                                                                                                <th>:</th>
                                                                                                                                <td><?= $pIzin->alamat; ?></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td>Koordinat</td>
                                                                                                                                <th>:</th>
                                                                                                                                <td><?= $pIzin->latitude; ?>, <?= $pIzin->longitude; ?></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td>Jenis Kegiatan</td>
                                                                                                                                <th>:</th>
                                                                                                                                <td><?= $pIzin->jenis_kegiatan; ?></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td>Created at</td>
                                                                                                                                <th>:</th>
                                                                                                                                <td><?= date('d M Y H:i:s', strtotime($pIzin->created_at)); ?></td>
                                                                                                                            </tr>
                                                                                                                        </tbody>
                                                                                                                    </table>
                                                                                                                </div>
                                                                                                            </div>

                                                                                                        </div>

                                                                                                        <div class="card">
                                                                                                            <div class="card-body">
                                                                                                                <div id="mymap-<?= $pIzin->id_perizinan ?>" class="map"></div>
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
                                                    </div>
                                                <?php endif ?>
                                                <?php if (empty($terimaIzin)) : ?>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingTwo">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                                Diterima<span class="badge bg-success m-1"><?= $totalTerima; ?></span> &nbsp;<span type="button" class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Permohonan anda disetujui"></span>
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
                                                                Diterima<span class="badge bg-success m-1"><?= $totalTerima; ?></span> &nbsp;<span type="button" class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Permohonan anda disetujui"></span>
                                                            </button>
                                                        </h2>
                                                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="table-responsive">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col">Data Masuk</th>
                                                                                <th scope="col">ID</th>
                                                                                <th scope="col">Nama Kafe</th>
                                                                                <th scope="col">Status</th>
                                                                                <th scope="col">Tanggal Status</th>
                                                                                <th scope="col">Aksi</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php foreach ($terimaIzin as $tIzin) : ?>
                                                                                <tr class="">
                                                                                    <td scope="row"><?= date('d M Y H:i:s', strtotime($tIzin->created_at)); ?></td>
                                                                                    <td><?= $tIzin->id_perizinan; ?></td>
                                                                                    <td><?= $tIzin->nama; ?></td>
                                                                                    <td><?= $tIzin->stat_appv == 0 ? 'Pending' : ($tIzin->stat_appv == 1 ? 'Terima' : 'Tolak') ?>
                                                                                    <td><?= date('d M Y H:i:s', strtotime($tIzin->date_updated)); ?></td>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="edit data">
                                                                                            <a href="/data-perizinan/<?= $tIzin->id_perizinan; ?>/edit/" class="asbn btn btn-primary bi bi-pencil-square" role="button"></a>
                                                                                        </div>
                                                                                        <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="hapus data">
                                                                                            <form id="delete-form-<?= $tIzin->id_perizinan; ?>" action="/admin/delete_izin/<?= $tIzin->id_perizinan; ?>" method="post">
                                                                                                <?= csrf_field(); ?>
                                                                                                <input type="hidden" name="_method" value="DELETE">
                                                                                                <button type="button" class="asbn btn btn-danger bi bi-trash delete-btn" data-id="<?= $tIzin->id_perizinan; ?>"></button>
                                                                                            </form>
                                                                                        </div>
                                                                                        <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="lihat data">
                                                                                            <!-- Trigger modal -->
                                                                                            <button type="button" role="button" id="infos" class="asbn btn btn-secondary bi bi-eye" data-bs-toggle="modal" data-bs-target="#infoModal-<?= $tIzin->id_perizinan ?>" onclick="showMap<?= $tIzin->id_perizinan; ?>()"></button>
                                                                                        </div>
                                                                                        <!-- Modal detail -->
                                                                                        <div class=" modal fade" id="infoModal-<?= $tIzin->id_perizinan ?>" tabindex="-1" aria-labelledby="infoModalLabel-<?= $tIzin->id_perizinan ?>" aria-hidden="true">
                                                                                            <div class="modal-dialog modal-lg modal-fullscreen-lg-down">
                                                                                                <div class="modal-content">
                                                                                                    <div class="modal-header">
                                                                                                        <h5 class="modal-title" id="infoModalLabel-<?= $tIzin->id_perizinan ?>">Pratinjau</h5>
                                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                                    </div>
                                                                                                    <div class="modal-body">
                                                                                                        <div class="card">
                                                                                                            <div class="card-body">
                                                                                                                <div class="table-responsive">
                                                                                                                    <table class="table table-responsive">
                                                                                                                        <thead class="thead-left">
                                                                                                                            <tr>
                                                                                                                                <th style="font-weight: 400; border-bottom-width: 1px; border-bottom-color: #dee2e6;">Nama Kafe</th>
                                                                                                                                <th style="border-bottom-width: 1px; border-bottom-color: #dee2e6;">:</th>
                                                                                                                                <th style="font-weight: 400; border-bottom-width: 1px; border-bottom-color: #dee2e6;"><?= $tIzin->nama; ?></th>
                                                                                                                            </tr>
                                                                                                                        </thead>
                                                                                                                        <tbody>
                                                                                                                            <tr>
                                                                                                                                <td>NIK</td>
                                                                                                                                <th>:</th>
                                                                                                                                <td><?= $tIzin->nik; ?></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td>Alamat</td>
                                                                                                                                <th>:</th>
                                                                                                                                <td><?= $tIzin->alamat; ?></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td>Koordinat</td>
                                                                                                                                <th>:</th>
                                                                                                                                <td><?= $tIzin->latitude; ?>, <?= $tIzin->longitude; ?></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td>Jenis Kegiatan</td>
                                                                                                                                <th>:</th>
                                                                                                                                <td><?= $tIzin->jenis_kegiatan; ?></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td>Created at</td>
                                                                                                                                <th>:</th>
                                                                                                                                <td><?= date('d M Y H:i:s', strtotime($tIzin->created_at)); ?></td>
                                                                                                                            </tr>
                                                                                                                        </tbody>
                                                                                                                    </table>
                                                                                                                </div>
                                                                                                            </div>

                                                                                                        </div>

                                                                                                        <div class="card">
                                                                                                            <div class="card-body">
                                                                                                                <div id="mymap-<?= $tIzin->id_perizinan ?>" class="map"></div>
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
                                                    </div>
                                                <?php endif ?>
                                                <?php if (empty($tolakIzin)) : ?>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingThree">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                                Ditolak<span class="badge bg-danger m-1"><?= $totalTolak; ?></span> &nbsp;<span type="button" class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Data akan terhapus dalam 7 hari"></span>
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
                                                                Ditolak<span class="badge bg-danger m-1"><?= $totalTolak; ?></span> &nbsp;<span type="button" class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Data akan terhapus dalam 7 hari"></span>
                                                            </button>
                                                        </h2>
                                                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="table-responsive">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col">Data Masuk</th>
                                                                                <th scope="col">ID</th>
                                                                                <th scope="col">Nama Kafe</th>
                                                                                <th scope="col">Status</th>
                                                                                <th scope="col">Tanggal Status</th>
                                                                                <th scope="col">Aksi</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php foreach ($tolakIzin as $sIzin) : ?>
                                                                                <tr class="">
                                                                                    <td scope="row"><?= date('d M Y H:i:s', strtotime($sIzin->created_at)); ?></td>
                                                                                    <td><?= $sIzin->id_perizinan; ?></td>
                                                                                    <td><?= $sIzin->nama; ?></td>
                                                                                    <td><?= $sIzin->stat_appv == 0 ? 'Pending' : ($sIzin->stat_appv == 1 ? 'Terima' : 'Tolak') ?>
                                                                                    <td><?= date('d M Y H:i:s', strtotime($sIzin->date_updated)); ?></td>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="edit data">
                                                                                            <a href="/data-perizinan/<?= $sIzin->id_perizinan; ?>/edit/" class="asbn btn btn-primary bi bi-pencil-square" role="button"></a>
                                                                                        </div>
                                                                                        <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="hapus data">
                                                                                            <form id="delete-form-<?= $sIzin->id_perizinan; ?>" action="/admin/delete_izin/<?= $sIzin->id_perizinan; ?>" method="post">
                                                                                                <?= csrf_field(); ?>
                                                                                                <input type="hidden" name="_method" value="DELETE">
                                                                                                <button type="button" class="asbn btn btn-danger bi bi-trash delete-btn" data-id="<?= $sIzin->id_perizinan; ?>"></button>
                                                                                            </form>
                                                                                        </div>
                                                                                        <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="lihat data">
                                                                                            <!-- Trigger modal -->
                                                                                            <button type="button" role="button" id="infos" class="asbn btn btn-secondary bi bi-eye" data-bs-toggle="modal" data-bs-target="#infoModal-<?= $sIzin->id_perizinan ?>" onclick="showMap<?= $sIzin->id_perizinan; ?>()"></button>
                                                                                        </div>
                                                                                        <!-- Modal detail -->
                                                                                        <div class=" modal fade" id="infoModal-<?= $sIzin->id_perizinan ?>" tabindex="-1" aria-labelledby="infoModalLabel-<?= $sIzin->id_perizinan ?>" aria-hidden="true">
                                                                                            <div class="modal-dialog modal-lg modal-fullscreen-lg-down">
                                                                                                <div class="modal-content">
                                                                                                    <div class="modal-header">
                                                                                                        <h5 class="modal-title" id="infoModalLabel-<?= $sIzin->id_perizinan ?>">Pratinjau</h5>
                                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                                    </div>
                                                                                                    <div class="modal-body">
                                                                                                        <div class="card">
                                                                                                            <div class="card-body">
                                                                                                                <div class="table-responsive">
                                                                                                                    <table class="table table-responsive">
                                                                                                                        <thead class="thead-left">
                                                                                                                            <tr>
                                                                                                                                <th style="font-weight: 400; border-bottom-width: 1px; border-bottom-color: #dee2e6;">Nama Kafe</th>
                                                                                                                                <th style="border-bottom-width: 1px; border-bottom-color: #dee2e6;">:</th>
                                                                                                                                <th style="font-weight: 400; border-bottom-width: 1px; border-bottom-color: #dee2e6;"><?= $sIzin->nama; ?></th>
                                                                                                                            </tr>
                                                                                                                        </thead>
                                                                                                                        <tbody>
                                                                                                                            <tr>
                                                                                                                                <td>NIK</td>
                                                                                                                                <th>:</th>
                                                                                                                                <td><?= $sIzin->nik; ?></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td>Alamat</td>
                                                                                                                                <th>:</th>
                                                                                                                                <td><?= $sIzin->alamat; ?></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td>Koordinat</td>
                                                                                                                                <th>:</th>
                                                                                                                                <td><?= $sIzin->latitude; ?>, <?= $sIzin->longitude; ?></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td>Jenis Kegiatan</td>
                                                                                                                                <th>:</th>
                                                                                                                                <td><?= $sIzin->jenis_kegiatan; ?></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td>Created at</td>
                                                                                                                                <th>:</th>
                                                                                                                                <td><?= date('d M Y H:i:s', strtotime($sIzin->created_at)); ?></td>
                                                                                                                            </tr>
                                                                                                                        </tbody>
                                                                                                                    </table>
                                                                                                                </div>
                                                                                                            </div>

                                                                                                        </div>

                                                                                                        <div class="card">
                                                                                                            <div class="card-body">
                                                                                                                <div id="mymap-<?= $sIzin->id_perizinan ?>" class="map"></div>
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
                                                    </div>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                            </div>
                        <?php endif ?>
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
    <script src="/js/scripts.js"></script>
    <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js "></script>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>

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
    <script>
        $(document).ready(function() {
            <?php foreach ($userSubmitIzin as $S) : ?>

                function showMap<?= $S->id_perizinan; ?>() {
                    var mymap = L.map('mymap-<?= $S->id_perizinan; ?>').setView([<?= $S->latitude; ?>, <?= $S->longitude; ?>], 14);

                    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiNjg2MzUzMyIsImEiOiJjbDh4NDExZW0wMXZsM3ZwODR1eDB0ajY0In0.6jHWxwN6YfLftuCFHaa1zw', {
                        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                            '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
                        id: 'mapbox/streets-v11',
                        tileSize: 512,
                        zoomOffset: -1
                    }).addTo(mymap);
                    L.marker([<?= $S->latitude ?>, <?= $S->longitude ?>]).addTo(mymap)
                }
                $('#infoModal-<?= $S->id_perizinan; ?>').on('shown.bs.modal', function() {
                    showMap<?= $S->id_perizinan; ?>();
                })
            <?php endforeach ?>
        });
    </script>

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