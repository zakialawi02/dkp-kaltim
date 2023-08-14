<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Validation\Exceptions\ValidationException;
use CodeIgniter\Validation\Validation;
use App\Controllers\BaseController;
use App\Models\ModelGeojson;
use App\Models\ModelSetting;
use App\Models\ModelIzin;
use App\Models\ModelJenisKegiatan;
use Faker\Extension\Helper;

class Data extends BaseController
{
    protected $ModelGeojson;
    protected $ModelSetting;
    protected $ModelIzin;
    protected $ModelJenisKegiatan;
    public function __construct()
    {
        helper(['form', 'url']);
        $this->FGeojson = new ModelGeojson();
        $this->setting = new ModelSetting();
        $this->izin = new ModelIzin();
        $this->kegiatan = new ModelJenisKegiatan();
    }

    public function index()
    {
        $data = [
            'title' => 'Beranda',
        ];
        return view('page/indexHome', $data);
    }

    public function modul()
    {
        $data = [
            'title' => 'Modul',
        ];
        return view('page/modul', $data);
    }

    public function map()
    {
        $data = [
            'title' => 'Cek Kesesuaian | Map Panel',
            'tampilGeojson' => $this->FGeojson->callGeojson()->getResult(),
            'tampilData' => $this->setting->tampilData()->getResult(),
            'jenisKegiatan' => $this->kegiatan->getJenisKegiatan()->getResult(),
        ];
        // echo '<pre>';
        // print_r($data['tampilGeojson']);
        // die;
        return view('page/map', $data);
    }

    public function mapCopy()
    {
        $data = [
            'title' => 'Cek Kesesuaian | Map Panel',
            'tampilGeojson' => $this->FGeojson->callGeojson()->getResult(),
            'tampilData' => $this->setting->tampilData()->getResult(),
            'jenisKegiatan' => $this->kegiatan->getJenisKegiatan()->getResult(),
        ];
        // echo '<pre>';
        // print_r($data['tampilGeojson']);
        // die;
        return view('page/mapCopy', $data);
    }

    public function pengajuan()
    {
        $session = session()->getFlashdata('data');
        if ($session != null) {
            $kegiatanId = $session['kegiatanValue'];
            $data = [
                'title' => 'Pengajuan',
                'tampilData' => $this->setting->tampilData()->getResult(),
                'jenisKegiatan' => $this->kegiatan->getJenisKegiatan()->getResult(),
                'jenisZona' => $this->kegiatan->getZonaByKegiatanAjax($kegiatanId),
            ];

            return view('page/ajuan', $data);
        }
        return redirect()->to('map');
    }

    public function isiAjuan()
    {
        $data = [
            'kegiatanValue' => $this->request->getVar('kegiatan'),
            'zonaValue' => $this->request->getVar('SubZona'),
            'geojson' => $this->request->getPost('geojson'),
        ];
        session()->setFlashdata('data', $data);
        // echo '<pre>';
        // print_r($data);
        // die;
        return redirect()->to('data/pengajuan');
    }

    public function tambahAjuan()
    {
        // dd($this->request->getVar());
        $user = user_id();
        $data = [
            'nik' => $this->request->getVar('nik'),
            'nama' => $this->request->getVar('nama'),
            'alamat' => $this->request->getVar('alamat'),
            'kontak' => $this->request->getVar('kontak'),
            'id_kegiatan' => $this->request->getVar('kegiatan'),
            'id_sub' => $this->request->getVar('SubZona'),
            'longitude' => $this->request->getVar('longitude'),
            'latitude' => $this->request->getVar('latitude'),
            'polygon' => $this->request->getVar('drawPolygon'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $addIzin =  $this->izin->addIzin($data);
        $insert_id = $this->db->insertID();

        $stat_appv = 0;
        $status = [
            'id_perizinan' => $insert_id,
            'stat_appv' => $stat_appv,
            'user' => $user,
        ];
        $addStatus = $this->izin->addStatus($status);

        if ($addIzin && $addStatus) {
            session()->setFlashdata('success', 'Data Berhasil ditambahkan.');
            return $this->response->redirect(site_url('/dashboard'));
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan data.');
            return $this->response->redirect(site_url('/dashboard'));
        }
    }

    public function updateAjuan()
    {
        // dd($this->request->getVar());
        $id_perizinan = $this->request->getPost('id');
        $data = [
            'nik' => $this->request->getVar('nik'),
            'nama' => $this->request->getVar('nama'),
            'alamat' => $this->request->getVar('alamat'),
            'kontak' => $this->request->getVar('kontak'),
            'id_kegiatan' => $this->request->getVar('kegiatan'),
            'id_sub' => $this->request->getVar('SubZona'),
            'longitude' => $this->request->getVar('longitude'),
            'latitude' => $this->request->getVar('latitude'),
            'polygon' => $this->request->getVar('drawPolygon'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $updateIzin =  $this->izin->updateIzin($data, $id_perizinan);

        if (in_groups('User')) {
            $status = [
                'stat_appv' => '0',
                'date_updated' => date('Y-m-d H:i:s'),
            ];
            $this->izin->saveStatusAppv($status, $id_perizinan);
        }

        if ($updateIzin) {
            session()->setFlashdata('success', 'Data Berhasil diperbarui.');
            if (in_groups('User')) {
                return $this->response->redirect(site_url('/dashboard'));
            } else {
                return $this->response->redirect(site_url('/admin/data/data-permohonan'));
            }
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui data.');
            if (in_groups('User')) {
                return $this->response->redirect(site_url('/dashboard'));
            } else {
                return $this->response->redirect(site_url('/admin/data/data-permohonan'));
            }
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

    public function kontak()
    {
        $data = [
            'title' => 'KONTAK KAMI',
        ];
        return view('page/contact', $data);
    }

    public function noaccess()
    {
        $data = [
            'title' => 'No Access',
            'pesan' => 'Anda Tidak Mempunyai Hak Akses'
        ];
        return view('page/noAccess', $data);
    }




    public function dump()
    {
        $data = $this->kegiatan->getStatusZonasi()->getResultArray();
        echo "<pre>";
        print_r($data);
        die;
    }
}
