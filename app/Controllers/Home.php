<?php

namespace App\Controllers;

use Mpdf\Mpdf;
use App\Models\ModelIzin;
use App\Controllers\BaseController;

class Home extends BaseController
{
    protected $ModelIzin;
    public function __construct()
    {
        $this->izin = new ModelIzin();
    }

    public function index()
    {
        $data = [
            'title' => 'Beranda',
        ];
        return view('page/indexHome', $data);
    }
}
