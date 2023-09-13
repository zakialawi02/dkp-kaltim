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

    public function updateAjuan($id_perizinan)
    {
        // dd($this->request->getVar());
        $data = [
            'nik' => $this->request->getVar('nik'),
            'nib' => $this->request->getVar('nib'),
            'nama' => $this->request->getVar('nama'),
            'alamat' => $this->request->getVar('alamat'),
            'kontak' => $this->request->getVar('kontak'),
            'id_kegiatan' => $this->request->getVar('kegiatan'),
            // 'uploadFiles' => $uploadFiles,
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        // dd($data);
        $updatePengajuan =  $this->izin->updatePengajuan($data, $id_perizinan);

        if (in_groups('User')) {
            $status = [
                'stat_appv' => '0',
                'date_updated' => date('Y-m-d H:i:s'),
            ];
            $this->izin->saveStatusAppv($status, $id_perizinan);
        }

        if ($updatePengajuan) {
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
            'tampilZona' => $this->zona->getZona()->getResult(),
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
        $kkp3k = ['KKP3K-01', 'KKP3K-02', 'KKP3K-02', 'KKP3K-03', 'KKP3K-04', 'KKP3K-05', 'KKP3K-06', 'KKP3K-07', 'KKP3K-08', 'KKP3K-09', 'KKP3K-10', 'KKP3K-11', 'KKP3K-12', 'KKP3K-13', 'KKP3K-14', 'KKP3K-15', 'KKP3K-16', 'KKP3K-17', 'KKP3K-18', 'KKP3K-20', 'KKP3K-21', 'KKP3K-22', 'KKP3K-23', 'KKP3K-24', 'KKP3K-25', 'KKP3K-27', 'KKP3K-30', 'TWAL-01', 'SML-01'];
        $kkp3kzi = ['KK-P3K-ZI-01', 'KK-P3K-ZI-02', 'KK-P3K-ZI-03', 'KK-P3K-ZI-04', 'KK-P3K-ZI-05', 'KK-P3K-ZI-06'];
        $kkp3kzl = ['KK-P3K-ZL-01', 'KK-P3K-ZL-02', 'KK-P3K-ZL-03', 'KK-P3K-ZL-04', 'KK-P3K-ZL-05', 'KK-P3K-ZL-06'];
        $kkp3kzpt = ['KK-P3K-ZPT-01', 'KK-P3K-ZPT-02', 'KK-P3K-ZPT-03', 'KK-P3K-ZPT-04', 'KK-P3K-ZPT-05', 'KK-P3K-ZPT-06', 'KK-P3K-ZPT-07', 'KK-P3K-ZPT-08', 'KK-P3K-ZPT-09', 'KK-P3K-ZPT-10', 'KK-P3K-ZPT-11', 'KK-P3K-ZPT-12', 'KK-P3K-ZPT-13', 'KK-P3K-ZPT-14', 'KK-P3K-ZPT-15', 'KK-P3K-ZPT-16', 'KK-P3K-ZPT-17', 'KK-P3K-ZPT-18', 'KK-P3K-ZPT-19', 'KK-P3K-ZPT-20', 'KK-P3K-ZPT-21'];
        $kkp = ['KKP-01', 'KKP-02', 'KKP-06', 'KKP-03', 'KKP-04', 'KKP-05'];
        $kkm = ['KKM-01', 'KKM-02'];
        $result = [];
        $getOverlapProperties = $this->request->getPost('getOverlapProperties');
        $valKegiatan = $this->request->getPost('valKegiatan');
        $fecthKegiatan = $this->kegiatan->getJenisKegiatan($valKegiatan)->getResult();
        $KodeKegiatan = $fecthKegiatan[0]->kode_kegiatan;

        if (!empty($getOverlapProperties[0])) {
            // Mapping nilai yang perlu diganti
            $replacementName = [
                "Zona Inti" => "Inti",
                "Zona Pemanfaatan Terbatas" => "ZPT",
                "Zona Lainnya" => "Lainnya",
                "KKM" => "Inti",
                "KKP3K" => "Inti",
            ];
            // Loop untuk mengganti nilai berdasarkan list
            foreach ($getOverlapProperties as $item) {
                $oldValue = $item['subZona'];
                $newValue = $replacementName[$oldValue] ?? null;
                $item['subZona'] = $newValue;
                $OverlapProperties[] = $item;
            }
            // cek ada kawasan konservasi tidak
            foreach ($OverlapProperties as $item) {
                if ($item['kawasan'] == "Kawasan Konservasi") {
                    $isKonservasi[] = $item;
                } else {
                    $isntKonservasi[] = $item;
                }
            }
            $namaZona = array_map(function ($feature) {
                return $feature['namaZona'];
            }, $OverlapProperties);
            $subZona = array_map(function ($feature) {
                return $feature['subZona'];
            }, $OverlapProperties);
            $id_zona = array_map(function ($feature) {
                return $this->zona->searchZona($feature)->getResult()[0]->id_zona;
            }, $namaZona);
            $kode_kawasan = array_map(function ($feature) {
                return $feature['kodeKawasan'];
            }, $OverlapProperties);
            // filter data/cek data
            // if (!empty($isKonservasi)) {
            for ($i = 0; $i < count($OverlapProperties); $i++) {
                $getResult[] = $this->kesesuaian->searchKesesuaian($KodeKegiatan, $id_zona[$i], $kode_kawasan[$i], $subZona[$i])->getResult();
            }
            // } else {
            //     for ($i = 0; $i < count($OverlapProperties); $i++) {
            //         $getResult[] = $this->kesesuaian->searchKesesuaian($KodeKegiatan, $id_zona[$i], $kode_kawasan[$i])->getResult();
            //     }
            // }
            foreach ($getResult as $subArray) {
                foreach ($subArray as $item) {
                    $result[] =  $item;
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
        // print_r($OverlapProperties);
        // print_r($response);
        // die;
        return $this->response->setJSON($response);
    }

    private function selectKegiatan($kode_kegiatan)
    {
        $result = $this->kesesuaian->selectedByKegiatan($kode_kegiatan)->getResult();
        return $result;
    }


    public function dump()
    {
        $kode_kegiatan = "K48";
        // $id_zona = ["2"];
        // $kode_kawasan = ["KK-P3K-ZL-03"];
        // $sub = ["Inti"];
        $id_zona = ["6"];
        $kode_kawasan = ["KPU-PL-15"];
        $sub = [];

        $dd = $this->kesesuaian->searchKesesuaian($kode_kegiatan, $id_zona, $kode_kawasan, $sub)->getResult();
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
