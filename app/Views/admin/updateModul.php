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
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css " rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="/css/StyleAdmin.css" rel="stylesheet" />

    <style>
        table {
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 0.3px solid #d5d5d5;
        }

        .dataTables_filter {
            margin-bottom: 1rem;
        }

        .paginate_button.disabled,
        .paginate_button.disabled:hover,
        .paginate_button.disabled:active {
            cursor: default;
            color: #666 !important;
            border: 1px solid transparent !important;
            background: transparent !important;
            box-shadow: none;
        }

        .paginate_button {
            border: 1px solid rgb(52, 93, 167) !important;
        }

        .paginate_button:hover,
        .paginate_button:active {
            background-color: rgb(52, 93, 167) !important;
            background: rgb(52, 93, 167) !important;
        }

        /* #hasilKesesuaian {
            overflow-x: auto;
        } */
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
                    <h1 class="mt-2 mb-3">Edit Data Modul</h1>





                    <div class="card mb-4">
                        <div class="card-body">

                            <form novalidate action="/admin/update_modul/<?= $dataModul->id_modul; ?>" id="editForm" method="post" enctype="multipart/form-data" autocomplete="off">
                                <?php csrf_field() ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="judul_modul" class="form-label">Judul Modul <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control form-control-sm" id="judul_modul" name="judul_modul" placeholder="Nama/Judul Modul" value="<?= old('judul_modul', esc($dataModul->judul_modul)); ?>" required>
                                            <?php if (session()->has('errors')) : ?>
                                                <span class="text-danger"><?= session('errors.judul_modul') ?></span>
                                            <?php endif ?>
                                        </div>
                                        <div class="mb-3">
                                            <label for="deskripsi" class="form-label">Deskripsi Modul <span style="color: red;">*</span></label>
                                            <textarea type="text" class="form-control form-control-sm" id="deskripsi" name="deskripsi" placeholder="Nama/Judul Modul" rows="5" required><?= old('deskripsi', esc($dataModul->deskripsi)); ?></textarea>
                                            <?php if (session()->has('errors')) : ?>
                                                <span class="text-danger"><?= session('errors.judul_modul') ?></span>
                                            <?php endif ?>
                                        </div>
                                        <div class="mb-3">
                                            <label for="fileModul" class="form-label">File Modul </label>
                                            <input class="form-control form-control-sm" id="fileModul" name="fileModul" type="file" value="<?= esc($dataModul->file_modul); ?>">
                                            <div id="emailHelp" class="form-text">Kosongkan jika tidak ada file update</div>
                                        </div>
                                        <!-- <div class="mb-3">
                                            <label for="thumbModul" class="form-label">Thumbnail</label>
                                            <input class="form-control form-control-sm" id="thumbModul" name="thumbModul" type="file" accept="image/*" value="<?= esc($dataModul->thumb_modul); ?>">
                                        </div> -->
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary" id="updatekan">Simpan</button>
                                    </div>
                                </div>
                            </form>
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
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js "></script>
    <script src="/js/scripts.js"></script>



</body>

</html>