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
use App\Models\ModelModul;
use App\Models\ModelNamaZona;
use App\Models\ModelUpload;
use App\Models\ModelZonaKawasan;
use Faker\Extension\Helper;

class Data extends BaseController
{
    protected $ModelSetting;
    protected $ModelModul;
    protected $ModelIzin;
    protected $ModelUpload;
    protected $ModelJenisKegiatan;
    protected $ModelKesesuaian;
    protected $ModelNamaZona;
    protected $ModelZonaKawasan;
    public function __construct()
    {
        helper(['form', 'url']);
        $this->setting = new ModelSetting();
        $this->modul = new ModelModul();
        $this->izin = new ModelIzin();
        $this->uploadFiles = new ModelUpload();
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
            'dataModul' => $this->modul->getModul()->getResult(),
        ];
        // dd($data['dataModul']);
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
            'hasilStatus' => $this->request->getPost('hasilStatus'),
        ];
        // dd($data);
        session()->setFlashdata('data', $data);
        // echo '<pre>';
        // print_r($data);
        // die;
        return redirect()->to('/data/pengajuan');
    }

    // TAMBAH DATA PERMOHONAN
    public function tambahAjuan()
    {
        // dd($this->request->getVar());
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

        $files = $this->request->getFiles();
        if (!empty($files['filepond']) && count(array_filter($files['filepond'], function ($file) {
            return $file->isValid() && !$file->hasMoved();
        }))) {
            foreach ($files['filepond'] as $key => $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $originalName = $file->getClientName();
                    $pathInfo = pathinfo($originalName);
                    $fileName = $pathInfo['filename'];
                    $fileExt = $file->guessExtension();
                    $uploadFiles = $fileName . "_" . uniqid() . "." . $fileExt;
                    $dataF = [
                        'id_perizinan' => $insert_id,
                        'file' => $uploadFiles,
                    ];
                    $this->uploadFiles->save($dataF);
                    $file->move('dokumen/upload-dokumen/', $uploadFiles);
                }
            }
        }

        if ($addPengajuan && $addStatus) {
            session()->setFlashdata('success', 'Data Berhasil ditambahkan.');
            return $this->response->redirect(site_url('/dashboard'));
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan data.');
            return $this->response->redirect(site_url('/peta'));
        }
    }
    // UPDATE DATA PERMOHONAN
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
    // DELETE DATA PERMOHONAN
    public function delete_pengajuan($id_perizinannya)
    {
        $data = (object) ((array)$this->izin->getAllPermohonan($id_perizinannya)->getRow()  + ['uploadFiles' => $this->uploadFiles->getFiles($id_perizinannya)->getResult()]);
        if (!empty($data->uploadFiles)) {
            foreach ($data->uploadFiles as $file) {
                $file = 'dokumen/upload-dokumen/' . $file->uploadFiles;
                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }
        if (!empty($data->dokumen_lampiran)) {
            $file = 'dokumen/lampiran-balasan/' . $data->dokumen_lampiran;
            if (file_exists($file)) {
                unlink($file);
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
    // HALAMAN EDIT PERMOHONAN
    public function editPengajuan($id_perizinan)
    {
        $dataId = $this->izin->getAllPermohonan($id_perizinan)->getRow();
        if (empty($dataId)) {
            throw new PageNotFoundException();
        }
        $data = [
            'title' => 'Data Pengajuan',
            'tampilData' => $this->setting->tampilData()->getResult(),
            'tampilIzin' => (object) ((array)$this->izin->getAllPermohonan($id_perizinan)->getRow()  + ['uploadFiles' => $this->uploadFiles->getFiles($id_perizinan)->getResult(), 'files' => $this->loadDoc($id_perizinan)]),
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
            'objectID' => $this->request->getVar('id'),
            'kawasan' => $this->request->getVar('kawasan'),
            'objectName' => $this->request->getVar('name'),
            'kode' => $this->request->getVar('kode'),
            'orde' => $this->request->getVar('orde'),
            'remark' => $this->request->getVar('remark'),
            'geojsonFeature' => $this->request->getVar('geojsonFeature'),
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
        $getOverlapProperties = $this->request->getVar('getOverlapProperties');
        $valKegiatan = $this->request->getVar('valKegiatan');
        $fecthKegiatan = $this->kegiatan->getJenisKegiatan($valKegiatan)->getResult();
        $KodeKegiatan = $fecthKegiatan[0]->kode_kegiatan;

        if (!empty($getOverlapProperties[0])) {
            // Mapping nilai yang perlu diganti
            $replacementName = [
                "Zona Inti" => "Inti",
                "Zona Pemanfaatan Terbatas" => "ZPT",
                "Zona Lainnya" => "Lainnya",
                "KKM" => "Lainnya",
                "KKP3K" => "Lainnya",
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



    public function uploadDoc()
    {
        $files = $this->request->getFiles();
        if (!empty($files['filepond']) && count(array_filter($files['filepond'], function ($file) {
            return $file->isValid() && !$file->hasMoved();
        }))) {
            foreach ($files['filepond'] as $key => $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $originalName = $file->getClientName();
                    $pathInfo = pathinfo($originalName);
                    $fileName = $pathInfo['filename'];
                    $fileExt = $file->guessExtension();
                    $uploadFiles = $fileName . "_" . uniqid() . "." . $fileExt;
                    $dataF = [
                        'id_perizinan' => $this->request->getGet('dokumenUp'),
                        'file' => $uploadFiles,
                    ];
                    $this->uploadFiles->save($dataF);
                    $insert_id = $this->db->insertID();
                    $file->move('dokumen/upload-dokumen/', $uploadFiles);
                }
            }
        }
        return $this->response->setJSON(['success' => true, 'file' => $insert_id . ' ' . $uploadFiles,]);
    }
    public function revertDoc()
    {
        $fileName = $this->request->getVar('fileName');
        if (preg_match('/^(\d+)\s(.+)/', $fileName, $matches)) {
            $fileId = $matches[1];
            $fileName = $matches[2];
        } else {
            return $this->response->setJSON(['error' => true]);
        }
        $file = 'dokumen/upload-dokumen/' . $fileName;
        if (file_exists($file)) {
            unlink($file);
        }
        $this->uploadFiles->delete($fileId);
        return $this->response->setJSON(['success' => true]);
    }
    private function loadDoc($id_perizinan)
    {
        $fileInfo = $this->uploadFiles->getFiles($id_perizinan)->getResult();
        $fileNames = [];
        foreach ($fileInfo as $info) {
            $fileNames[] = $info->uploadFiles;
        }
        $files = [];
        foreach ($fileNames as $fileName) {
            $filePath = 'dokumen/upload-dokumen/' . $fileName;
            $files[] = [
                'source' => $fileName,
                'options' => [
                    'type' => 'local',
                ],
            ];
        }
        // $result = $this->response->setJSON(['files' => $files]);
        return $files;
    }

    public function ss()
    {
        $id_kesesuaian = "111";
        $kode_kawasan = "KKP3K-02";
        $dd = $this->kesesuaian->getKesesuaian($id_kesesuaian, $kode_kawasan)->getResultArray();
        dd($dd);
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


    public function dumpp()
    {
        $id_zona = "15";
        $kode_kawasan = "KPU-TB-77";
        $dd = $this->kawasan->cekDuplikat($id_zona, $kode_kawasan)->getResult();
        dd($dd);
    }
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

    // public function sendEmails()
    // {
    //     $email = \Config\Services::email();

    //     $to = 'treyl7358@student.vvc.edu';
    //     $subject = 'Subject of the Email';
    //     $message = 'Hello, this is the email message content.';

    //     $email->setTo($to);
    //     $email->setSubject($subject);
    //     $email->setMessage($message);

    //     if ($email->send()) {
    //         echo 'Email successfully sent';
    //     } else {
    //         echo 'Email sending failed: ' . $email->printDebugger(['headers']);
    //     }
    // }
}
