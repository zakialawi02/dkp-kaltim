<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Validation\Exceptions\ValidationException;
use CodeIgniter\Validation\Validation;
use App\Controllers\BaseController;
use App\Models\ModelSetting;
use App\Models\ModelIzin;
use App\Models\ModelJenisKegiatan;
use App\Models\ModelKesesuaian;
use App\Models\ModelNamaZona;
use Faker\Extension\Helper;

class Data extends BaseController
{
    protected $ModelSetting;
    protected $ModelIzin;
    protected $ModelJenisKegiatan;
    protected $ModelKesesuaian;
    protected $ModelNamaZona;
    public function __construct()
    {
        helper(['form', 'url']);
        $this->setting = new ModelSetting();
        $this->izin = new ModelIzin();
        $this->kegiatan = new ModelJenisKegiatan();
        $this->kesesuaian = new ModelKesesuaian();
        $this->zona = new ModelNamaZona();
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

    public function peta()
    {
        $data = [
            'title' => 'Cek Kesesuaian | Map Panel',
            'tampilData' => $this->setting->tampilData()->getResult(),
            'jenisKegiatan' => $this->kegiatan->getJenisKegiatan()->getResult(),
        ];
        // echo '<pre>';
        // print_r($data['tampilGeojson']);
        // die;
        return view('page/petaCekKesesuaian', $data);
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
        return redirect()->to('/peta');
    }

    public function isiAjuan()
    {
        // dd($this->request->getPost());
        $data = [
            'kegiatanValue' => $this->request->getVar('kegiatan'),
            'geojson' => $this->request->getPost('geojson'),
            'getOverlap' => $this->request->getPost('getOverlap'),
            'valZona' => $this->request->getPost('idZona'),
        ];
        // dd($data);
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
            'id_kegiatan' => $this->request->getVar('idKegiatan'),
            'kode_kawasan' => $this->request->getVar('kawasan'),
            'id_zona' => $this->request->getVar('idZona'),
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
            return $this->response->redirect(site_url('/peta'));
        }
    }

    // public function updateAjuan()
    // {
    //     // dd($this->request->getVar());
    //     $id_perizinan = $this->request->getPost('id');
    //     $data = [
    //         'nik' => $this->request->getVar('nik'),
    //         'nama' => $this->request->getVar('nama'),
    //         'alamat' => $this->request->getVar('alamat'),
    //         'kontak' => $this->request->getVar('kontak'),
    //         'id_kegiatan' => $this->request->getVar('kegiatan'),
    //         'id_sub' => $this->request->getVar('SubZona'),
    //         'longitude' => $this->request->getVar('longitude'),
    //         'latitude' => $this->request->getVar('latitude'),
    //         'polygon' => $this->request->getVar('drawPolygon'),
    //         'created_at' => date('Y-m-d H:i:s'),
    //         'updated_at' => date('Y-m-d H:i:s'),
    //     ];
    //     $updatePengajuan =  $this->izin->updatePengajuan($data, $id_perizinan);

    //     if (in_groups('User')) {
    //         $status = [
    //             'stat_appv' => '0',
    //             'date_updated' => date('Y-m-d H:i:s'),
    //         ];
    //         $this->izin->saveStatusAppv($status, $id_perizinan);
    //     }

    //     if ($updatePengajuan) {
    //         session()->setFlashdata('success', 'Data Berhasil diperbarui.');
    //         if (in_groups('User')) {
    //             return $this->response->redirect(site_url('/dashboard'));
    //         } else {
    //             return $this->response->redirect(site_url('/admin/data/permohonan/disetujui/semua'));
    //         }
    //     } else {
    //         session()->setFlashdata('error', 'Gagal memperbarui data.');
    //         if (in_groups('User')) {
    //             return $this->response->redirect(site_url('/dashboard'));
    //         } else {
    //             return $this->response->redirect(site_url('/admin/data/permohonan/disetujui/semua'));
    //         }
    //     }
    // }

    // Delete Data
    public function delete_pengajuan($id_perizinannya)
    {
        $datas = $this->izin->getAllPermohonan($id_perizinannya)->getRow();
        if (!empty($datas->uploadFiles)) {
            $uploadFiles = explode(",", $datas->uploadFiles);
            foreach ($uploadFiles as $file) {
                $file = trim($file, '()"');
                $file = 'dokumen/upload-dokumen/' . $file;
                if (file_exists($file)) {
                    // echo "Menghapus file: $file<br>";
                    unlink($file);
                }
            }
        }
        // die;
        $this->izin->delete(['id_perizinannya' => $id_perizinannya]);
        if ($this) {
            session()->setFlashdata('success', 'Data berhasil dihapus.');
            if (in_groups('User')) {
                return $this->response->redirect(site_url('/dashboard'));
            } else {
                return $this->response->redirect(site_url('/admin/data/permohonan/disetujui/semua'));
            }
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data.');
            if (in_groups('User')) {
                return $this->response->redirect(site_url('/dashboard'));
            } else {
                return $this->response->redirect(site_url('/admin/data/permohonan/disetujui/semua'));
            }
        }
    }

    public function editPengajuan($id_perizinan)
    {

        $kegiatanId = $this->izin->getAllPermohonan($id_perizinan)->getRow();
        if (empty($kegiatanId)) {
            throw new PageNotFoundException();
        }
        $kegiatanId = $kegiatanId->id_kegiatan;
        $data = [
            'title' => 'Data Pengajuan',
            'tampilData' => $this->setting->tampilData()->getResult(),
            'tampilIzin' => $this->izin->getAllPermohonan($id_perizinan)->getRow(),
            'jenisKegiatan' => $this->kegiatan->getJenisKegiatan()->getResult(),
        ];
        // dd($data);
        return view('admin/updatePengajuan', $data);
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

    public function petaPreview()
    {
        $data = [
            'tampilData' => $this->setting->tampilData()->getResult(),
        ];
        return view('serverSide/petaPreview', $data);
    }



    // AJAX/SERVER SIDE 

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
        $getOverlapProperties = $this->request->getPost('getOverlapProperties');
        $valKegiatan = $this->request->getPost('valKegiatan');
        $fecthKegiatan = $this->kegiatan->getJenisKegiatan($valKegiatan)->getResult();
        $KodeKegiatan = $fecthKegiatan[0]->kode_kegiatan;
        $namaZona = $getOverlapProperties['namaZona'][0];
        $id_zona = $this->zona->whereZona($namaZona)->getResult();
        $id_zona = $id_zona[0]->id_zona;
        $kode_kawasan = $getOverlapProperties['kodeKawasan'][0];
        $response = [
            'status' => 'Succes',
            'valueKegiatan' => $valKegiatan,
            'KodeKegiatan' => $KodeKegiatan,
            'valZona' => $id_zona,
            'nameKegiatan' => $fecthKegiatan[0]->nama_kegiatan,
            'hasil' => $this->kesesuaian->searchKesesuaian($KodeKegiatan, $id_zona, $kode_kawasan)->getResultArray(),
        ];
        // echo '<pre>';
        // print_r($response);
        // die;
        // dd($response);
        return $this->response->setJSON($response);
    }


    public function dumpp()
    {
        $kode_kegiatan = "K1";
        $id_zona = 5;
        $kode_kawasan = "KPU-W-02";
        $dd = $this->kesesuaian->searchKesesuaian($kode_kegiatan, $id_zona, $kode_kawasan)->getResult();
        dd($dd);
    }
    public function dumpz()
    {
        $cari = "Pencadangan/Indikasi Kawasan Konservasi";
        $dd = $this->izin->getAllPermohonan()->getResult();
        // $dd = $this->zona->whereZona($cari)->getResult();
        dd($dd);
    }
}
