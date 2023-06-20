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

    <!-- Template Main CSS File -->
    <link href="/css/StyleAdmin.css" rel="stylesheet" />

    <!-- leaflet Component -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css" integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
    <link href="/leaflet/L.Control.MousePosition.css" rel="stylesheet">
    <link rel="stylesheet" href="//unpkg.com/leaflet-gesture-handling/dist/leaflet-gesture-handling.min.css" type="text/css">

    <style>
        #map {
            height: 70vh;
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

                    <div class="mb-4 mt-2">
                        <div class="pagetitle">
                            <h1><?= $title; ?></h1>
                        </div>

                        <div class="row">
                            <div class="col-lg">
                                <div class="card">

                                    <div class="card-body">
                                        <h4 class="card-title">Tambah Data</h4>

                                        <form class="row g-3" action="/admin/tambah_Geojson" method="post" enctype="multipart/form-data">
                                            <?= csrf_field(); ?>

                                            <div class="mb-3">
                                                <label for="Nkec" class="form-label">Nama Wilayah</label>
                                                <input type="text" class="form-control" id="Nkec" aria-describedby="textlHelp" name="Nkec">
                                            </div>
                                            <div class="col-md-10">
                                                <label for="formFile" class="form-label">Upload File GeoJSON</label>
                                                <input class="form-control" type="file" name="Fjson" id="Fjson" accept=".geojson, .json, .zip">
                                                <div id="FileHelp" class="form-text">.zip (zipped shapefile and associated file)/.GeoJSON</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="exampleColorInput" class="form-label">Color</label>
                                                <input type="color" class="form-control form-control-color" name="Kwarna" id="Kwarna" value="#4383F0" title="Choose your color">
                                            </div>


                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>

                                    </div>
                                </div>
                            </div>



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
    <script src="https://kit.fontawesome.com/816b3ace5c.js" crossorigin="anonymous"></script>

    <!-- Template Main JS File -->
    <script src="/js/scripts.js"></script>

</body>

</html>