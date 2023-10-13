<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Whatsapp extends BaseController
{
    public function __construct()
    {
    }

    public function index()
    {
        $data = [
            'title' => 'Beranda',
        ];
        return view('page/indexHome', $data);
    }

    // public function kirimPesan()
    // {
    //     // Nomor penerima WhatsApp
    //     $nomor_penerima = '628565621565'; // Ganti dengan nomor yang sebenarnya
    //     // Pesan yang akan dikirim
    //     $pesan = 'Klik';
    //     // Membangun URL untuk mengirim pesan WhatsApp
    //     $url = "https://api.whatsapp.com/send?phone=$nomor_penerima&text=" . urlencode($pesan);
    //     // Redirect ke URL WhatsApp
    //     return redirect()->to($url);
    // }
    // public function kirimPesan()
    // {
    //     $curl = curl_init();

    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => "https://panel.rapiwha.com/send_message.php?apikey=6FZIV9EMNO5SD2K1QB3K&number=6285707625406&text=MyText",
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => "",
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 30,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => "GET",
    //     ));

    //     $response = curl_exec($curl);
    //     $err = curl_error($curl);

    //     curl_close($curl);

    //     if ($err) {
    //         echo "cURL Error #:" . $err;
    //     } else {
    //         echo $response;
    //     }
    //     echo "END";
    // }
    // public function tes()
    // {
    //     $curl = curl_init();

    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => 'https://api.fonnte.com/send',
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => '',
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 0,
    //         CURLOPT_FOLLOWLOCATION => true,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => 'POST',
    //         CURLOPT_POSTFIELDS => array(
    //             'target' => '6285707625406',
    //             'message' => 'test message to {name} as {var1}',
    //             'delay' => '2',
    //             'countryCode' => '62',
    //         ),
    //         CURLOPT_HTTPHEADER => array(
    //             'Authorization: _Vz2byuoBISLfIqW_o!T'
    //         ),
    //     ));

    //     $response = curl_exec($curl);

    //     curl_close($curl);
    //     echo $response;
    // }
}
