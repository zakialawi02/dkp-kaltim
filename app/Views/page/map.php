<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title><?= $title; ?></title>
    <!-- Favicon -->
    <link href="/img/favicon.png" rel="icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css " rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Template Stylesheet -->
    <link href="/css/map.css" rel="stylesheet">

    <!-- leaflet Component -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css" integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
    <link href="/leaflet/L.Control.MousePosition.css" rel="stylesheet">
    <link rel="stylesheet" href="/leaflet/leaflet-sidepanel.css" />
    <link rel="stylesheet" href="/leaflet/iconLayers.css" />
    <link rel="stylesheet" href="/leaflet/leaflet.contextmenu.css" />
    <link rel="stylesheet" href="/leaflet/Leaflet.NavBar.css" />
    <link rel="stylesheet" href="https://unpkg.com/@geoman-io/leaflet-geoman-free@latest/dist/leaflet-geoman.css" />

</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->

    <!-- ISI CONTENT -->
    <!-- spinner -->
    <div id="loading-spinner" class="spinner-container d-flex justify-content-center align-items-center position-fixed top-0 start-0 w-100 h-100 d-none">
        <div class="spinner-border text-light" role="status"></div>
    </div>

    <!-- Modal dialog login-->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="loginModalLabel">Login</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?= view('Myth\Auth\Views\_message_block') ?>
                    <form action="<?= url_to('login') ?>" method="post" name="login">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="login"><?= lang('Auth.emailOrUsername') ?></label>
                            <input type="text" class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" name="login" placeholder="<?= lang('Auth.emailOrUsername') ?>">
                            <div class="invalid-feedback">
                                <?= session('errors.login') ?>
                            </div>
                            <div class="invalid-feedback" id="loginError"></div>
                        </div>
                        <div class="mb-3">
                            <label for="password"><?= lang('Auth.password') ?></label>
                            <input type="password" name="password" class="form-control  <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>" aria-describedby="emailHelp">
                            <div class="invalid-feedback">
                                <?= session('errors.password') ?>
                            </div>
                            <div class="invalid-feedback" id="passwordError"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-check-label">
                                <input type="checkbox" name="remember" class="form-check-input" <?php if (old('remember')) : ?> checked <?php endif ?>>
                                <?= lang('Auth.rememberMe') ?>
                            </label>
                        </div>
                        <div class="form-group">
                            <p class="text-center">Don't have account? <a href="<?= url_to('register') ?>" id="signup">Sign up here</a></p>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col">
                                <button type="submit" id="login-submit" class=" btn btn-block mybtn btn-primary tx-tfm"><?= lang('Auth.loginAction') ?></button>
                                <button id="spinnerss" class="btn btn-primary" type="button" disabled>
                                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Login... </button>
                            </div>
                            <div class="col">
                                <p class="text-center">
                                    <a href="<?= url_to('forgot') ?>" class="google btn mybtn"><?= lang('Auth.forgotYourPassword') ?>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Data -->
    <div class="modalAdds" id="modalAdd">
        <div class="modalAdd-content">
            <div class="modal-header">
                <h3>Cek Informasi</h3>
                <button class="close-button" id="close-button">&times;</button>
            </div>
            <hr>
            <div class="modalAdd-body">
                <div class="card-body">
                    <form class="row g-3" action="/data/isiAjuan" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>

                        <?php if (in_groups('User')) : ?>
                            <input type="hidden" class="form-control" for="stat_appv" id="stat_appv" name="stat_appv" value="0">
                        <?php else : ?>
                            <input type="hidden" class="form-control" for="stat_appv" id="stat_appv" name="stat_appv" value="0">
                        <?php endif ?>
                        <input type="hidden" class="form-control" for="koordinat" id="koordinat" name="koordinat" value="">
                        <input type="hidden" class="form-control" for="geojson" id="geojson" name="geojson" value="">

                        <div class="form-group">
                            <label class="col-md-12 mb-2">Jenis Kegiatan</label>
                            <select class="form-select" id="pilihKegiatan" name="kegiatan" for="kegiatan" style="width: 100%;" required>
                                <option></option>
                                <?php foreach ($jenisKegiatan as $K) : ?>
                                    <option value="<?= $K->id_kegiatan; ?>"><?= $K->nama_kegiatan; ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 mb-2" for="SubZona">Zona Kegiatan:</label>
                            <select class="form-select" name="SubZona" id="SubZona" style="width: 100%;" required disabled>
                                <option value="">Pilih Kegiatan terlebih dahulu</option>
                            </select>
                        </div>

                        <div class="feedback">Keterangan:</div>
                        <div class="info">
                            <div class="feedback" id="showKegiatan"> </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Lanjutkan</button>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <div class="p-2"></div>
            </div>
        </div>
    </div>

    <div id="button-section-group" class="">
        <div id="button-section" class="float-end m-1">
            <button id="modal-button" class="btn btn-primary">Cek Kesesuaian</button>
            <?php if (logged_in()) : ?>
                <a class="btn btn-primary" href="/dashboard" role="button">Dashboard</a>
                <button type="button" id="logout-btn" class="btn btn-primary">Log Out</button>
                <button id="spinners" class="btn btn-primary" type="button" disabled>
                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Logout... </button>
            <?php else : ?>
                <button type="button" id="login-btn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
            <?php endif ?>
        </div>
        <!-- kolom cari -->
        <!-- <div class="search-container float-end">
            <form action="#" method="get">
                <div class="input-group">
                    <input type="text" id="cariMark" class="form-control input-cari" placeholder="Cari...">
                    <span class="input-group-btn">
                        <button type="button" role="button" class="btn btn-primary btn-cari"><i class="bi bi-search"></i></button>
                    </span>
                </div>
            </form>
        </div> -->



    </div>



    <div class="map" id="map">

        <!-- side Panel -->
        <div id="panelID" class="sidepanel" aria-label="side panel" aria-hidden="false">
            <div class="sidepanel-inner-wrapper">
                <nav class="sidepanel-tabs-wrapper" aria-label="sidepanel tab navigation">
                    <ul class="sidepanel-tabs">
                        <li class="sidepanel-tab">
                            <a href="#" class="sidebar-tab-link" role="tab" data-tab-link="tab-1"><i class="bi bi-layers-fill"></i></a>
                            <a href="#" class="sidebar-tab-link" role="tab" data-tab-link="tab-2"><i class="bi bi-gear-fill"></i></a>
                        </li>

                    </ul>
                </nav>
                <div class="sidepanel-content-wrapper">
                    <div class="sidepanel-content">
                        <div class="sidepanel-tab-content" data-tab-content="tab-1">
                            <h4>Layer</h4>
                            <hr>

                        </div>

                        <div class="sidepanel-tab-content" data-tab-content="tab-2">
                            <h4>About</h4>
                            <hr>
                            <p>Aplikasi ini merupakan aplikasi yang dapat digunakan oleh masyarakat umum untuk melihat pemanfaatan dan penggunaan apa saja yang dapat dilakukan pada wilayah pesisir dan laut Provinsi Kalimantan Timur.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sidepanel-toggle-container">
                <button class="sidepanel-toggle-button" type="button" aria-label="toggle side panel"></button>
            </div>
        </div>

    </div>


    <!-- END ISI CONTENT -->

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js "></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Template Javascript -->
    <!-- <script src="/assets/js/main.js"></script> -->

    <script>
        $(document).ready(function() {
            var dataKegiatan;
            $('#pilihKegiatan').change(function() {
                var kegiatanId = $(this).val();

                if (kegiatanId !== '') {
                    $('#SubZona').prop('disabled', false);

                    $.ajax({
                        url: "<?= base_url('admin/getZonaByKegiatan') ?>",
                        method: "POST",
                        data: {
                            kegiatanId: kegiatanId
                        },
                        dataType: 'json',
                        success: function(response) {
                            var options = '<option value="">Pilih Zona Kegiatan</option>';

                            if (response.length > 0) {
                                dataKegiatan = response;
                                $.each(response, function(index, SubZona) {
                                    options += '<option value="' + SubZona.id_sub + '">' + SubZona.nama_subzona + '</option>';
                                });
                            }
                            $('#SubZona').html(options);
                        }
                    });
                } else {
                    $('#SubZona').prop('disabled', true);
                    $('#SubZona').html('<option value="">Pilih Kegiatan terlebih dahulu</option>');
                }
            });

            $('#SubZona').change(function(e) {
                var zonaId = $(this).val();
                var result = dataKegiatan.filter(function(item) {
                    return item.id_sub === zonaId;
                });
                var kode_zone = result[0].kode_zonasi;
                var status = result[0].status_zonasi;
                var showKegiatan = $('#showKegiatan');
                console.log(kode_zone);
                showKegiatan.removeClass().addClass('feedback');
                if (status === '1') {
                    showKegiatan.text('Diperbolehkan').addClass('boleh');
                } else if (status === '2') {
                    showKegiatan.text('Diperbolehkan Bersyarat').addClass('bolehBersyarat');
                } else if (status === '3') {
                    showKegiatan.text('Tidak diperbolehkan').addClass('tidakBoleh');
                } else {
                    showKegiatan.text('');
                }
            });
        });
    </script>

    <?php if (in_groups('Admin' && 'SuperAdmin')) : ?>
        <?php if (session()->getFlashdata('success')) : ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '<?= session()->getFlashdata('success'); ?>',
                    timer: 5000,
                    html: 'Data berhasil ditambahkan,  ' +
                        '<a href="/dashboard">lihat dashboard</a> ',
                });
            </script>
        <?php else : ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '<?= session()->getFlashdata('success'); ?>',
                    timer: 5000,
                    html: 'Menunggu verifikasi, lihat status data anda ' +
                        '<a href="/dashboard">disini</a> ' +
                        ' atau masuk ke dashboard',
                });
            </script>
        <?php endif; ?>
    <?php endif ?>


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

    <!-- modalAdd -->
    <script>
        const modalButton = document.getElementById("modal-button");
        const modal = document.getElementById("modalAdd");
        const closeButton = document.getElementById("close-button");

        modalButton.addEventListener("click", function() {
            <?php if (logged_in()) : ?>
                $("#modal-button").addClass("btn-warning");
                map.pm.enableDraw("Polygon", {
                    snappable: true,
                    snapDistance: 20,
                });
                if (drawnLayer) {
                    map.removeLayer(drawnLayer);
                }
            <?php else : ?>
                $("#loading-spinner").removeClass("d-none");
                setTimeout(function() {
                    $("#loading-spinner").addClass("d-none");
                    Swal.fire({
                        title: 'Anda harus login terlebih dahulu',
                        customClass: {
                            container: 'my-swal',
                        },
                    })
                    var logModal = new bootstrap.Modal($('#loginModal'));
                    logModal.show();
                }, 500);
            <?php endif ?>
        });

        $('#close-button').click(function(e) {
            $('#modalAdd').hide();
        });

        window.addEventListener("click", function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        });
    </script>
    <!-- login/logout -->
    <script>
        $(document).ready(function() {
            $('form[name="login"]').submit(function(event) {
                event.preventDefault(); // prevent default form submit behavior
                $('#loginError').text('');
                $('#passwordError').text('');
                var login = $('input[name="login"]').val().trim();
                var password = $('input[name="password"]').val().trim();
                if (login == '') {
                    $("#loginError").text('Masukkan email/username');
                    if (password == '' || password.length < 4) {
                        $("#passwordError").text('Masukkan password');
                    }
                    return;
                }
                if (password == '' || password.length < 4) {
                    $("#passwordError").text('Masukkan password');
                    return;
                }
                var form = $(this);
                var url = form.attr('action');
                var method = form.attr('method');
                var data = form.serialize();
                $('#login-submit').hide();
                $('#spinnerss').show();
                // AJAX request
                $.ajax({
                    url: url,
                    type: method,
                    data: data,
                    success: function(response) {
                        location.reload();
                        // Swal.fire({
                        //     title: "Login Berhasil!",
                        //     icon: "success",
                        //     showConfirmButton: false,
                        //     timer: 1000
                        // }).then(() => {
                        //     $('.modal').hide();
                        //     $('.modal-backdrop').hide();
                        //     $('#button-section-group').load(location.href + ' #button-section');
                        //     location.reload();
                        // });
                    },
                });
            });

            $('#logout-btn').click(function(e) {
                e.preventDefault();
                $('#logout-btn').hide();
                $('#spinners').show();
                // tunggu 500ms sebelum menjalankan AJAX
                $.ajax({
                    url: "/logout",
                    type: "GET",
                }).done(function() {
                    // $('#spinners').hide();
                    // $('#button-section-group').load(location.href + ' #button-section');
                    // Swal.fire({
                    //     icon: 'success',
                    //     title: 'Berhasil Logout.',
                    //     showConfirmButton: false,
                    //     timer: 1000
                    // }).then(() => {
                    location.reload();
                    // });
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#pilihKegiatan').select2({
                placeholder: "Pilih Jenis Kegiatan",
                allowClear: true
            });
            $('#SubZona').select2({
                placeholder: "Pilih Zona Wilayah Kegiatan",
                allowClear: true
            });
        });
    </script>

    <!-- Leafleat js Component -->
    <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js" integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg=" crossorigin=""></script>
    <script src="https://unpkg.com/geojson-vt@3.2.0/geojson-vt.js"></script>
    <script src="/leaflet/leaflet.ajax.js"></script>
    <script src="/leaflet/L.Control.MousePosition.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-tilelayer-geojson/1.0.2/TileLayer.GeoJSON.min.js"></script>
    <script src="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-omnivore/v0.3.1/leaflet-omnivore.min.js"></script>
    <script src="/leaflet/leaflet-sidepanel.min.js"></script>
    <script src="/leaflet/Leaflet.Control.Custom.js"></script>
    <script src="/leaflet/iconLayers.js"></script>
    <script src="/leaflet/leaflet.contextmenu.js"></script>
    <script src="/leaflet/catiline.js"></script>
    <script src="/leaflet/leaflet.shpfile.js"></script>
    <script src="/leaflet/shp.js"></script>
    <script src="/leaflet/leaflet-hash.js"></script>
    <script src="/leaflet/Leaflet.NavBar.js"></script>
    <script src="/leaflet/turf.min.js"></script>
    <!-- <script src='https://unpkg.com/@turf/turf@6/turf.min.js'></script> -->
    <script src="https://unpkg.com/@geoman-io/leaflet-geoman-free@latest/dist/leaflet-geoman.min.js"></script>

    <!-- Leafleat Setting js-->
    <!-- initialize the map on the "map" div with a given center and zoom -->
    <script>
        // Base map
        var peta1 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiNjg2MzUzMyIsImEiOiJjbDh4NDExZW0wMXZsM3ZwODR1eDB0ajY0In0.6jHWxwN6YfLftuCFHaa1zw', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1
        });

        var peta2 = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: '&copy; <a href="https://www.google.com/maps">Google Maps</a> contributors',
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
        <?php foreach ($tampilData as $D) : ?>
            var map = L.map('map', {
                center: [<?= $D->coordinat_wilayah; ?>],
                zoom: <?= $D->zoom_view; ?>,
                layers: [peta1],
                zoomControl: false,
                attributionControl: false,
                contextmenu: true,
                contextmenuWidth: 200,
                contextmenuItems: [{
                    text: 'Copy coordinates',
                    icon: '/leaflet/icon/copy.png',
                    callback: function(e) {
                        copyCoordinates(e);
                    }
                }, {
                    text: 'Center map here',
                    callback: function(e) {
                        centerMap(e);
                    }
                }, ]
            })
        <?php endforeach ?>

        function centerMap(e) {
            map.panTo(e.latlng);
        }

        function copyCoordinates(e) {
            var latlng = e.latlng;
            var lat = latlng.lat.toFixed(6);
            var lng = latlng.lng.toFixed(6);
            var coordinates = lat + ',' + lng;
            navigator.clipboard.writeText(coordinates);
            alert('Koordinat ' + coordinates + ' berhasil disalin ke clipboard');
        }

        var addKafe;

        // add Leaflet-Geoman controls with some options to the map  
        map.pm.setLang("id");
        // map.pm.addControls({
        //     position: 'topleft',
        //     drawCircleMarker: false,
        //     rotateMode: false,
        //     drawPolyline: false,
        //     drawRectangle: false,
        //     drawCircleMarker: false,
        //     dragMode: false,
        //     drawCircle: false,
        //     drawText: false,
        //     cutPolygon: false,
        //     splitMode: false,
        // });
        var drawnLayer;
        map.on('pm:create', function(e) {
            var layer = e.layer;
            var koordinats = e.layer.getLatLngs()[0];
            drawnLayer = layer;
            var geojson = koordinats.map(function(coord) {
                return [coord.lat, coord.lng];
            });
            var geojson = JSON.stringify(geojson);
            $('#geojson').val(geojson);
            $('#modalAdd').show();
            $("#modal-button").removeClass("btn-warning");
            detectOverlap();
        });

        function detectOverlap() {
            // Dapatkan GeoJSON dari layer yang digambar
            var drawnGeoJSON = drawnLayer.toGeoJSON();
            // Buat array untuk menyimpan data geometri shapefile yang overlap atau di dalam
            var overlappingFeatures = [];
            // Loop melalui setiap fitur pada shapefile
            geoshp.eachLayer(function(layer) {
                // Dapatkan GeoJSON dari fitur pada shapefile
                var shapefileGeoJSON = layer.toGeoJSON();
                console.log(shapefileGeoJSON);
                // Buat objek turf dari GeoJSON
                var drawnPoly = turf.polygon(drawnGeoJSON.geometry.coordinates);
                var shapefilePoly = turf.polygon(shapefileGeoJSON.geometry.coordinates);
                // console.log(shapefileGeoJSON);
                // Periksa overlap antara layer yang digambar dan shapefile menggunakan Turf.js
                var overlap = turf.booleanOverlap(drawnPoly, shapefilePoly);
                var within = turf.booleanWithin(drawnPoly, shapefilePoly);

                if (overlap || within) {
                    // Jika terdapat overlap, lakukan tindakan yang diinginkan
                    console.log('Overlap detected!');
                    var overlappingFeature = {
                        geometry: shapefileGeoJSON.geometry,
                        properties: shapefileGeoJSON.properties,
                    };
                    // Tambahkan data ke dalam array overlappingFeatures
                    overlappingFeatures.push(overlappingFeature);
                }
            });
            console.log(overlappingFeatures);
            // Ambil properti "zona" dari overlappingFeatures
            // var overlappingZones = overlappingFeatures.map(function(feature) {
            //     return feature.properties.zona;
            // });
            // console.log(overlappingZones);
        }

        // controller
        var zoomControl = L.control.zoom({
            position: 'bottomright'
        }).addTo(map);
        var baseLayers = new L.Control.IconLayers(
            [{
                    title: 'Default', // use any string
                    layer: peta1, // any ILayer
                    icon: '/leaflet/icon/here_normaldaygrey.png' // 80x80 icon
                },
                {
                    title: 'Satellite',
                    layer: peta2,
                    icon: '/leaflet/icon/here_satelliteday.png'
                },
                {
                    title: 'OSM',
                    layer: peta3,
                    icon: '/leaflet/icon/openstreetmap_mapnik.png'
                },
            ], {
                position: 'bottomright',
                maxLayersInRow: 3
            }
        );
        baseLayers.addTo(map);
        L.control.mousePosition().addTo(map);
        L.control.scale().addTo(map);
        L.control.navbar().addTo(map);
        var hash = new L.Hash(map);

        // Tambahkan control accordion pada peta
        var legendControl = L.control({
            position: 'bottomleft'
        });
        legendControl.onAdd = function(map) {
            var div = L.DomUtil.create('div', 'legend-panel');
            div.innerHTML = `<div class="accordion" id="legendAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            Legenda
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#legendAccordion">
                        <div class="accordion-body">
                            <div class="legend-item1000">
                            </div>
                            <div class="legend-item0">
                            </div>
                            <div class="legend-item1">
                            </div>
                            <div class="legend-item2">
                            </div>
                            <div class="legend-item3">
                            </div>
                            <div class="legend-item4">
                            </div>
                            <div class="legend-item5">
                            </div>
                            <div class="legend-item6">
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
            return div;
        };
        legendControl.addTo(map);

        // SidePanel
        const panelRight = L.control.sidepanel('panelID', {
            panelPosition: 'left',
            tabsPosition: 'left',
            pushControls: true,
            darkMode: false,
            startTab: 'tab-1'
        }).addTo(map);


        // shapefile untuk batas admin detectme()
        var geoshp = L.geoJson({
            features: []
        }, );

        var wfunc = function(base, cb) {
            importScripts('/leaflet/shp.js');
            shp(base).then(cb);
        }
        var worker = cw({
            data: wfunc
        }, 2);
        worker.data(cw.makeUrl('/geojson/RZ50K_AR_REVISIMAR_2021_FIX_29_Maret.zip')).then(function(data) {
            geoshp.addData(data).addTo(map);
        }, function(a) {
            console.log(a)
        });


        const screenWidth = screen.availWidth
        if (screenWidth < 455) {
            var controlElement = baseLayers.getContainer();
            controlElement.style.position = 'fixed';
            controlElement.style.bottom = '0.2rem';
            controlElement.style.right = '0.2rem';
            var zoomTombol = zoomControl.getContainer();
            zoomTombol.style.display = 'none';
        } else {
            var controlElement = baseLayers.getContainer();
            controlElement.style.position = 'fixed';
            controlElement.style.bottom = '0.8rem';
            controlElement.style.right = '3rem';
            var zoomTombol = zoomControl.getContainer();
            zoomTombol.style.position = 'absolute';
            zoomTombol.style.bottom = '0.2rem';
            zoomTombol.style.right = '0.2rem';
        }
    </script>

</body>

</html>