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


    public function pdf($id_perizinan)
    {
        $data = [
            'data' => $this->izin->getAllPermohonan($id_perizinan)->getRow(),
        ];
        return view('plotGeojson', $data);
    }
    public function generatePdf($id_perizinan)
    {
        $data = [
            'title' => 'PDF',
            'data' => $this->izin->getAllPermohonan($id_perizinan)->getRow(),
        ];

        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4',
            'orientation' => 'L',
        ]);
        $html = view('plotGeojson', $data);
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output('Plot.pdf', 'I');
    }
}
