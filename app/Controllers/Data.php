<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Validation\Exceptions\ValidationException;
use CodeIgniter\Validation\Validation;
use App\Controllers\BaseController;
use App\Models\ModelSetting;
use App\Models\ModelIzin;
use Faker\Extension\Helper;

class Data extends BaseController
{
    protected $ModelSetting;
    protected $ModelIzin;
    public function __construct()
    {
        helper(['form', 'url']);
        $this->setting = new ModelSetting();
        $this->izin = new ModelIzin();
    }

    public function index()
    {
    }

    public function pengajuan()
    {
        $session = session()->getFlashdata('data');
        if ($session != null) {
            $data = [
                'title' => 'Pengajuan',
                'tampilData' => $this->setting->tampilData()->getResult(),
            ];

            return view('page/ajuan', $data);
        }
        return redirect()->to('map');
    }

    public function kirimAjuan()
    {
        // dd($this->request->getVar());
        $data = [
            'kegiatanValue' => $this->request->getVar('kegiatan'),
            'stat_appv' => $this->request->getPost('stat_appv'),
            'koordinat' => $this->request->getPost('koordinat'),
        ];
        session()->setFlashdata('data', $data);

        return redirect()->to('data/pengajuan');
    }

    public function tambahAjuan()
    {
        // dd($this->request->getVar());
        $user = user_id();
        $koordinats = $this->request->getVar('koordinat');
        $koordinat = explode(', ', $koordinats);
        $latitude = $koordinat['0'];
        $longitude = $koordinat['1'];
        $data = [
            'nik' => $this->request->getVar('nik'),
            'nama' => $this->request->getVar('nama'),
            'alamat' => $this->request->getVar('alamat'),
            'kontak' => $this->request->getVar('kontak'),
            'jenis_kegiatan' => $this->request->getVar('kegiatan'),
            'longitude' => $longitude,
            'latitude' => $latitude,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $addIzin =  $this->izin->addIzin($data);
        $insert_id = $this->db->insertID();

        $status = [
            'id_perizinan' => $insert_id,
            'stat_appv' => $this->request->getVar('stat_appv'),
            'user' => $user,
        ];
        $addStatus = $this->izin->addStatus($status);

        if ($addIzin && $addStatus) {
            session()->setFlashdata('success', 'Data Berhasil ditambahkan.');
            return $this->response->redirect(site_url('/map'));
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan data.');
            return $this->response->redirect(site_url('/map'));
        }
    }

    public function detail($id_perizinan)
    {
        $data = [
            'title' => 'Detail Data Perizinan',
            'tampilIzin' => $this->izin->getIzin($id_perizinan)->getRow(),
        ];
        if (empty($data['tampilIzin'])) {
            throw new PageNotFoundException();
        }
        return view('page/detailDataAjuan', $data);
    }

    public function dump()
    {
        $userid = user_id();
        $data = $this->izin->getIzinFive()->getResult();
        echo "<pre>";
        print_r($data);
        die;
    }
}
