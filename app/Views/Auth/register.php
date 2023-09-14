<!doctype html>
<html lang="en">

<head>
    <title><?= $title; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link href="/img/favicon.png" rel="icon">

    <link href="/css/map.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->

    <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="/css/masukJoin.css">

</head>

<body>
    <!-- NAVBAR HEADER -->
    <?= $this->include('Auth/_header'); ?>

    <div class="container pt-4">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <div id="second">
                    <div class="myform form ">
                        <div class="logo mb-3">
                            <div class="col-md-12 text-center">
                                <h1><?= lang('Auth.register') ?></h1>
                            </div>

                            <?= view('Myth\Auth\Views\_message_block') ?>

                        </div>

                        <form action="<?= url_to('register') ?>" method="post">
                            <?= csrf_field() ?>

                            <p class=""> <span style="color: red;">*</span> <span style="font-size: small; color: grey;">Wajib di isi</span> </p>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Lengkap <span style="color: red;">*</span></label>
                                <input type="text" name="full_name" class="form-control" aria-describedby="emailHelp" placeholder="Enter Full Name" value="<?= old('full_name') ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="username"><?= lang('Auth.username') ?>/Username <span style="color: red;">*</span></label>
                                <input type="text" class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" name="username" id="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>" aria-describedby="emailHelp">
                                <p class="form-text usernameFail d-none" style="color: red; font-size: small;">Username Tidak Boleh Mengandung Spasi</p>
                            </div>

                            <div class="form-group">
                                <label for="email"><?= lang('Auth.email') ?> <span style="color: red;">*</span></label>
                                <input type="email" name="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" id="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>">
                                <small id="emailHelp" class="form-text text-muted"><?= lang('Auth.weNeverShare') ?></small>
                            </div>

                            <div class="form-group">
                                <label for="password"><?= lang('Auth.password') ?> <span style="color: red;">*</span></label>
                                <input type="password" name="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="pass_confirm">Ulangi Password <span style="color: red;">*</span></label>
                                <input type="password" name="pass_confirm" class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.repeatPassword') ?>" autocomplete="off">
                            </div>

                            <div class="col-md-12 text-center mb-3">
                                <button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm kirim"><?= lang('Auth.register') ?></button>
                            </div>

                            <div class="col-md-12 ">
                                <div class="form-group">
                                    <p class="text-center">Sudah terdaftar? <a href="<?= url_to('login') ?>"><?= lang('Auth.signIn') ?></a></p>
                                </div>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        $("#username").keyup(function(e) {
            let username = $("#username").val();
            console.log(username);
            if (username.indexOf(' ') !== -1) {
                $(".usernameFail").removeClass('d-none');
                $("#username").addClass('is-invalid');
                $(".kirim").attr('disabled', true);
            } else {
                $(".usernameFail").addClass('d-none');
                $("#username").removeClass('is-invalid');
                $(".kirim").attr('disabled', false);
            }
        });
    </script>
</body>

</html>