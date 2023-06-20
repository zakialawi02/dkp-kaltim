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
            'tampilKafe' => $this->kafe->callKafe()->getResult(),
            'randomFour' => $this->kafe->randomFour()->getResult(),
        ];
        // echo '<pre>';
        // print_r($data['tampilKafe']);
        // die;
        return view('page/indexHome', $data);
    }

    public function detail($id_kafe)
    {
        $data = [
            'title' => 'Detail Kafe',
            'tampilKafe' => $this->kafe->callKafe($id_kafe)->getRow(),
        ];
        if (empty($data['tampilKafe'])) {
            throw new PageNotFoundException();
        }
        // echo '<pre>';
        // print_r($data['tampilKafe']);
        // die;
        return view('page/kafeDetail', $data);
    }

    public function sebaran()
    {
        $data = [
            'title' => 'Beranda',
            'tampilData' => $this->setting->tampilData()->getResult(),
            'tampilKafe' => $this->kafe->callKafe()->getResult(),
        ];
        return view('page/persebaran', $data);
    }

    public function cari()
    {
        $data = [
            'title' => 'Cari',
            'tampilData' => $this->setting->tampilData()->getResult(),
            'tampilKafe' => $this->kafe->callKafe()->getResult(),
        ];
        return view('page/cariKafe', $data);
    }

    public function search()
    {
        // Menerima keyword data yang akan dihapus dari permintaan POST
        $keyword = $this->request->getGet('keyword');

        $data = [
            'tampilData' => $this->setting->tampilData()->getResult(),
            'tampilKafe' => $this->kafe->cariKafe($keyword),
        ];
        return view('serverSide/seacrhMap', $data);
    }

    public function near()
    {
        $data = [
            'title' => 'Near',
            'tampilData' => $this->setting->tampilData()->getResult(),
            'tampilKafe' => $this->kafe->callKafe()->getResult(),
        ];
        return view('page/nearby', $data);
    }

    public function noaccess()
    {
        $data = [
            'title' => 'No Access',
            'pesan' => 'Anda Tidak Mempunyai Hak Akses'
        ];
        return view('page/noAccess', $data);
    }

    public function contact()
    {
        $data = [
            'title' => 'CONTACT',
        ];
        return view('page/contact', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'ABOUT',
        ];
        return view('page/about', $data);
    }

    public function data()
    {
        $data = [
            'title' => 'DATA',
            'tampilFeatures' => $this->FGeojson->callGeojson()->getResult(),
            'tampilKafe' => $this->kafe->callKafe()->getResult(),
        ];
        return view('page/data', $data);
    }

    public function sebaran_kafe()
    {
        $data = [
            'title' => 'DATA',
            'tampilData' => $this->setting->tampilData()->getResult(),
            'tampilKafe' => $this->kafe->callKafe()->getResult(),
        ];
        return view('page/data', $data);
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

    public function peta_pdf()
    {
        $data = [
            'title' => 'Beranda',
            'tampilGeojson' => $this->FGeojson->callGeojson()->getResult(),
            'tampilData' => $this->setting->tampilData()->getResult(),
            'tampilKafe' => $this->kafe->callKafe()->getResult(),
        ];
        return view('page/peta', $data);
    }

    public function map()
    {
        $data = [
            'title' => 'Map Panel',
            'tampilGeojson' => $this->FGeojson->callGeojson()->getResult(),
            'tampilData' => $this->setting->tampilData()->getResult(),
        ];
        // echo '<pre>';
        // print_r($data['tampilGeojson']);
        // die;
        return view('page/map', $data);
    }
}
