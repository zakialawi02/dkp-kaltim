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
    <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css " rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="/assets/css/style.css" rel="stylesheet">


</head>

<body>

    <!-- HEADER -->
    <?= $this->include('_Layout/_template/_umum/header'); ?>



    <!-- ISI CONTENT -->
    <section class="contact bg-light" id="contact">

        <div class="container-fluid p-md-4 justify-content-center">
            <center>
                <h1 class="heading-title">HUBUNGI KAMI</h1>
            </center>

            <div class="contact-center">
                <div class="left">
                    <div class="mapG">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7921.938879648819!2d117.14430572708419!3d-0.4901748562340048!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df67f6d43f9887d%3A0x85dff83cf4af5ca8!2sDinas%20Kelautan%20Dan%20Perikanan%20Provinsi%20Kalimantan%20Timur!5e0!3m2!1sen!2sid!4v1687421095892!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>

                    <div>
                        <span class="icon"><i class="bi bi-geo-alt"></i></span>
                        <span class="content">
                            <h3>Alamat</h3>
                            <span>Jalan Kesuma Bangsa, Dadi Mulya,
                                Samarinda, Kota Samarinda, Kalimantan
                                Timur No. 1, Kode Pos : 75242
                                Kalimantan Timur</span>
                        </span>
                    </div>
                    <div>
                        <span class="icon"><i class="bi bi-envelope"></i></span>
                        <span class="content">
                            <h3>Email</h3>
                            <span>sungramdkpkaltim@gmail.com</span> <br>
                            <span>dkpkaltimprl@gmail.com</span>
                        </span>
                    </div>
                    <div>
                        <span class="icon"><i class="bi bi-whatsapp"></i></span>
                        <span class="content">
                            <h3>Administrator</h3>
                            <span>+62 852-4761-1815 (Fajar)</span> <br>
                            <span>+62 895-7006-22086 (Wahyu)</span>
                        </span>
                    </div>

                </div>

                <div class="right">

                    <!-- versi 2 -->
                    <form action="/email/kontak/send" method="post" autocomplete="off" class="form" id="myForm" name="myform">
                        <?= csrf_field(); ?>
                        <div>
                            <input type="text" placeholder="Nama" name="name" id="name" required />
                            <div class="feedback kosong" id="kosongName"></div>
                            <input type="email" placeholder="Email" name="email" id="email" required />
                            <div class="feedback kosong" id="kosongEmail"></div>
                        </div>
                        <input type="text" placeholder="Subjek" name="judul" id="judul" required />
                        <div class="feedback kosong" id="kosongJudul"></div>
                        <textarea cols="10" rows="10" placeholder="Pesan Anda" name="message" id="message" required></textarea>

                        <div id="terkirim"></div>
                        <button class="btn-contact" type="submit" id="sendMail" name="sendMail">Kirim</button>
                    </form>

                </div>
            </div>
        </div>



    </section>


    <!-- END ISI CONTENT -->



    <!-- FOOTER -->
    <?= $this->include('_Layout/_template/_umum/footer'); ?>



    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js "></script>

    <!-- Template Javascript -->
    <script src="/assets/js/main.js"></script>



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