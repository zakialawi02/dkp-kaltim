<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use Mpdf\Mpdf;
use App\Models\ModelGeojson;
use App\Models\ModelKv;
use App\Models\ModelSetting;
use App\Models\ModelFoto;

class Kafe extends BaseController
{
    protected $ModelGeojson;
    protected $ModelKv;
    protected $ModelSetting;
    protected $ModelFoto;
    public function __construct()
    {
        $this->FGeojson = new ModelGeojson();
        $this->kafe = new ModelKv();
        $this->setting = new ModelSetting();
        $this->fotoKafe = new ModelFoto();
    }

    public function index()
    {
        $data = [
            'title' => 'Beranda',
            'tampilData' => $this->setting->tampilData()->getResult(),
        ];
        // echo '<pre>';
        // print_r($data['tampilKafe']);
        // die;
        return view('page/indexHome', $data);
    }





    public function pdf()
    {
        $data = [
            'title' => 'PDF',
            'tampilKafe' => $this->kafe->callKafe()->getResult(),
        ];
        return view('page/pdfKafe', $data);
    }

    public function generatePdf()
    {
        $data = [
            'title' => 'PDF',
            'tampilKafe' => $this->kafe->callKafe()->getResult(),
        ];

        $mpdf = new \Mpdf\Mpdf();
        $html = view('page/pdfKafe', $data);
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output('data_kafe.pdf', 'I');
    }
}
