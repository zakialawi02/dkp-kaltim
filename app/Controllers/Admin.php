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
use App\Models\ModelNamaZona;
use App\Models\ModelZonaKawasan;
use Faker\Extension\Helper;
use Mpdf\Tag\Br;

class Admin extends BaseController
{
    protected $ModelSetting;
    protected $ModelUser;
    protected $ModelIzin;
    protected $ModelJenisKegiatan;
    protected $ModelNamaZona;
    protected $ModelZonaKawasan;
    protected $ModelKesesuaian;
    public function __construct()
    {
        helper(['form', 'url']);
        $this->setting = new ModelSetting();
        $this->user = new ModelUser();
        $this->izin = new ModelIzin();
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
            return view('admin/dashboardUser', $data);
        } else {
            throw new PageNotFoundException();
        };
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
        $data = [
            'title' => 'Detail Data Pengajuan Informasi',
            'tampilData' => $this->setting->tampilData()->getResult(),
            'tampilZona' => $this->zona->getZona()->getResult(),
            'tampilDataIzin' => $permintaanId,
        ];

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
        $data = [
            'title' => 'Data Kawasan',
            'dataZona' => $this->zona->getZona()->getResult(),
            'dataKawasan' => $this->kawasan->getKawasan()->getResult(),
        ];
        return view('admin/k_kawasan', $data);
    }
    public function kesesuaian()
    {
        $data = [
            'title' => 'Data Kesesuaian',
            'dataZona' => $this->zona->getZona()->getResult(),
            'dataKesesuaian' => $this->kesesuaian->getKesesuaian()->getResult(),
        ];
        // dd($data['dataKesesuaian']);
        return view('admin/k_kesesuaian', $data);
    }
    public function kawasanByZona($id_zona)
    {
        $data = [
            'dataKawasan' => $this->kawasan->getZKawasan($id_zona)->getResult(),
        ];
        return view('serverSide/tblKawasanByZona', $data);
    }
}
