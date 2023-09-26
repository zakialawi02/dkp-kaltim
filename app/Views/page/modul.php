<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title><?= $title; ?></title>
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="/img/favicon.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Libraries Stylesheet -->
    <link href="/assets/lib/animate/animate.min.css" rel="stylesheet">
    <link href="/assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="/assets/css/style.css" rel="stylesheet">


    <style>
        #map {
            height: 80vh;
        }
    </style>

</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->

    <!-- NAVBAR HEADER -->
    <?= $this->include('_Layout/_template/_umum/header'); ?>

    <!-- ISI CONTENT -->
    <div class="pt-3"></div>
    <section class="data min-vh-100">

        <div class="title-data">
            <h2 class="text-white"><?= $title; ?></h2>
        </div>
        <div class="container mt-3 pt-3">
            <?php if (empty($dataModul)) : ?>
                <div class="data-list d-flex flex-wrap justify-content-center w-100 gap-2 p-3">
                    <p>Tidak ada data</p>
                </div>
            <?php else : ?>
                <div class="data-list d-flex flex-wrap justify-content-start w-100 gap-2 p-3">
                    <?php foreach ($dataModul as $row) : ?>
                        <div class="card" style="width: 18rem;">
                            <img src=" /img/<?= (empty($row->thumb_modul)) ? 'document.png' : $row->thumb_modul ?>" class="card-img-top p-2" alt="thumbnail" style="width: 8rem; align-self: center;">
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($row->judul_modul); ?></h5>
                                <p class="card-text"><?= esc($row->deskripsi); ?></p>
                                <!-- <p style="font-size: smaller;">Zipped Shapefile</p> -->
                                <a href="/dokumen/modul/<?= esc($row->file_modul); ?>" class="btn btn-primary bi bi-cloud-arrow-down-fill" target="_blank"> Download</a>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php endif ?>

        </div>
    </section>

    <!-- END ISI CONTENT -->


    <!-- FOOTER -->
    <?= $this->include('_Layout/_template/_umum/footer'); ?>



    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!-- Template Javascript -->
    <script src="/assets/js/main.js"></script>



</body>

</html>