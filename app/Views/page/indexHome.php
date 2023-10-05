<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title><?= $title; ?></title>
    <meta content="Simata Laut (Sistem Informasi Tata Ruang Laut)" name="keywords">
    <meta content="Aplikasi Simata Laut Kaltim (Sistem Informasi Tata Ruang Laut Kaltim) Dinas Kelautan dan Perikanan Provinsi Kalimantan Timur." name="description">



    <!-- Favicon -->
    <link href="img/favicon.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="assets/css/style.css" rel="stylesheet">


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
    <!-- ======= Hero Section ======= -->
    <section id="home">
        <div class="container-fluid hero-header bg-light py-5" id="hero">
            <div class="container py-3">
                <div class="row g-2 align-items-center">
                    <div class="hero-content">
                        <h1>Selamat Datang</h1>
                        <p>Di Aplikasi Sistem Informasi Tata Ruang Laut Kaltim (Simata Laut Kaltim) Dinas Kelautan dan Perikanan Provinsi Kalimantan Timur.</p>
                    </div>
                    <div class="d-flex justify-content-center gap-2 ">
                        <a href="/peta" class="btn btn-primary">Cek Kesesuaian Lokasi</a>
                        <a href="https://oss.go.id/" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Via OSS" target="_blank">Ajukan Perizinan Usaha</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Header End -->

    <!-- Modul Segment -->
    <section class="modul pt-5" id="modul" style="min-height: 20vh;">
        <div class="container p-5 ">

            <center class="">
                <h2>Modul</h2>
            </center>

            <center class="">
                <p>Modul ini adalah koleksi sumber daya untuk membantu anda menjelajahi tata ruang laut di Provinsi Kalimantan Timur. Temukan peraturan, panduan, dan dokumen penting lainnya.</p>
                <br>
                <a href="/data/modul" class="btn btn-primary">Lihat Dokumen</a>
            </center>

        </div>
    </section>


    <!-- About Segment -->
    <section class="about pt-5" id="about" style="min-height: 20vh;">
        <div class="container p-5 ">

            <center class="">
                <h2>Tentang Kami</h2>
            </center>

            <center class="">
                <p>Aplikasi Simata Laut Kaltim (Sistem Informasi Tata Ruang Laut Kaltim) merupakan aplikasi yang dapat digunakan oleh masyarakat umum untuk memberikan akses Informasi Kesesuaian Kegiatan Pemanfaatan Ruang Laut di wilayah pesisir dan laut Provinsi Kalimantan Timur.</p>
            </center>

        </div>
    </section>

    <!-- discover -->
    <section id="discover">

        <div class="container p-5">
            <div class="mt-5 p-2"></div>
            <center>
                <h2>Ajukan Permohonan</h2>
                <p>Anda dapat mengajukan permohonan informasi ruang laut secara mandiri dengan sistem daring (online)</p>
            </center>

            <div class="d-flex flex-wrap gap-4 align-content-center justify-content-center mt-3 pt-2">
                <div class="card" style="width: 15rem;">
                    <img src="<?= base_url('/img/checking.png'); ?>" class="card-img-top p-4">
                    <div class="card-body">
                        <center>
                            <h5 class="card-title">Cek Kesesuaian</h5>
                            <p class="card-text">Melihat Kesesuaian Kegiatan Pemanfaatan Ruang Laut.</p>
                        </center>
                    </div>
                </div>
                <div class="card" style="width: 15rem;">
                    <img src="<?= base_url('/img/create.png'); ?>" class="card-img-top p-4">
                    <div class="card-body">
                        <center>
                            <h5 class="card-title">Buat Ajuan</h5>
                            <p class="card-text">Buat Ajuan Melakukan permohonan Informasi Kesesuaian ruang Laut secara mandiri dengan sistem daring (online).</p>
                        </center>
                    </div>
                </div>
                <div class="card" style="width: 15rem;">
                    <img src="<?= base_url('/img/verification.png'); ?>" class="card-img-top p-4">
                    <div class="card-body">
                        <center>
                            <h5 class="card-title">Lihat Status Ajuan</h5>
                            <p class="card-text">Pemohon dapat melihat status pengajuan Informasi Kesesuaian Ruang Laut.</p>
                        </center>
                    </div>
                </div>

            </div>
            <!-- <div id="google_translate_element"></div> -->
        </div>
    </section>
    <!-- discover End -->

    <!-- FOOTER -->
    <?= $this->include('_Layout/_template/_umum/footer'); ?>




    <!-- 
    <script>
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'id',
                includedLanguages: 'en,id',
                autoDisplay: true
            }, 'google_translate_element');
            let tr = `<option value="">ID</option>
                    <option value="en">EN</option>`;
            let skipTranslateElement = document.getElementsByClassName('goog-te-combo');
            if (skipTranslateElement) {
                skipTranslateElement.innerHTML = tr;
            }
        }
    </script>
    <script src="http://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script> -->
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Template Javascript -->
    <script src="assets/js/main.js"></script>

    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>

</body>

</html>