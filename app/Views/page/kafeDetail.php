<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title><?= $title; ?> | <?= $tampilKafe->nama_kafe; ?></title>
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
            height: 70vh;
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
    <section id="details-kafe" class="p-5 bg-light">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg p-2">
                    <div class="product-imgs">
                        <div class="img-display">
                            <div class="img-showcase">
                                <?php if (empty($tampilKafe->nama_foto)) : ?>
                                    <img src="/img/kafe/no image.jpg" class="grid-item">
                                <?php else : ?>
                                    <?php $foto_kafe = explode(', ', $tampilKafe->nama_foto); ?>
                                    <?php foreach ($foto_kafe as $foto) : ?>
                                        <img src="<?= base_url('/img/kafe/' . $foto); ?>" class="grid-item">
                                    <?php endforeach ?>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="img-select">
                            <?php if (!empty($tampilKafe->nama_foto)) : ?>
                                <?php $foto_kafe = explode(', ', $tampilKafe->nama_foto); ?>
                            <?php endif ?>
                            <?php if (empty($tampilKafe->nama_foto) || count($foto_kafe) === 1) : ?>
                                <div class="img-item"></div>
                            <?php else : ?>

                                <?php $i = 1; ?>
                                <?php foreach ($foto_kafe as $foto) : ?>
                                    <div class="img-item">
                                        <a href="#" data-id="<?= $i; ?>">
                                            <img src="<?= base_url('/img/kafe/' . $foto); ?>" class="grid-item">
                                        </a>
                                    </div>
                                    <?php $i++; ?>
                                <?php endforeach ?>
                            <?php endif ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg p-2">
                    <table class="table table-responsive">
                        <thead class="thead-left">
                            <tr>
                                <th style="font-weight: 400; border-bottom-width: 1px; border-bottom-color: #dee2e6;">Nama Kafe</th>
                                <th style="border-bottom-width: 1px; border-bottom-color: #dee2e6;">:</th>
                                <th style="font-weight: 400; border-bottom-width: 1px; border-bottom-color: #dee2e6;"><?= $tampilKafe->nama_kafe; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Alamat</td>
                                <th>:</th>
                                <td><?= $tampilKafe->alamat_kafe; ?></td>
                            </tr>
                            <tr>
                                <td>Koordinat</td>
                                <th>:</th>
                                <td><?= $tampilKafe->latitude; ?>, <?= $tampilKafe->longitude; ?></td>
                            </tr>
                            <tr>
                                <td>Wilayah Administrasi</td>
                                <th>:</th>
                                <td><?= $tampilKafe->nama_kelurahan ?>, Kec. <?= $tampilKafe->nama_kecamatan ?>, <?= $tampilKafe->nama_kabupaten ?></td>
                            </tr>
                            <tr>
                                <td>Instagram</td>
                                <th>:</th>
                                <td>
                                    <?php if (empty($tampilKafe->instagram_kafe)) : ?>
                                        <p>–</p>
                                    <?php else : ?>
                                        <a href="https://www.instagram.com/<?= $tampilKafe->instagram_kafe ?>" target="_blank" rel="noopener noreferrer" class="d-inline-flex align-items-center">
                                            <span>@<?= $tampilKafe->instagram_kafe ?> <i class="ri-external-link-line"></i></span></a>
                                    <?php endif ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Jam Oprasional</td>
                                <th>:</th>
                                <td><?php
                                    $jam_oprasional = json_decode('[' . $tampilKafe->jam_oprasional . ']', true);
                                    if (empty($jam_oprasional)) {
                                        echo "<p>Tidak ada data</p>";
                                    } else {
                                        // Urutkan array berdasarkan urutan hari (Senin, Selasa, Rabu, dst.)
                                        usort($jam_oprasional[0], function ($a, $b) {
                                            $hari_urutan = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                                            return array_search($a['hari'], $hari_urutan) <=> array_search($b['hari'], $hari_urutan);
                                        });

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
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php if (in_groups('SuperAdmin') || in_groups('Admin')) :; ?>
                                <tr>
                                    <td>Dibuat Pada</td>
                                    <th>:</th>
                                    <td><?= date('d M Y H:i:s', strtotime($tampilKafe->created_at)); ?></td>
                                </tr>
                                <tr>
                                    <td>Terakhir diupdate</td>
                                    <th>:</th>
                                    <td><?= date('d M Y H:i:s', strtotime($tampilKafe->updated_at)); ?></td>
                                </tr>
                                <tr>
                                    <td>Pengirim by</td>
                                    <th>:</th>
                                    <td><?= $tampilKafe->username; ?></td>
                                </tr>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>


    <section id="">
        <div class="map" id="map"></div>
    </section>



    <!-- FOOTER -->
    <?= $this->include('_Layout/_template/_umum/footer'); ?>



    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="/assets/lib/wow/wow.min.js"></script>
    <script src="/assets/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="/assets/js/main.js"></script>

    <script>
        $(document).ready(function() {
            $("th").css("pointer-events", "none");
            $(".no-sort").css("pointer-events", "none");
        });
    </script>
    <script>
        const imgs = document.querySelectorAll('.img-select a');
        const imgBtns = [...imgs];
        let imgId = 1;

        imgBtns.forEach((imgItem) => {
            imgItem.addEventListener('click', (event) => {
                event.preventDefault();
                imgId = imgItem.dataset.id;
                slideImage();
            });
        });

        function slideImage() {
            const displayWidth = document.querySelector('.img-showcase img:first-child').clientWidth;

            document.querySelector('.img-showcase').style.transform = `translateX(${- (imgId - 1) * displayWidth}px)`;
        }

        window.addEventListener('resize', slideImage);
    </script>

    <!-- Leafleat js Component -->
    <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js" integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg=" crossorigin=""></script>
    <script src="https://unpkg.com/geojson-vt@3.2.0/geojson-vt.js"></script>
    <script src="/leaflet/leaflet-geojson-vt.js"></script>
    <script src="/leaflet/leaflet.ajax.min.js"></script>
    <script src="/leaflet/leaflet.ajax.js"></script>
    <script src="/leaflet/L.Control.MousePosition.js"></script>
    <script src="//unpkg.com/leaflet-gesture-handling"></script>

    <!-- Leafleat Setting js-->
    <!-- initialize the map on the "map" div with a given center and zoom -->
    <script>
        // Base map
        var peta1 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiNjg2MzUzMyIsImEiOiJjbDh4NDExZW0wMXZsM3ZwODR1eDB0ajY0In0.6jHWxwN6YfLftuCFHaa1zw', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1
        });

        var peta2 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiNjg2MzUzMyIsImEiOiJjbDh4NDExZW0wMXZsM3ZwODR1eDB0ajY0In0.6jHWxwN6YfLftuCFHaa1zw', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox/satellite-v9'
        });

        var peta3 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        });

        var peta4 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiNjg2MzUzMyIsImEiOiJjbDh4NDExZW0wMXZsM3ZwODR1eDB0ajY0In0.6jHWxwN6YfLftuCFHaa1zw', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox/dark-v10'
        });

        // set frame view
        var map = L.map('map', {
            center: [<?= $tampilKafe->latitude; ?>, <?= $tampilKafe->longitude; ?>],
            zoom: 18,
            layers: [peta1],
            gestureHandling: true,
        })

        // controller
        var baseLayers = {
            "Map": peta1,
            "Satellite": peta2,
            "OSM": peta3,
        };

        map.removeControl(map.zoomControl);
        L.control.layers(baseLayers).addTo(map);
        L.control.mousePosition().addTo(map);
        L.control.scale().addTo(map);

        // set marker place
        var locKafe = L.icon({
            iconUrl: '<?= base_url(); ?>/leaflet/icon/restaurant_breakfast.png',
            iconSize: [40, 40],
            iconAnchor: [17, 40], // point of the icon which will correspond to marker's location
            popupAnchor: [0, -38] // point from which the popup should open relative to the iconAnchor
        });

        L.marker([<?= $tampilKafe->latitude; ?>, <?= $tampilKafe->longitude; ?>], {
            icon: locKafe
        }).addTo(map).bindPopup("<b><?= $tampilKafe->nama_kafe; ?></b></br><?= $tampilKafe->alamat_kafe; ?>").openPopup();
    </script>

</body>

</html>