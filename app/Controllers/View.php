<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelSetting;
use App\Models\ModelAdministrasi;
use App\Models\ModelGeojson;
use App\Models\ModelKv;
use App\Models\ModelFoto;

class View extends BaseController
{
    protected $ModelSetting;
    protected $ModelAdministrasi;
    protected $ModelGeojson;
    protected $ModelKv;
    public function __construct()
    {
        $this->setting = new ModelSetting();
        $this->Administrasi = new ModelAdministrasi();
        $this->FGeojson = new ModelGeojson();
        $this->kafe = new ModelKv();
        $this->fotoKafe = new ModelFoto();
    }

    public function index()
    {
        $data = [
            'title' => 'Lihat Peta',
            'tampilData' => $this->setting->tampilData()->getResult(),
            'tampilGeojson' => $this->FGeojson->callGeojson()->getResult(),
            'updateGeojson' => $this->FGeojson->callGeojson()->getRow(),
            'tampilKafe' => $this->kafe->callKafe(),
        ];
        return view('page/viewMap', $data);
    }

    public function table()
    {
        $data = [
            'title' => 'Table',
        ];
        return view('page/dataTable', $data);
    }

    public function form()
    {
        $data = [
            'title' => 'Form',
        ];
        return view('page/formEx', $data);
    }

    public function dump()
    {
        $data = [
            'title' => 'Dump',
        ];
        // dd($this->request->getVar());
        $opens = $this->request->getVar('open-time[]');
        $open = [];
        foreach ($opens as $item) {
            if ($item == '') {
                $open[] = null;
            } else {
                $open[] = $item;
            }
        }
        // print_r($open);
        $closes = $this->request->getVar('close-time[]');
        $close = [];
        foreach ($closes as $item) {
            if ($item == '') {
                $close[] = null;
            } else {
                $close[] = $item;
            }
        }
        // print_r($close);
        $day = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        // Mengambil id kafe
        $id = [];
        foreach ($open as $key) {
            $id[] = "109";
        }
        // print_r($id);
        $datas = [
            'kafe_id' => $id,
            'hari' => $day,
            'open_time' => $open,
            'close_time' => $close
        ];
        $data = [];
        $i = 0;
        foreach ($datas as $key => $val) {
            $i = 0;
            foreach ($val as $k => $v) {
                $data[$i][$key] = $v;
                $i++;
            }
        }
        $addTime = $this->kafe->addTime($data);
        if ($addTime) {
            session()->setFlashdata('alert', 'Data Anda Berhasil Ditambahkan.');
            return $this->response->redirect(site_url('/view/form'));
        }
    }
}
