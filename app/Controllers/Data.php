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
use App\Models\ModelZonaKawasan;
use Faker\Extension\Helper;

class Data extends BaseController
{
    protected $ModelSetting;
    protected $ModelIzin;
    protected $ModelJenisKegiatan;
    protected $ModelKesesuaian;
    protected $ModelNamaZona;
    protected $ModelZonaKawasan;
    public function __construct()
    {
        helper(['form', 'url']);
        $this->setting = new ModelSetting();
        $this->izin = new ModelIzin();
        $this->kegiatan = new ModelJenisKegiatan();
        $this->kesesuaian = new ModelKesesuaian();
        $this->zona = new ModelNamaZona();
        $this->kawasan = new ModelZonaKawasan();
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
        $result = [];
        $getOverlapProperties = $this->request->getPost('getOverlapProperties');
        $valKegiatan = $this->request->getPost('valKegiatan');
        $fecthKegiatan = $this->kegiatan->getJenisKegiatan($valKegiatan)->getResult();
        $KodeKegiatan = $fecthKegiatan[0]->kode_kegiatan;

        if (!empty($getOverlapProperties[0])) {
            $selectedKegiatan = $this->selectKegiatan($KodeKegiatan);
            $namaZona = array_map(function ($feature) {
                return $feature['namaZona'];
            }, $getOverlapProperties);
            $id_zona = array_map(function ($feature) {
                return $this->zona->searchZona($feature)->getResult()[0];
            }, $namaZona);
            $kode_kawasan = array_map(function ($feature) {
                return $feature['kodeKawasan'];
            }, $getOverlapProperties);

            foreach ($selectedKegiatan as $value) {
                if (in_array($value->kawasan, $kode_kawasan) && in_array($value->nama_zona, $namaZona)) {
                    $result[] = $value;
                }
            }
            $response = [
                'status' => 'Succes',
                'valueKegiatan' => $valKegiatan,
                'KodeKegiatan' => $KodeKegiatan,
                'valZona' => $id_zona,
                'nameKegiatan' => $fecthKegiatan[0]->nama_kegiatan,
                'hasil' => $result,
            ];
        } else {
            $result;
            $response = [
                'status' => 'Succes',
                'valueKegiatan' => $valKegiatan,
                'KodeKegiatan' => $KodeKegiatan,
                'valZona' => [],
                'nameKegiatan' => $fecthKegiatan[0]->nama_kegiatan,
                'hasil' => $result,
            ];
        }
        // echo '<pre>';
        // print_r($response);
        // die;
        // dd($response);
        return $this->response->setJSON($response);
    }

    private function selectKegiatan($kode_kegiatan)
    {
        $result = $this->kesesuaian->selectedByKegiatan($kode_kegiatan)->getResult();
        return $result;
    }


    public function dump()
    {
        $kode_kegiatan = "K32";
        $id_zona = ["6"];
        $kode_kawasan = ["KPU-PL-06"];
        // $id_zona = ["2"];
        // $kode_kawasan = ["KK-P3K-ZPT-14"];
        $sub = "Zona Inti";

        $dd = $this->kesesuaian->searchKesesuaian($kode_kegiatan, $id_zona, $kode_kawasan)->getResult();
        // echo '<pre>';
        // print_r($dd);
        // die;
        dd($dd);
    }
    public function dumpp()
    {
        $kode_kegiatan = "K164";
        // $id_zona = ["5"];
        // $kode_kawasan = ["KPU-W-02"];
        $id_zona = ["2", "6"];
        $kode_kawasan = ["KK-P3K-ZPT-14", "KPU-PL-15", "KPU-PL-10"];

        $selectedKegiatan = $this->selectKegiatan($kode_kegiatan);
        dd($selectedKegiatan);
        for ($i = 0; $i < count($id_zona); $i++) {
            foreach ($kode_kawasan as $value) {
                $ddt = $this->kesesuaian->searchKesesuaian($kode_kegiatan, $id_zona[$i], $value)->getResult();
                if (!empty($ddt)) {
                    echo $id_zona[$i] . "<br>";
                    $dd[] = $ddt[0];
                }
            }
        }
        foreach ($dd as $row) {
            if (!empty($row->sub_zona)) {
                echo "konservasi";
            }
        }
        echo '<pre>';
        // print_r($dd);
        // die;
        dd($dd);
    }
    // public function dumpp()
    // {
    //     $kode_kegiatan = "K1";
    //     // $id_zona = ["5"];
    //     // $kode_kawasan = ["KPU-W-02"];
    //     $id_zona = ["5", "2", "6"];
    //     $kode_kawasan = ["KPU-W-02", "KPU-W-11", "KK-P3K-ZPT-14", "KPU-PL-15"];
    //     $dd = [];

    //     $zone = [1, 2, 3, 4];
    //     foreach ($zone as $val) {
    //         $dd[] = $this->kawasan->getZKawasan($val)->getResult();
    //     }
    //     $dd = array_merge(...$dd);
    //     foreach ($dd as $row) {
    //         $code[] = $row->kode_kawasan;
    //     }

    //     for ($i = 0; $i < count($id_zona); $i++) {
    //         if (in_array($id_zona[$i], $zone)) {
    //             for ($ii = 0; $ii < count($kode_kawasan); $ii++) {
    //                 $kode_kawasan[$ii];
    //                 if (in_array($kode_kawasan[$ii], $code)) {
    //                     echo $kode_kawasan[$ii];
    //                 }
    //             }
    //             echo "ada konservasi" . "<br>";
    //         } else {
    //             foreach ($kode_kawasan as $value) {
    //                 echo $id_zona[$i] . "<br>";
    //                 $ddt = $this->kesesuaian->searchKesesuaian($kode_kegiatan, $id_zona[$i], $value)->getResult();
    //                 if (!empty($ddt)) {
    //                     $dd[] = $ddt;
    //                 }
    //             }
    //         }
    //     }
    //     echo '<pre>';
    //     // print_r($dd);
    //     die;
    //     dd($dd);
    // }
    public function dumpkeg()
    {
        $valKegiatan = "138";
        $fecthKegiatan = $this->kegiatan->getJenisKegiatan($valKegiatan)->getResult();
        dd($fecthKegiatan);
    }
    public function dumpzon()
    {
        $namaZona = 'zona pariwisata';
        $id_zona = $this->zona->searchZona($namaZona)->getResult();
        dd($id_zona);
    }
    public function dumpkwsn()
    {
        $zone = [1, 2, 3, 4];
        foreach ($zone as $val) {
            $dd[] = $this->kawasan->getZKawasan($val)->getResult();
        }
        $dd = array_merge(...$dd);
        foreach ($dd as $row) {
            $kwsn[] = $row->kode_kawasan;
        }
        dd($dd);
    }
}
