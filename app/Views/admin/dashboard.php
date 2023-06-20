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

                                        <!-- kafe Card -->
                                        <div class="col-xxl-4 col-md-6 mb-3">
                                            <div class="card info-card kaffe-card">

                                                <div class="card-body">
                                                    <h5 class="card-title">Jumlah Kafe <span>| Total</span></h5>

                                                    <div class="d-flex align-items-center">
                                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                            <i class="bi bi-cup-hot"></i>
                                                        </div>
                                                        <div class="ps-3">
                                                            <h6><?= $countAllKafe; ?></h6>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div><!-- End kafe Card -->

                                        <!-- Incrase Card -->
                                        <div class="col-xxl-4 col-md-6 mb-3">
                                            <div class="card info-card pending-card">
                                                <div class="card-body">
                                                    <h5 class="card-title">Pending <span>| Total</span></h5>

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
                                                    <h5 class="card-title">Users <span>| Total</span></h5>

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

                                        <!-- Daftar Kafe -->
                                        <div class="col-12 p-2 pr-2 mb-3">
                                            <div class="card recent-sales overflow-auto p-2">
                                                <div class="card-body">
                                                    <h5 class="card-title">Daftar Kafe</h5>

                                                    <table id="tabels" class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th style="min-width:10em">Nama Kafe</th>
                                                                <th style="min-width:10em">Alamat</th>
                                                                <th>Koordinat</th>
                                                                <th>Data Masuk</th>
                                                                <th>User By</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($tampilKafe as $kafe) : ?>
                                                                <tr>
                                                                    <td><?= $kafe->nama_kafe; ?></td>
                                                                    <td><?= $kafe->alamat_kafe; ?></td>
                                                                    <td><a href="#" class="text-primary"><?= $kafe->latitude; ?>, <?= $kafe->longitude; ?></a></td>
                                                                    <td><?= date('d M Y', strtotime($kafe->created_at)); ?></td>
                                                                    <td><span class="badge bg-primary"><?= $kafe->username; ?></span></td>
                                                                </tr>
                                                            <?php endforeach ?>
                                                        </tbody>
                                                    </table>

                                                    <a type="button" class="btn btn-primary" href="/admin/data/kafe">View More</a>
                                                </div>

                                            </div>
                                        </div><!-- End Daftar Kafe -->

                                    </div>

                                </div><!-- End Left side columns -->

                                <!-- Right side columns -->
                                <div class="col-lg-4">

                                    <div class="card mb-3">

                                        <div class="card-body">
                                            <h5 class="card-title">Pie Chart <span>| Kafe</span></h5>

                                            <center>
                                                <div>
                                                    <div id="chart"></div>
                                                </div>
                                            </center>

                                        </div>

                                    </div><!-- End chart Activity -->

                                    <!-- New users -->
                                    <div class="card">

                                        <div class="card-body mb-3">
                                            <h5 class="card-title">New Users <span>| Last 30 days</span></h5>

                                            <div class="activity">

                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Username</th>
                                                            <th scope="col">Join at</th>
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
                                                    <p><?= ($userMonth == null) ? 'No Data' : null; ?> </p>
                                                </center>

                                            </div>
                                            <a type="button" class="btn btn-primary" href="/user/list">View More</a>

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
                                    <?php $userSubmitKafe = $userSubmitKafe ?>
                                    <?php $pendingKafe = []; ?>
                                    <?php $terimaKafe = []; ?>
                                    <?php $tolakKafe = []; ?>
                                    <?php foreach ($userSubmitKafe as $submitedData) : ?>
                                        <?php if ($submitedData->stat_appv == 0) : ?>
                                            <?php $pendingKafe[] = $submitedData ?>
                                        <?php elseif ($submitedData->stat_appv == 1) : ?>
                                            <?php $terimaKafe[] = $submitedData ?>
                                        <?php else : ?>
                                            <?php $tolakKafe[] = $submitedData ?>
                                        <?php endif ?>
                                    <?php endforeach ?>

                                    <?php if (!empty($pendingKafe)) : ?>
                                        <?php $totalPending = count($pendingKafe); ?>
                                    <?php else : ?>
                                        <?php $totalPending = 0 ?>
                                    <?php endif ?>
                                    <?php if (!empty($terimaKafe)) : ?>
                                        <?php $totalTerima = count($terimaKafe); ?>
                                    <?php else : ?>
                                        <?php $totalTerima = 0 ?>
                                    <?php endif ?>
                                    <?php if (!empty($tolakKafe)) : ?>
                                        <?php $totalTolak = count($tolakKafe); ?>
                                    <?php else : ?>
                                        <?php $totalTolak = 0 ?>
                                    <?php endif ?>


                                    <div class="card">
                                        <div class="card-body pt-3">
                                            <h3>Data</h3>
                                            <div class="accordion" id="accordionExample">
                                                <?php if (empty($pendingKafe)) : ?>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingOne">
                                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                Pending<span class="badge bg-secondary m-1"><?= $totalPending; ?></span> &nbsp;<span type="button" class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Menunggu data diverifikasi dan dapat muncul pada publik"></span>
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
                                                                Pending<span class="badge bg-secondary m-1"><?= $totalPending; ?></span> &nbsp;<span type="button" class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Menunggu data diverifikasi dan dapat muncul pada publik"></span>
                                                            </button>
                                                        </h2>
                                                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="table-responsive">

                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col">Data Masuk</th>
                                                                                <th scope="col">ID</th>
                                                                                <th scope="col">Nama Kafe</th>
                                                                                <th scope="col">Status</th>
                                                                                <th scope="col">Aksi</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php foreach ($pendingKafe as $pkafe) : ?>
                                                                                <tr class="">
                                                                                    <td scope="row"><?= date('d M Y H:i:s', strtotime($pkafe->created_at)); ?></td>
                                                                                    <td><?= $pkafe->id_kafe; ?></td>
                                                                                    <td><?= $pkafe->nama_kafe; ?></td>
                                                                                    <td><?= $pkafe->stat_appv == 0 ? 'Pending' : ($pkafe->stat_appv == 1 ? 'Terima' : 'Tolak') ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="edit data">
                                                                                            <a href="/kafe/edit/<?= $pkafe->id_kafe; ?>" class="asbn btn btn-primary bi bi-pencil-square" role="button"></a>
                                                                                        </div>
                                                                                        <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="hapus data">
                                                                                            <form id="delete-form-<?= $pkafe->id_kafe; ?>" action="/admin/delete_Kafe/<?= $pkafe->id_kafe; ?>" method="post">
                                                                                                <?= csrf_field(); ?>
                                                                                                <input type="hidden" name="_method" value="DELETE">
                                                                                                <button type="button" class="asbn btn btn-danger bi bi-trash delete-btn" data-id="<?= $pkafe->id_kafe; ?>"></button>
                                                                                            </form>
                                                                                        </div>
                                                                                        <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="lihat data">
                                                                                            <!-- Trigger modal -->
                                                                                            <button type="button" role="button" id="infos" class="asbn btn btn-secondary bi bi-eye" data-bs-toggle="modal" data-bs-target="#infoModal-<?= $pkafe->id_kafe ?>" onclick="showMap<?= $pkafe->id_kafe; ?>()"></button>
                                                                                        </div>
                                                                                        <!-- Modal detail -->
                                                                                        <div class=" modal fade" id="infoModal-<?= $pkafe->id_kafe ?>" tabindex="-1" aria-labelledby="infoModalLabel-<?= $pkafe->id_kafe ?>" aria-hidden="true">
                                                                                            <div class="modal-dialog modal-lg modal-fullscreen-lg-down">
                                                                                                <div class="modal-content">
                                                                                                    <div class="modal-header">
                                                                                                        <h5 class="modal-title" id="infoModalLabel-<?= $pkafe->id_kafe ?>">Preview</h5>
                                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                                    </div>
                                                                                                    <div class="modal-body">
                                                                                                        <div class="card mb-2">
                                                                                                            <div class="card-body">
                                                                                                                <?php if (empty($pkafe->nama_foto)) : ?>
                                                                                                                    <img src="/img/kafe/no image.jpg" class="img-pending">
                                                                                                                <?php else : ?>
                                                                                                                    <?php $foto_kafe = explode(', ', $pkafe->nama_foto); ?>
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
                                                                                                                                <th style="font-weight: 400; border-bottom-width: 1px; border-bottom-color: #dee2e6;"><?= $pkafe->nama_kafe; ?></th>
                                                                                                                            </tr>
                                                                                                                        </thead>
                                                                                                                        <tbody>
                                                                                                                            <tr>
                                                                                                                                <td>Alamat</td>
                                                                                                                                <th>:</th>
                                                                                                                                <td><?= $pkafe->alamat_kafe; ?></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td>Koordinat</td>
                                                                                                                                <th>:</th>
                                                                                                                                <td><?= $pkafe->latitude; ?>, <?= $pkafe->longitude; ?></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td>Wilayah Administrasi</td>
                                                                                                                                <th>:</th>
                                                                                                                                <td><?= $pkafe->nama_kelurahan ?>, Kec. <?= $pkafe->nama_kecamatan ?>, <?= $pkafe->nama_kabupaten ?></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td>Instagram</td>
                                                                                                                                <th>:</th>
                                                                                                                                <td><a href="https://www.instagram.com/<?= $pkafe->instagram_kafe ?>" target="_blank" rel="noopener noreferrer" class="d-inline-flex align-items-center">
                                                                                                                                        <span>@<?= $pkafe->instagram_kafe ?> <i class="ri-external-link-line"></i></span></a></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td>Jam Oprasional</td>
                                                                                                                                <th>:</th>
                                                                                                                                <td><?php
                                                                                                                                    $jam_oprasional = json_decode('[' . $pkafe->jam_oprasional . ']', true);

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
                                                                                                                                <td><?= date('d M Y H:i:s', strtotime($pkafe->created_at)); ?></td>
                                                                                                                            </tr>
                                                                                                                        </tbody>
                                                                                                                    </table>
                                                                                                                </div>
                                                                                                            </div>

                                                                                                        </div>

                                                                                                        <div class="card">
                                                                                                            <div class="card-body">
                                                                                                                <div id="mymap-<?= $pkafe->id_kafe ?>" class="map"></div>
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
                                                <?php if (empty($terimaKafe)) : ?>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingTwo">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                                Diterima<span class="badge bg-success m-1"><?= $totalTerima; ?></span> &nbsp;<span type="button" class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Data anda tampil kepublik"></span>
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
                                                                Diterima<span class="badge bg-success m-1"><?= $totalTerima; ?></span> &nbsp;<span type="button" class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Data anda tampil kepublik"></span>
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
                                                                            <?php foreach ($terimaKafe as $tkafe) : ?>
                                                                                <tr class="">
                                                                                    <td scope="row"><?= date('d M Y H:i:s', strtotime($tkafe->created_at)); ?></td>
                                                                                    <td><?= $tkafe->id_kafe; ?></td>
                                                                                    <td><?= $tkafe->nama_kafe; ?></td>
                                                                                    <td><?= $tkafe->stat_appv == 0 ? 'Pending' : ($tkafe->stat_appv == 1 ? 'Terima' : 'Tolak') ?>
                                                                                    <td><?= date('d M Y H:i:s', strtotime($tkafe->date_updated)); ?></td>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="edit data">
                                                                                            <a href="/kafe/edit/<?= $tkafe->id_kafe; ?>" class="asbn btn btn-primary bi bi-pencil-square" role="button"></a>
                                                                                        </div>
                                                                                        <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="hapus data">
                                                                                            <form id="delete-form-<?= $tkafe->id_kafe; ?>" action="/admin/delete_Kafe/<?= $tkafe->id_kafe; ?>" method="post">
                                                                                                <?= csrf_field(); ?>
                                                                                                <input type="hidden" name="_method" value="DELETE">
                                                                                                <button type="button" class="asbn btn btn-danger bi bi-trash delete-btn" data-id="<?= $tkafe->id_kafe; ?>"></button>
                                                                                            </form>
                                                                                        </div>
                                                                                        <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="lihat data">
                                                                                            <!-- Trigger modal -->
                                                                                            <button type="button" role="button" id="infos" class="asbn btn btn-secondary bi bi-eye" data-bs-toggle="modal" data-bs-target="#infoModal-<?= $tkafe->id_kafe ?>" onclick="showMap<?= $tkafe->id_kafe; ?>()"></button>
                                                                                        </div>
                                                                                        <!-- Modal detail -->
                                                                                        <div class=" modal fade" id="infoModal-<?= $tkafe->id_kafe ?>" tabindex="-1" aria-labelledby="infoModalLabel-<?= $tkafe->id_kafe ?>" aria-hidden="true">
                                                                                            <div class="modal-dialog modal-lg modal-fullscreen-lg-down">
                                                                                                <div class="modal-content">
                                                                                                    <div class="modal-header">
                                                                                                        <h5 class="modal-title" id="infoModalLabel-<?= $tkafe->id_kafe ?>">Preview</h5>
                                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                                    </div>
                                                                                                    <div class="modal-body">
                                                                                                        <div class="card mb-2">
                                                                                                            <div class="card-body">
                                                                                                                <?php if (empty($tkafe->nama_foto)) : ?>
                                                                                                                    <img src="/img/kafe/no image.jpg" class="img-pending">
                                                                                                                <?php else : ?>
                                                                                                                    <?php $foto_kafe = explode(', ', $tkafe->nama_foto); ?>
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
                                                                                                                                <th style="font-weight: 400; border-bottom-width: 1px; border-bottom-color: #dee2e6;"><?= $tkafe->nama_kafe; ?></th>
                                                                                                                            </tr>
                                                                                                                        </thead>
                                                                                                                        <tbody>
                                                                                                                            <tr>
                                                                                                                                <td>Alamat</td>
                                                                                                                                <th>:</th>
                                                                                                                                <td><?= $tkafe->alamat_kafe; ?></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td>Koordinat</td>
                                                                                                                                <th>:</th>
                                                                                                                                <td><?= $tkafe->latitude; ?>, <?= $tkafe->longitude; ?></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td>Wilayah Administrasi</td>
                                                                                                                                <th>:</th>
                                                                                                                                <td><?= $tkafe->nama_kelurahan ?>, Kec. <?= $tkafe->nama_kecamatan ?>, <?= $tkafe->nama_kabupaten ?></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td>Instagram</td>
                                                                                                                                <th>:</th>
                                                                                                                                <td><a href="https://www.instagram.com/<?= $tkafe->instagram_kafe ?>" target="_blank" rel="noopener noreferrer" class="d-inline-flex align-items-center">
                                                                                                                                        <span>@<?= $tkafe->instagram_kafe ?> <i class="ri-external-link-line"></i></span></a></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td>Jam Oprasional</td>
                                                                                                                                <th>:</th>
                                                                                                                                <td><?php
                                                                                                                                    $jam_oprasional = json_decode('[' . $tkafe->jam_oprasional . ']', true);

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
                                                                                                                                <td><?= date('d M Y H:i:s', strtotime($tkafe->created_at)); ?></td>
                                                                                                                            </tr>
                                                                                                                        </tbody>
                                                                                                                    </table>
                                                                                                                </div>
                                                                                                            </div>

                                                                                                        </div>

                                                                                                        <div class="card">
                                                                                                            <div class="card-body">
                                                                                                                <div id="mymap-<?= $tkafe->id_kafe ?>" class="map"></div>
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
                                                <?php if (empty($tolakKafe)) : ?>
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
                                                                            <?php foreach ($tolakKafe as $skafe) : ?>
                                                                                <tr class="">
                                                                                    <td scope="row"><?= date('d M Y H:i:s', strtotime($skafe->created_at)); ?></td>
                                                                                    <td><?= $skafe->id_kafe; ?></td>
                                                                                    <td><?= $skafe->nama_kafe; ?></td>
                                                                                    <td><?= $skafe->stat_appv == 0 ? 'Pending' : ($skafe->stat_appv == 1 ? 'Terima' : 'Tolak') ?>
                                                                                    <td><?= date('d M Y H:i:s', strtotime($skafe->date_updated)); ?></td>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="edit data">
                                                                                            <a href="/kafe/edit/<?= $skafe->id_kafe; ?>" class="asbn btn btn-primary bi bi-pencil-square" role="button"></a>
                                                                                        </div>
                                                                                        <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="hapus data">
                                                                                            <form id="delete-form-<?= $skafe->id_kafe; ?>" action="/admin/delete_Kafe/<?= $skafe->id_kafe; ?>" method="post">
                                                                                                <?= csrf_field(); ?>
                                                                                                <input type="hidden" name="_method" value="DELETE">
                                                                                                <button type="button" class="asbn btn btn-danger bi bi-trash delete-btn" data-id="<?= $skafe->id_kafe; ?>"></button>
                                                                                            </form>
                                                                                        </div>
                                                                                        <div class="btn-group mr-2" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="lihat data">
                                                                                            <!-- Trigger modal -->
                                                                                            <button type="button" role="button" id="infos" class="asbn btn btn-secondary bi bi-eye" data-bs-toggle="modal" data-bs-target="#infoModal-<?= $skafe->id_kafe ?>" onclick="showMap<?= $skafe->id_kafe; ?>()"></button>
                                                                                        </div>
                                                                                        <!-- Modal detail -->
                                                                                        <div class=" modal fade" id="infoModal-<?= $skafe->id_kafe ?>" tabindex="-1" aria-labelledby="infoModalLabel-<?= $skafe->id_kafe ?>" aria-hidden="true">
                                                                                            <div class="modal-dialog modal-lg modal-fullscreen-lg-down">
                                                                                                <div class="modal-content">
                                                                                                    <div class="modal-header">
                                                                                                        <h5 class="modal-title" id="infoModalLabel-<?= $skafe->id_kafe ?>">Preview</h5>
                                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                                    </div>
                                                                                                    <div class="modal-body">
                                                                                                        <div class="card mb-2">
                                                                                                            <div class="card-body">
                                                                                                                <?php if (empty($skafe->nama_foto)) : ?>
                                                                                                                    <img src="/img/kafe/no image.jpg" class="img-pending">
                                                                                                                <?php else : ?>
                                                                                                                    <?php $foto_kafe = explode(', ', $skafe->nama_foto); ?>
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
                                                                                                                                <th style="font-weight: 400; border-bottom-width: 1px; border-bottom-color: #dee2e6;"><?= $skafe->nama_kafe; ?></th>
                                                                                                                            </tr>
                                                                                                                        </thead>
                                                                                                                        <tbody>
                                                                                                                            <tr>
                                                                                                                                <td>Alamat</td>
                                                                                                                                <th>:</th>
                                                                                                                                <td><?= $skafe->alamat_kafe; ?></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td>Koordinat</td>
                                                                                                                                <th>:</th>
                                                                                                                                <td><?= $skafe->latitude; ?>, <?= $skafe->longitude; ?></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td>Wilayah Administrasi</td>
                                                                                                                                <th>:</th>
                                                                                                                                <td><?= $skafe->nama_kelurahan ?>, Kec. <?= $skafe->nama_kecamatan ?>, <?= $skafe->nama_kabupaten ?></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td>Instagram</td>
                                                                                                                                <th>:</th>
                                                                                                                                <td><a href="https://www.instagram.com/<?= $skafe->instagram_kafe ?>" target="_blank" rel="noopener noreferrer" class="d-inline-flex align-items-center">
                                                                                                                                        <span>@<?= $skafe->instagram_kafe ?> <i class="ri-external-link-line"></i></span></a></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td>Jam Oprasional</td>
                                                                                                                                <th>:</th>
                                                                                                                                <td><?php
                                                                                                                                    $jam_oprasional = json_decode('[' . $skafe->jam_oprasional . ']', true);

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
                                                                                                                                <td><?= date('d M Y H:i:s', strtotime($skafe->created_at)); ?></td>
                                                                                                                            </tr>
                                                                                                                        </tbody>
                                                                                                                    </table>
                                                                                                                </div>
                                                                                                            </div>

                                                                                                        </div>

                                                                                                        <div class="card">
                                                                                                            <div class="card-body">
                                                                                                                <div id="mymap-<?= $skafe->id_kafe ?>" class="map"></div>
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
    <!-- Pie Chart -->
    <script>
        <?php $allKafe = $allKafe ?>
        <?php $kodeTimur = [357824, 357810, 357809, 357803, 357826, 357825, 357808] ?>
        <?php $kodeBarat = [357814, 357827, 357831, 357830, 357818, 357819, 357828] ?>
        <?php $kodePusat = [357805, 357811, 357807, 357813] ?>
        <?php $kodeUtara = [357816, 357812, 357815, 357817, 357829] ?>
        <?php $kodeSelatan = [357804, 357802, 357820, 357806, 357801, 357823, 357822, 357821] ?>
        <?php $surabayaTimur = []; ?>
        <?php $surabayaBarat = []; ?>
        <?php $surabayaPusat = []; ?>
        <?php $surabayaUtara = []; ?>
        <?php $surabayaSelatan = []; ?>
        <?php foreach ($allKafe as $tp) {
            if (in_array($tp->id_kecamatan, $kodeTimur)) {
                $surabayaTimur[] = $tp;
            } elseif (in_array($tp->id_kecamatan, $kodeBarat)) {
                $surabayaBarat[] = $tp;
            } elseif (in_array($tp->id_kecamatan, $kodePusat)) {
                $surabayaPusat[] = $tp;
            } elseif (in_array($tp->id_kecamatan, $kodeUtara)) {
                $surabayaUtara[] = $tp;
            } elseif (in_array($tp->id_kecamatan, $kodeSelatan)) {
                $surabayaSelatan[] = $tp;
            }
        } ?>
        <?php $ZsurabayaTimur = count($surabayaTimur); ?>
        <?php $ZsurabayaBarat = count($surabayaBarat); ?>
        <?php $ZsurabayaPusat = count($surabayaPusat); ?>
        <?php $ZsurabayaUtara = count($surabayaUtara); ?>
        <?php $ZsurabayaSelatan = count($surabayaSelatan); ?>

        $(document).ready(function() {
            var options = {
                series: [<?= $ZsurabayaTimur; ?>, <?= $ZsurabayaBarat; ?>, <?= $ZsurabayaPusat; ?>, <?= $ZsurabayaUtara; ?>, <?= $ZsurabayaSelatan; ?>],
                chart: {
                    width: 300,
                    type: 'pie',

                },
                legend: {
                    position: 'bottom'
                },
                labels: ['Surabaya Timur', 'Surabaya Barat', 'Surabaya Pusat', 'Surabaya Utara', 'Surabaya Selatan'],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 300
                        },

                    }
                }]
            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
        });
    </script>

    <script>
        $(document).ready(function() {
            <?php foreach ($userSubmitKafe as $S) : ?>

                function showMap<?= $S->id_kafe; ?>() {
                    var mymap = L.map('mymap-<?= $S->id_kafe; ?>').setView([<?= $S->latitude; ?>, <?= $S->longitude; ?>], 14);

                    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiNjg2MzUzMyIsImEiOiJjbDh4NDExZW0wMXZsM3ZwODR1eDB0ajY0In0.6jHWxwN6YfLftuCFHaa1zw', {
                        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                            '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
                        id: 'mapbox/streets-v11',
                        tileSize: 512,
                        zoomOffset: -1
                    }).addTo(mymap);
                    L.marker([<?= $S->latitude ?>, <?= $S->longitude ?>]).addTo(mymap)
                }
                $('#infoModal-<?= $S->id_kafe; ?>').on('shown.bs.modal', function() {
                    showMap<?= $S->id_kafe; ?>();
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