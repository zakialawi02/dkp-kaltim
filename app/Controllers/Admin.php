<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Validation\Exceptions\ValidationException;
use CodeIgniter\Validation\Validation;
use App\Controllers\BaseController;
use App\Models\ModelSetting;
use App\Models\ModelIzin;
use App\Models\ModelUser;
use App\Models\ModelJenisKegiatan;
use App\Models\ModelKesesuaian;
use App\Models\ModelModul;
use App\Models\ModelNamaZona;
use App\Models\ModelUpload;
use App\Models\ModelZonaKawasan;
use Faker\Extension\Helper;
use Mpdf\Tag\Br;

class Admin extends BaseController
{
    protected $ModelSetting;
    protected $ModelModul;
    protected $ModelUser;
    protected $ModelIzin;
    protected $ModelUpload;
    protected $ModelJenisKegiatan;
    protected $ModelNamaZona;
    protected $ModelZonaKawasan;
    protected $ModelKesesuaian;
    public function __construct()
    {
        helper(['form', 'url']);
        $this->setting = new ModelSetting();
        $this->modul = new ModelModul();
        $this->user = new ModelUser();
        $this->izin = new ModelIzin();
        $this->uploadFiles = new ModelUpload();
        $this->kegiatan = new ModelJenisKegiatan();
        $this->zona = new ModelNamaZona();
        $this->kawasan = new ModelZonaKawasan();
        $this->kesesuaian = new ModelKesesuaian();
    }

    public function index()
    {
        $userid = user_id();
        if (in_groups('SuperAdmin') || in_groups('Admin')) {
            $data = [
                'title' => 'Dashboard',
                'userid' => $userid,
                'countAllUser' => $this->user->countAllUser(),
                'userMonth' => $this->user->userMonth()->getResult(),
                'allDataPermohonan' => $this->izin->getAllPermohonan()->getResult(),
            ];
            return view('admin/dashboardAdmin', $data);
        } elseif (in_groups('User')) {
            $data = [
                'title' => 'Dashboard',
                'userid' => $userid,
                'userSubmitPermohonan' => $this->izin->userSubmitIzin($userid)->getResult(),
            ];
            // dd($data['userSubmitPermohonan']);
            return view('admin/dashboardUser', $data);
        } else {
            throw new PageNotFoundException();
        };
    }

    // MODUL
    public function dataModul()
    {
        $data = [
            'title' => 'Data Modul',
            'dataModul' => $this->modul->getModul()->getResult(),
        ];
        return view('admin/dataModul', $data);
    }
    public function tambahModul()
    {
        $data = [
            'title' => 'Tambah Modul',
        ];
        return view('admin/tambahModul', $data);
    }
    public function editModul($id_modul)
    {
        $data = [
            'title' => 'Edit Modul',
            'dataModul' => $this->modul->getModul($id_modul)->getRow(),
        ];
        return view('admin/updateModul', $data);
    }
    public function tambah_modul()
    {
        $file = $this->request->getFile('fileModul');
        if ($file->isValid() && !$file->hasMoved()) {
            $originalName = $file->getName();
            $uploadFiles = date('YmdHis') . "_" . $originalName;
            $dataFile['file_modul'] = $uploadFiles;
            $file->move('dokumen/modul/', $uploadFiles);
        }
        $data = [
            'judul_modul' => $this->request->getVar('judulModul'),
            'deskripsi' => $this->request->getVar('deskripsilModul'),
        ];
        $data = array_merge($data, $dataFile);
        $this->modul->save($data);
        if ($this) {
            session()->setFlashdata('success', 'Data berhasil ditambahkan.');
            return $this->response->redirect(site_url('/admin/dataModul'));
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan data.');
            return $this->response->redirect(site_url('/admin/dataModul'));
        }
    }
    public function update_modul($id_modul)
    {
        $datas = $this->modul->getModul($id_modul)->getRow();
        $file = $this->request->getFile('fileModul');
        if ($file->getError() !== 4) {
            $filed = $datas->file_modul;
            $filed = 'dokumen/modul/' . $filed;
            if (file_exists($filed)) {
                unlink($filed);
            }
            if ($file->isValid() && !$file->hasMoved()) {
                $originalName = $file->getName();
                $uploadFiles = date('YmdHis') . "_" . $originalName;
                $dataFile = $uploadFiles;
                $file->move('dokumen/modul/', $uploadFiles);
            }
        } else {
            $dataFile = $datas->file_modul;
        }
        $data = [
            'id_modul' => $id_modul,
            'judul_modul' => $this->request->getVar('judulModul'),
            'deskripsi' => $this->request->getVar('deskripsilModul'),
            'file_modul' => $dataFile,
        ];
        $this->modul->save($data);
        if ($this) {
            session()->setFlashdata('success', 'Data berhasil diperbarui.');
            return $this->response->redirect(site_url('/admin/dataModul'));
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui data.');
            return $this->response->redirect(site_url('/admin/dataModul'));
        }
    }
    public function delete_modul($id_modul)
    {
        $data = $this->modul->getModul($id_modul)->getRow();
        if (!empty($data->file_modul)) {
            $file = 'dokumen/modul/' . $data->file_modul;
            if (file_exists($file)) {
                unlink($file);
            }
        }
        $this->modul->delete(['id_modul' => $id_modul]);
        if ($this) {
            session()->setFlashdata('success', 'Data berhasil dihapus.');
            return $this->response->redirect(site_url('/admin/dataModul'));
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data.');
            return $this->response->redirect(site_url('/admin/dataModul'));
        }
    }

    // SETTING MAP VIEW
    public function Setting()
    {
        $data = [
            'title' => 'Setting Map View',
            'tampilData' => $this->setting->tampilData()->getResult(),
        ];

        return view('admin/settingMapView', $data);
    }

    public function UpdateSetting()
    {
        // dd($this->request->getVar());
        $data = [
            'id' => 1,
            'coordinat_wilayah' => $this->request->getPost('coordinat_wilayah'),
            'zoom_view' => $this->request->getPost('zoom_view'),
        ];
        $this->setting->updateData($data);
        if ($this) {
            session()->setFlashdata('success', 'Data Berhasil disimpan.');
            return $this->response->redirect(site_url('admin/setting'));
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui data.');
            return $this->response->redirect(site_url('admin/setting'));
        }
    }


    // Data Pengajuan Informasi Ruang Laut
    public function DataDisetujuiSemua()
    {
        $data = [
            'title' => 'Data Pengajuan Informasi',
            'tampilIzin' => $this->izin->getIzin()->getResult(),
        ];
        // dd($data['tampilIzin']);
        return view('admin/PermohonanData', $data);
    }
    public function DataDisetujuiDenganLampiran()
    {
        $tampilIzin = $this->izin->getIzin()->getResult();
        $datPermohonan = [];
        foreach ($tampilIzin as $dat) {
            if ($dat->dokumen_lampiran != null) {
                $datPermohonan[] = $dat;
            }
        }
        $data = [
            'title' => 'Data Pengajuan Informasi',
            'tampilIzin' => $datPermohonan,
        ];
        return view('admin/PermohonanData2', $data);
    }
    public function DataDisetujuiTanpaLampiran()
    {
        $tampilIzin = $this->izin->getIzin()->getResult();
        $datPermohonan = [];
        foreach ($tampilIzin as $dat) {
            if ($dat->dokumen_lampiran == null) {
                $datPermohonan[] = $dat;
            }
        }
        $data = [
            'title' => 'Data Pengajuan Informasi',
            'tampilIzin' => $datPermohonan,
        ];
        return view('admin/PermohonanData3', $data);
    }
    public function DataTidakDisetujui()
    {
        $data = [
            'title' => 'Data Pengajuan Informasi',
            'tampilIzin' => $this->izin->getIzin(false, 2)->getResult(),
        ];
        // dd($data);
        return view('admin/PermohonanData4', $data);
    }


    // Pending Data/data baru masuk
    public function pending()
    {
        $data = [
            'title' => 'Pending List',
            'tampilDataIzin' => $this->izin->callPendingData()->getResult(),
        ];
        return view('admin/pendingList', $data);
    }

    // periksa data/detail data
    public function periksaDataPermohonan($status, $id_perizinan, $nama)
    {
        $statusArray = ['menunggu-jawaban', 'telah-disetujui', 'tidak-disetujui'];
        if (!in_array($status, $statusArray)) {
            throw new PageNotFoundException();
        }
        $permintaanId = $this->izin->getAllPermohonan($id_perizinan)->getRow();
        if (empty($permintaanId) && empty($nama)) {
            throw new PageNotFoundException();
        }
        if (empty($permintaanId->nama)) {
            throw new PageNotFoundException();
            if ($permintaanId->nama != $nama) {
                throw new PageNotFoundException();
            }
        }
        $uploadFiles = $this->uploadFiles->getFiles($id_perizinan)->getResult();
        $data = [
            'title' => 'Detail Data Pengajuan Informasi',
            'tampilData' => $this->setting->tampilData()->getResult(),
            'tampilZona' => $this->zona->getZona()->getResult(),
            'tampilDataIzin' => (object) ((array) $permintaanId + ['uploadFiles' => $uploadFiles]),
        ];
        // dd($data['tampilDataIzin']);
        return view('admin/detailDataPermohonan', $data);
    }


    public function kirimTindakan($id_perizinan)
    {
        $stat_appv = $this->request->getPost('flexRadioDefault');
        if ($stat_appv == 2) {
            $data = [
                'stat_appv' => '2',
                'date_updated' => date('Y-m-d H:i:s'),
            ];
            $this->izin->saveStatusAppv($data, $id_perizinan);
            if ($this) {
                session()->setFlashdata('success', 'Berhasil Menyimpan Tindakan.');
                return $this->response->redirect(site_url('/admin/data/permohonan/masuk'));
            } else {
                session()->setFlashdata('error', 'Gagal Menyimpan Tindakan.');
                return $this->response->redirect(site_url('/admin/data/permohonan/masuk'));
            }
        } elseif ($stat_appv == 1) {
            $infoData = $this->izin->callPendingData($id_perizinan)->getRow();
            $nik = $infoData->nik;
            // ambil file
            $fileLampiran = $this->request->getFile('lampiranFile');
            if ($fileLampiran->isValid() && !$fileLampiran->hasMoved()) {
                //generate random file name
                $extension = $fileLampiran->getExtension();
                $newName = date('YmdHis') . '_' . $nik . '.' . $extension;
                // pindah file to hosting
                $fileLampiran->move('dokumen/lampiran-balasan/', $newName);

                $data = [
                    'stat_appv' => '1',
                    'dokumen_lampiran' => $newName,
                    'date_updated' => date('Y-m-d H:i:s'),
                ];
                $this->izin->saveStatusAppv($data, $id_perizinan);
                if ($this) {
                    session()->setFlashdata('success', 'Berhasil Menyimpan Tindakan.');
                    return $this->response->redirect(site_url('/admin/data/permohonan/masuk'));
                } else {
                    session()->setFlashdata('error', 'Gagal Menyimpan Tindakan.');
                    return $this->response->redirect(site_url('/admin/data/permohonan/masuk'));
                }
            } else {
                $data = [
                    'stat_appv' => '1',
                    'date_updated' => date('Y-m-d H:i:s'),
                ];
                $this->izin->saveStatusAppv($data, $id_perizinan);
                if ($this) {
                    session()->setFlashdata('success', 'Berhasil Menyimpan Tindakan.');
                    return $this->response->redirect(site_url('/admin/data/permohonan/masuk'));
                } else {
                    session()->setFlashdata('error', 'Gagal Menyimpan Tindakan.');
                    return $this->response->redirect(site_url('/admin/data/permohonan/masuk'));
                }
            }
        } else if (empty($stat_appv)) {
            $infoData = $this->izin->getAllPermohonan($id_perizinan)->getRow();
            $nik = $infoData->nik;
            // ambil file
            $fileLampiran = $this->request->getFile('lampiranFile');
            if ($fileLampiran->isValid() && !$fileLampiran->hasMoved()) {
                //generate random file name
                $extension = $fileLampiran->getExtension();
                $newName = date('YmdHis') . '_' . $nik . '.' . $extension;
                // pindah file to hosting
                $fileLampiran->move('dokumen/lampiran-balasan/', $newName);

                $data = [
                    'stat_appv' => '1',
                    'dokumen_lampiran' => $newName,
                    'date_updated' => date('Y-m-d H:i:s'),
                ];
                $this->izin->saveStatusAppv($data, $id_perizinan);
                if ($this) {
                    session()->setFlashdata('success', 'Berhasil Mengupload Dokumen.');
                    return $this->response->redirect(site_url('/admin/data/permohonan/disetujui/'));
                } else {
                    session()->setFlashdata('error', 'Gagal Mengupload Dokumen.');
                    return $this->response->redirect(site_url('/admin/data/permohonan/disetujui/'));
                }
            } else {
                $data = [
                    'stat_appv' => '1',
                    'date_updated' => date('Y-m-d H:i:s'),
                ];
                $this->izin->saveStatusAppv($data, $id_perizinan);
                if ($this) {
                    session()->setFlashdata('success', 'Berhasil Menyimpan Tindakan.');
                    return $this->response->redirect(site_url('/admin/data/permohonan/masuk'));
                } else {
                    session()->setFlashdata('error', 'Gagal Menyimpan Tindakan.');
                    return $this->response->redirect(site_url('/admin/data/permohonan/masuk'));
                }
            }
        } else {
            session()->setFlashdata('error', 'Gagal Menyimpan Tindakan.');
            return $this->response->redirect(site_url('/admin/data/permohonan/masuk'));
        }
    }


    public function kegiatan()
    {
        $data = [
            'title' => 'Data Kegiatan',
            'dataKegiatan' => $this->kegiatan->getJenisKegiatan()->getResult(),
        ];
        return view('admin/k_jenisKegiatan', $data);
    }
    public function loadKegiatan()
    {
        $data = [
            'dataKegiatan' => $this->kegiatan->getJenisKegiatan()->getResult(),
        ];
        return view('serverSide/tblKegiatan', $data);
    }
    public function dataKegiatan($id_kegiatan)
    {
        $response = $this->kegiatan->getJenisKegiatan($id_kegiatan)->getResult();
        return $this->response->setJSON($response);
    }
    public function tambahKegiatan()
    {
        $data = [
            'nama_kegiatan' => $this->request->getPost('tambahKegiatan'),
            'kode_kegiatan' => $this->request->getPost('tambahKKegiatan'),
        ];
        $cek = $this->kegiatan->cekDuplikat($data['kode_kegiatan'])->getRow();
        if (!empty($cek)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal! Indikasi Duplikasi Data']);
        }
        $this->kegiatan->save($data);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil ditambahkan.']);
    }
    public function updatekegiatan($id_kegiatan)
    {
        $oldCode = $this->request->getVar('oldCode');
        $data = [
            'id_kegiatan' => $id_kegiatan,
            'nama_kegiatan' => $this->request->getPost('editKegiatan'),
            'kode_kegiatan' => $this->request->getPost('editKKegiatan'),
        ];
        if ($oldCode != $data['kode_kegiatan']) {
            $cek = $this->kegiatan->cekDuplikat($data['kode_kegiatan'])->getRow();
            if (!empty($cek)) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal! Indikasi Duplikasi Data']);
            }
        }
        $this->kegiatan->save($data);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil diperbarui.']);
    }
    public function delete_kegiatan($id_kegiatan)
    {
        $this->kegiatan->delete(['id_kegiatan' => $id_kegiatan]);
        return $this->response->setJSON('success');
    }


    public function zona()
    {
        $data = [
            'title' => 'Data Zona',
            'dataZona' => $this->zona->getZona()->getResult(),
        ];
        return view('admin/k_jenisZona', $data);
    }


    public function kawasan()
    {
        $id_zona = $this->request->getGet('zona');
        $data = [
            'title' => 'Data Kawasan',
            'zona' => $id_zona,
            'dataZona' => $this->zona->getZona()->getResult(),
        ];
        if (!empty($id_zona)) {
            $data['dataKawasan'] = $this->kawasan->getZKawasan($id_zona)->getResult();
        } else {
            $data['dataKawasan'] = $this->kawasan->getZKawasan()->getResult();
        }
        return view('admin/k_kawasan', $data);
    }
    public function kawasanByZona($id_zona)
    {
        $data = [
            'dataKawasan' => $this->kawasan->getZKawasan($id_zona)->getResult(),
        ];
        return view('serverSide/tblKawasanByZona', $data);
    }
    public function dataKawasan($id_znkwsn)
    {
        $response = $this->kawasan->getKawasan($id_znkwsn)->getResult();
        return $this->response->setJSON($response);
    }
    public function tambahKawasan()
    {
        $data = [
            'id_zona' => $this->request->getPost('tambahZona'),
            'kode_kawasan' => $this->request->getPost('tambahKawasan'),
        ];
        $cek = $this->kawasan->cekDuplikat($data['id_zona'], $data['kode_kawasan'])->getRow();
        if (!empty($cek)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal! Data sudah ada dalam database.']);
        }
        $this->kawasan->save($data);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil ditambahkan.']);
    }
    public function updateKawsan($id_znkwsn)
    {
        $data = [
            'id_znkwsn' => $id_znkwsn,
            'id_zona' => $this->request->getPost('editZona'),
            'kode_kawasan' => $this->request->getPost('editKawasan'),
        ];
        $cek = $this->kawasan->cekDuplikat($data['id_zona'], $data['kode_kawasan'])->getRow();
        if (!empty($cek)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal! Data sudah ada dalam database.']);
        }
        $this->kawasan->save($data);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil diperbarui.']);
    }
    public function delete_kawasan($id_znkwsn)
    {
        $this->kawasan->delete(['id_znkwsn' => $id_znkwsn]);
        $data = [
            'dataKawasan' => $this->kawasan->getZKawasan()->getResult(),
        ];
        return $this->response->setJSON('success');
    }


    public function kesesuaian()
    {
        $id_zona = $this->request->getGet('zona');
        $data = [
            'title' => 'Data Kesesuaian',
            'zona' => $id_zona,
            'dataZona' => $this->zona->getZona()->getResult(),
            'dataKegiatan' => $this->kegiatan->getJenisKegiatan()->getResult(),
        ];
        if (!empty($id_zona)) {
            $data['dataKesesuaian'] = $this->kesesuaian->getKesesuaianByZona($id_zona)->getResult();
        } else {
            $data['dataKesesuaian'] = $this->kesesuaian->getKesesuaianByZona()->getResult();
        }
        return view('admin/k_kesesuaian', $data);
    }
    public function kesesuaianByZona()
    {
        $id_zona = $this->request->getGet('zona');
        if (!empty($id_zona)) {
            $data = [
                'dataKesesuaian' => $this->kesesuaian->getKesesuaianByZona($id_zona)->getResult(), 'zona' => $id_zona,
            ];
        } else {
            $data = [
                'dataKesesuaian' => $this->kesesuaian->getKesesuaianByZona()->getResult(), 'zona' => $id_zona,
            ];
        }
        return view('serverSide/tblKesesuaianByZona', $data);
    }
    public function dataKesesuaian($id_kesesuaian)
    {
        $response = $this->kesesuaian->getKesesuaian($id_kesesuaian)->getResult();
        return $this->response->setJSON($response);
    }
    public function tambahAturanKesesuaian()
    {
        $data = [
            'id_zona' => $this->request->getPost('tambahZona'),
            'kode_kegiatan' => $this->request->getPost('tambahKegiatan'),
            'sub_zona' => $this->request->getPost('tambahSubZona'),
            'status' => $this->request->getPost('tambahStatus'),
        ];
        $this->kesesuaian->save($data);
        return $this->response->setJSON('success');
    }
    public function updateAturanKesesuaian($id_kesesuaian)
    {
        $data = [
            'id_kesesuaian' => $id_kesesuaian,
            'id_zona' => $this->request->getPost('editZona'),
            'kode_kegiatan' => $this->request->getPost('editKegiatan'),
            'sub_zona' => $this->request->getPost('editSubZona'),
            'status' => $this->request->getPost('editStatus'),
        ];
        $this->kesesuaian->save($data);
        return $this->response->setJSON('success');
    }
    public function delete_kesesuaian($id_kesesuaian)
    {
        $this->kesesuaian->delete(['id_kesesuaian' => $id_kesesuaian]);
        $data = [
            'dataKesesuaian' => $this->kesesuaian->getKesesuaian()->getResult(),
        ];
        return $this->response->setJSON('success');
    }
}
