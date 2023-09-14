<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Cache-Control" content="no-cache; max-age=0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no;address=no;email=no">
    <title></title>
    <style type="text/css">
        @media (max-width: 400px) {
            @-ms-viewport {
                width: 320px !important;
            }
        }

        @media only screen and (max-width : 620px) {
            table[class="maincont"] {
                padding: 0 !important;
            }

            table[class="container"] {
                width: 95% !important;
                border: 2px solid #000;
            }

            table[class="sociallinks"] {
                width: 100% !important;
            }

            span[class="infooter"] {
                line-height: 18px !important;
            }

            p[class="headstyle"] {
                font-size: 36px !important;
                line-height: 46px !important;
            }

            p[class="bodycopy"] {
                font-size: 18px !important;
                line-height: 26px !important;
            }

            td[class="coltd"] {
                display: block !important;
                width: 100% !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            td[class="cencoltd"] {
                display: block !important;
                width: 100% !important;
                text-align: center !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            td[class="social-col"] {
                display: block;
                padding: 0 0 8px 0 !important;
                width: 100% !important;
                height: auto !important;
                text-align: center !important;
            }

            td[class="spacer60"] {
                height: 30px !important;
            }

            td[class="spacer40"] {
                height: 20px !important;
            }
        }
    </style>
</head>

<body style="background-color: #e8eaea; color: #364141; font-size: 16pt; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 1.4; margin: 0; padding: 0; -webkit-text-size-adjust: none; -ms-text-size-adjust: none; width: 100%;">

    <table class="maincont" style="width: 100%;" border="0" cellspacing="0" cellpadding="0" width="100%">
        <tbody class="logocell" style="padding-top: 15px; padding-bottom: 15px;" width="157" align="left" valign="top">
            <tr style="padding: 0 3px 0 3px;" align="center" valign="top" bgcolor="#e8eaea">
                <td align="center" valign="top">
                    <h2 style="font-size: 25px; font-weight: 700;">SIMATA LAUT</h2>
                </td>
            </tr>
            <tr style="padding: 0 3px 0 3px;" align="center" valign="top" bgcolor="#e8eaea">
                <td align="center" valign="top">
                    <!-- 600px container -->
                    <table class="container" border="0" cellspacing="0" cellpadding="0" width="600">
                        <tbody class="logocell" style="padding-top: 15px; padding-bottom: 15px;" width="157" align="left" valign="top">
                            <tr style="padding: 0 3px 0 3px;" align="center" valign="top" bgcolor="#e8eaea">
                                <td align="center" valign="top">
                                    <!-- Main email body container -->
                                    <table style="background-color: #ffffff; width: 100%;" border="0" cellspacing="0" cellpadding="0">
                                        <tbody class="logocell" style="padding-top: 15px; padding-bottom: 15px;" width="157" align="left" valign="top">
                                            <tr>
                                                <td class="spacer60" height="40" align="center"></td>
                                            </tr>
                                            <tr>
                                                <td align="center" valign="top" bgcolor="#FFFFFF">
                                                    <table style="background-color: #ffffff; width: 100%;" border="0" cellspacing="0" cellpadding="0">
                                                        <tbody class="logocell" style="padding-top: 15px; padding-bottom: 15px;" width="157" align="left" valign="top">
                                                            <tr>
                                                                <td class="text-left" align="start" valign="top" bgcolor="#FFFFFF" style="text-align: start; padding: 15px 25px;">
                                                                    <p style="font-size: 16px; font-weight: normal;">
                                                                        Kami telah menerima permintaan reset kata sandi
                                                                        untuk akun Anda yang terkait dengan alamat email
                                                                        yang terdaftar di <?= site_url() ?>. Jika Anda
                                                                        tidak melakukan permintaan ini, mohon abaikan
                                                                        email ini.</p>
                                                                    <p style="font-size: 16px; font-weight: normal;">
                                                                        Untuk melanjutkan proses reset kata sandi, Klik
                                                                        tombol dibawah ini:</p>
                                                                    <p style="font-size: 16px; font-weight: normal;"><a class="btn btn-primary" href="<?= url_to('reset-password') . '?token=' . $hash ?>" style="text-decoration: none; display: inline-block; font-weight: 400; line-height: 1.5; text-align: center; vertical-align: middle; cursor: pointer; user-select: none; border: 1px solid transparent; padding: .375rem .75rem; font-size: 1rem; border-radius: 3px; transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; color: #ffffff; background-color: #345DA7; border-color: #345DA7;">Reset
                                                                            Password</a>.</p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-left sm-font" align="start" valign="top" bgcolor="#FFFFFF" style="text-align: start; padding: 15px 25px;">
                                                                    <p style="font-size: 16px; font-weight: normal;">
                                                                        Jika tombol di atas
                                                                        tidak berfungsi, silakan
                                                                        klik url ini</p>
                                                                    <p style="font-size: 16px; font-weight: normal;"><a href="<?= url_to('reset-password') . '?token=' . $hash ?>"><?= url_to('reset-password') . '?token=' . $hash ?></a>.
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-left sm-font" align="start" valign="top" bgcolor="#FFFFFF" style="text-align: start; padding: 15px 25px;">
                                                                    <p style="font-size: 16px; font-weight: normal;">
                                                                        Perlu diketahui bahwa tautan atau kode reset
                                                                        kata sandi ini hanya berlaku dalam jangka waktu
                                                                        terbatas.
                                                                    </p>
                                                                    <p style="font-size: 16px; font-weight: normal;">
                                                                        Jika Anda tidak berhasil mereset kata
                                                                        sandi dalam waktu yang ditentukan, Anda mungkin
                                                                        perlu meminta reset ulang.
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-left" align="start" valign="top" bgcolor="#FFFFFF" style="text-align: start; padding: 15px 25px;">
                                                                    <p style="font-weight: normal; font-size: 13px; margin: 0;">
                                                                        Pesan ini
                                                                        dikirim secara otomatis.</p>
                                                                    <p style="font-weight: normal; font-size: 13px; margin: 0;">
                                                                        Anda tidak
                                                                        perlu
                                                                        membalas pesan ini.</p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <table style=" background-color: #ffffff; width: 100%;" border="0" cellspacing="0" cellpadding="0">
                                                                    <tbody class="logocell" width="157" align="left" valign="top">
                                                                        <tr>
                                                                            <td style="padding: 15px 5px; font-size: 12px;" align="center" valign="top" bgcolor="#e8eaea">

                                                                                <a href="<?= base_url('/kontak'); ?>">Punya
                                                                                    Pertanyaan? Kontak Kami
                                                                                </a>.

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="center" valign="top" bgcolor="#e8eaea">
                                                                                <div></div>
                                                                                <p style="font-weight: normal; margin: 0; font-size: 12px;">
                                                                                    <?= site_url() ?>
                                                                                </p>
                                                                                <p style="font-weight: normal; margin: 0; margin-bottom: 20px; font-size: 12px;">
                                                                                    Dinas Kelautan Dan
                                                                                    Perikanan Provinsi Kalimantan Timur
                                                                                </p>

                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>


</body>

</html>