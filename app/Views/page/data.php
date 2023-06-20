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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Libraries Stylesheet -->
    <link href="/assets/lib/animate/animate.min.css" rel="stylesheet">
    <link href="/assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="/assets/css/style.css" rel="stylesheet">

    <!-- leaflet Component -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css" integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
    <link href="/leaflet/L.Control.MousePosition.css" rel="stylesheet">
    <link rel="stylesheet" href="//unpkg.com/leaflet-gesture-handling/dist/leaflet-gesture-handling.min.css" type="text/css">

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
    <section class="data bg-light">

        <div class="title-data">
            <h2 class="text-white"><?= $title; ?></h2>
        </div>
        <div class="container mt-3">
            <div class="data-list">

                <div class="card">
                    <img src="/img/kafe-list.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Peta Sebaran Kafe</h5>
                        <p class="card-text">Peta Persebaran Kafe di Surabaya</p>
                        <a href="/data" class="btn btn-primary bi bi-cloud-arrow-down-fill"> Download</a>
                    </div>
                </div>

                <div class="card">
                    <img src="/img/kafe-list.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Kafe di Surabaya</h5>
                        <p class="card-text">Data Persebaran Kafe di Surabaya</p>
                        <a href="/kafe/generatepdf" class="btn btn-primary bi bi-cloud-arrow-down-fill" target="_blank"> PDF</a>
                        <a type="button" class="btn btn-primary bi bi-cloud-arrow-down-fill" onclick="downloadGeoJSON()"> Geojson</a>
                    </div>
                </div>

                <?php foreach ($tampilFeatures as $F) : ?>
                    <div class="card">
                        <img src="/img/zipshapefile.webp" class="card-img-top" alt="..." style="width: 11rem; align-self: center;">
                        <div class="card-body">
                            <h5 class="card-title"><?= $F->nama_features; ?></h5>
                            <p class="card-text">Data <?= $F->nama_features; ?> Kota Surabaya.</p>
                            <p style="font-size: smaller;">Zipped Shapefile</p>
                            <a href="/geojson/<?= $F->features; ?>" class="btn btn-primary bi bi-cloud-arrow-down-fill"> Download</a>
                        </div>
                    </div>
                <?php endforeach ?>

            </div>
    </section>

    <!-- END ISI CONTENT -->


    <!-- FOOTER -->
    <?= $this->include('_Layout/_template/_umum/footer'); ?>



    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Template Javascript -->
    <script src="/assets/js/main.js"></script>


    <script>
        function downloadGeoJSON() {
            var apiUrl = "/api/aprv";
            var xhr = new XMLHttpRequest();
            xhr.open("GET", apiUrl, true);
            xhr.responseType = "blob";
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var blob = new Blob([xhr.response], {
                        type: "application/json"
                    });
                    var url = URL.createObjectURL(blob);

                    var a = document.createElement("a");
                    a.href = url;
                    a.download = "data_kafe.geojson";
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                }
            };
            xhr.send();
        }
    </script>

</body>

</html>