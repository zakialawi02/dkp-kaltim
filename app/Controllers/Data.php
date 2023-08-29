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
        return view('page/mapCopy', $data);
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
        return view('page/map', $data);
    }

    public function pengajuan()
    {
        $session = session()->getFlashdata('data');
        if ($session != null) {
            $data = [
                'title' => 'Pengajuan Informasi',
                'tampilData' => $this->setting->tampilData()->getResult(),
                'jenisKegiatan' => $this->kegiatan->getJenisKegiatan()->getResult(),
            ];

            return view('page/ajuan', $data);
        }
        return redirect()->to('map');
    }

    public function isiAjuan()
    {
        // dd($this->request->getPost());

        $data = [
            'kegiatanValue' => $this->request->getVar('kegiatan'),
            'geojson' => $this->request->getPost('geojson'),
            'getOverlap' => $this->request->getPost('getOverlap'),
        ];
        session()->setFlashdata('data', $data);
        // echo '<pre>';
        // print_r($data);
        // die;
        return redirect()->to('/data/pengajuan');
    }

    public function tambahAjuan()
    {
        // dd($this->request->getVar());

        $files = $this->request->getFiles();
        // dd($files);
        $uploadFiles = null;
        if (!empty($files['filepond']) && count(array_filter($files['filepond'], function ($file) {
            return $file->isValid() && !$file->hasMoved();
        }))) {
            $uploadFiles = [];
            foreach ($files['filepond'] as $key => $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $originalName = $file->getClientName();
                    $uploadFiles[] = $originalName;
                    $file->move('dokumen/upload-dokumen/', $originalName);
                }
            }
        }

        $user = user_id();
        $data = [
            'nik' => $this->request->getVar('nik'),
            'nib' => $this->request->getVar('nib'),
            'nama' => $this->request->getVar('nama'),
            'alamat' => $this->request->getVar('alamat'),
            'kontak' => $this->request->getVar('kontak'),
            'id_kegiatan' => $this->request->getVar('kegiatan'),
            'lokasi' => $this->request->getVar('drawFeatures'),
            'uploadFiles' => $uploadFiles,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        // dd($data);
        $addPengajuan =  $this->izin->addPengajuan($data);
        $insert_id = $this->db->insertID();
        $stat_appv = 0;
        $status = [
            'id_perizinan' => $insert_id,
            'stat_appv' => $stat_appv,
            'user' => $user,
        ];
        $addStatus = $this->izin->addStatus($status);


        if ($addPengajuan && $addStatus) {
            session()->setFlashdata('success', 'Data Berhasil ditambahkan.');
            return $this->response->redirect(site_url('/dashboard'));
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan data.');
            return $this->response->redirect(site_url('/map'));
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
                return $this->response->redirect(site_url('/admin/data/permohonan/disetujui/semua'));
            }
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui data.');
            if (in_groups('User')) {
                return $this->response->redirect(site_url('/dashboard'));
            } else {
                return $this->response->redirect(site_url('/admin/data/permohonan/disetujui/semua'));
            }
        }
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

    public function petaPreview()
    {
        $data = [
            'tampilData' => $this->setting->tampilData()->getResult(),
        ];
        return view('serverSide/petaPreview', $data);
    }



    // AJAX/SERVER SIDE
    // public function cekData()
    // {
    //     $url = $this->request->getVar('ue');
    //     $response = file_get_contents($url);
    //     if ($response !== false) {
    //         $jsonData = json_decode($response, true);
    //     } else {
    //         echo "Gagal mengambil data dari URL.";
    //     }
    //     $data = [
    //         'jenisKegiatan' => $this->kegiatan->getJenisKegiatan()->getResult(),
    //         'lon' => $this->request->getVar('lon'),
    //         'lat' => $this->request->getVar('lat'),
    //         'url' => $jsonData,
    //     ];
    //     // dd($data);
    //     return view('serverSide/cekHasil', $data);
    // }

    public function cekData()
    {
        $data = [
            'jenisKegiatan' => $this->kegiatan->getJenisKegiatan()->getResult(),
            'objectID' => $this->request->getPost('id'),
            'kawasan' => $this->request->getPost('kawasan'),
            'objectName' => $this->request->getPost('name'),
            'kode' => $this->request->getPost('kode'),
            'orde' => $this->request->getPost('orde'),
            'remark' => $this->request->getPost('remark'),
            'geojsonFeature' => $this->request->getPost('geojsonFeature'),
        ];

        // echo '<pre>';
        // print_r($data);
        // die;
        // dd($data);
        return view('serverSide/cekHasil', $data);
    }

    public function cekStatus()
    {
        $valKegiatan = $this->request->getPost('kegiatanName');
        $fecthKegiatan = $this->kegiatan->getJenisKegiatan($valKegiatan)->getResult();

        $response = [
            'status' => 'Succes',
            'valKegiatan' => $valKegiatan,
            'fecthKegiatan' => $fecthKegiatan,
            'kegiatanName' => $fecthKegiatan[0],
            'kodeKegiatan' => $fecthKegiatan[0]->kode_kegiatan,
        ];
        // echo '<pre>';
        // print_r($response);
        // die;
        // dd($data);
        return $this->response->setJSON($response);
    }
}
