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
    //     
    // }

}
