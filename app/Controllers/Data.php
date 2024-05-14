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
        $session = session()->getFlashdata('dataAjuan');
        $backSession = session()->getFlashdata('data');
        if ($session != null || $backSession != null) {
            $data = [
                'title' => 'Pengajuan Informasi',
                'jenisKegiatan' => $this->kegiatan->getJenisKegiatan()->getResult(),
            ];

            return view('page/ajuan', $data);
        }
        return redirect()->to('/peta');
    }

    /**
     * Function to handle the submission of form data for a new request.
     * The request data to direct to tambah data permohonan/tambahAjuan() to fill the form
     *
     * @param void
     * @throws void
     * @return redirect
     */
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
        session()->setFlashdata('dataAjuan', $data);
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
        // tidak masuk ke database
        $backInput = [
            'kawasanOverlap' => $this->request->getVar('kawasanOverlap'),
            'ketHasil' => $this->request->getVar('ketHasil'),
        ];
        session()->setFlashdata('data', $backInput);

        if (!$this->validate($this->izin->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

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
                    $uploadFiles = $fileName . "_" . date('YmdHis') . "." . $fileExt;
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
        $user = user_id();
        $dataId = $this->izin->getAllPermohonan($id_perizinan)->getRow();
        if ($dataId->user != $user && !in_groups('Admin') && !in_groups('SuperAdmin')) {
            return redirect()->to('/noaccess')->with('message', 'Anda tidak memiliki hak untuk mengedit data tersebut.');
        }
        $data = [
            'nik' => $this->request->getVar('nik'),
            'nib' => $this->request->getVar('nib'),
            'nama' => $this->request->getVar('nama'),
            'alamat' => $this->request->getVar('alamat'),
            'kontak' => $this->request->getVar('kontak'),
            'id_kegiatan' => $this->request->getVar('kegiatan'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        // dd($data);
        $updatePengajuan =  $this->izin->updatePengajuan($data, $id_perizinan);

        $status = [
            'stat_appv' => '0',
            'date_updated' => date('Y-m-d H:i:s'),
            'dokumen_lampiran' => "",
        ];
        $data = $this->izin->getAllPermohonan($id_perizinan)->getRow();
        if (!empty($data->dokumen_lampiran)) {
            $file = 'dokumen/lampiran-balasan/' . $data->dokumen_lampiran;
            if (file_exists($file)) {
                unlink($file);
            }
        }
        $this->izin->saveStatusAppv($status, $id_perizinan);

        if ($updatePengajuan) {
            session()->setFlashdata('success', 'Data Berhasil diperbarui dan sedang dalam menunggu balasan.');
            if (in_groups('User')) {
                return $this->response->redirect(site_url('/dashboard'));
            } else {
                return $this->response->redirect(site_url('/admin/data/permohonan/lihat'));
            }
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui data.');
            if (in_groups('User')) {
                return $this->response->redirect(site_url('/dashboard'));
            } else {
                return $this->response->redirect(site_url('/admin/data/permohonan/lihat'));
            }
        }
    }
    // DELETE DATA PERMOHONAN
    public function delete_pengajuan($id_perizinan)
    {
        $data = (object) ((array)$this->izin->getAllPermohonan($id_perizinan)->getRow()  + ['uploadFiles' => $this->uploadFiles->getFiles($id_perizinan)->getResult()]);
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
        $this->izin->delete(['id_perizinan' => $id_perizinan]);
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
        $user = user_id();
        $dataId = $this->izin->getAllPermohonan($id_perizinan)->getRow();
        if ($dataId->user != $user && !in_groups('Admin') && !in_groups('SuperAdmin')) {
            session()->setFlashdata('error', 'Permintaan tidak ditemukan');
            return redirect()->to('/admin');
        }
        if (empty($dataId)) {
            session()->setFlashdata('error', 'Permintaan tidak ditemukan');
            return redirect()->to('/admin');
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
            'geojsonFeature' => $this->request->getVar('geojsonFeature'),
        ];
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
            for ($i = 0; $i < count($OverlapProperties); $i++) {
                $getResult[] = $this->kesesuaian->searchKesesuaian($KodeKegiatan, $id_zona[$i], $kode_kawasan[$i], $subZona[$i])->getResult();
            }
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

    public function delete_file()
    {
        $file = $this->request->getPost('file');
        $data = $this->uploadFiles->searchFile($file)->getRow();
        $file = 'dokumen/upload-dokumen/' . $file;
        if (file_exists($file)) {
            unlink($file);
        }
        $this->uploadFiles->delete($data->id_upload);
        $data = [
            'dataFile' => $this->uploadFiles->getFiles($data->id_perizinan)->getResult(),
        ];
        return view('serverSide/showFile', $data);
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

    public function loadDataEksisting()
    {
        $data = $this->izin->getIzin()->getResult();
        return $this->response->setJSON($data);
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
