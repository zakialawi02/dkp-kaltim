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

    <div class="container pt-5">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <div id="second">
                    <div class="myform form ">
                        <div class="logo mb-3">
                            <div class="col-md-12 text-center">
                                <h1><?= lang('Auth.resetYourPassword') ?></h1>
                            </div>

                            <?= view('Myth\Auth\Views\_message_block') ?>

                        </div>

                        <p><?= lang('Auth.enterCodeEmailPassword') ?></p>

                        <form action="<?= url_to('reset-password') ?>" method="post">
                            <?= csrf_field() ?>

                            <div class="form-group">
                                <label for="token"><?= lang('Auth.token') ?></label>
                                <input type="text" id="token" class="form-control <?php if (session('errors.token')) : ?>is-invalid<?php endif ?>" name="token" placeholder="<?= lang('Auth.token') ?>" value="<?= old('token', $token ?? '') ?>" required>
                                <div class="invalid-feedback">
                                    <?= session('errors.token') ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email"><?= lang('Auth.email') ?></label>
                                <input type="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" name="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>">
                                <div class="invalid-feedback" required>
                                    <?= session('errors.email') ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password"><?= lang('Auth.newPassword') ?></label>
                                <input type="password" id="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" name="password">
                                <div class="invalid-feedback" required>
                                    <?= session('errors.password') ?>
                                </div>
                                <div id="passwordHelp" class="form-text" style="color: red;font-size: small;"></div>
                            </div>

                            <div class="form-group">
                                <label for="pass_confirm"><?= lang('Auth.newPasswordRepeat') ?></label>
                                <input type="password" id="pass_confirm" name="pass_confirm" class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" required>
                                <div class="invalid-feedback">
                                    <?= session('errors.pass_confirm') ?>
                                </div>
                            </div>

                            <br>

                            <button type="submit" class="btn btn-primary btn-block kirim"><?= lang('Auth.resetPassword') ?></button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="/js/action=1.js"></script>
</body>

</html>