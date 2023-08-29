<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Validation\Exceptions\ValidationException;
use CodeIgniter\Validation\Validation;
use App\Controllers\BaseController;
use App\Models\ModelSetting;
use App\Models\ModelAdministrasi;
use App\Models\ModelGeojson;
use App\Models\ModelIzin;
use App\Models\ModelJenisKegiatan;
use App\Models\ModelFoto;
use App\Models\ModelUser;
use Faker\Extension\Helper;
use Mpdf\Tag\Br;

class Admin extends BaseController
{
    protected $ModelSetting;
    protected $ModelUser;
    protected $ModelAdministrasi;
    protected $ModelGeojson;
    protected $ModelIzin;
    protected $ModelJenisKegiatan;
    protected $ModelFoto;
    public function __construct()
    {
        helper(['form', 'url']);
        $this->setting = new ModelSetting();
        $this->user = new ModelUser();
        $this->Administrasi = new ModelAdministrasi();
        $this->FGeojson = new ModelGeojson();
        $this->izin = new ModelIzin();
        $this->kegiatan = new ModelJenisKegiatan();
        $this->fotoKafe = new ModelFoto();
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

    public function tes()
    {
        $data = [
            'title' => 'Tes',
            'tampilKafe' => $this->kafe->callKafe()->getResult(),
        ];
        echo '<pre>';
        print_r($data['tampilKafe']);
        die;
        return view('page/tes', $data);
    }

    public function tess($id_kafe)
    {
        $data = [
            'title' => 'Tes',
            'tampilKafe' => $this->kafe->getDump($id_kafe)->getResult(),
        ];
        echo '<pre>';
        print_r($data['tampilKafe']);
        die;
        return view('page/tes', $data);
    }

    public function temp()
    {
        $data = [
            'title' => 'TEMP',
            'tampilKafe' => $this->kafe->getFiveKafe()->getResult(),
        ];
        echo '<pre>';
        print_r($data['tampilKafe']);
        die;

        return view('admin/tempp', $data);
    }




    // SETTING MAP VIEW  ===================================================================================


    public function Setting()
    {
        $data = [
            'title' => 'Setting Map View',
            'tampilData' => $this->setting->tampilData()->getResult(),
            'tampilGeojson' => $this->FGeojson->callGeojson()->getResult(),
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





    // GEOJSONDATA =======================================================================================


    public function geojson()
    {
        $data = [
            'title' => 'DATA FEATURES',
            'tampilData' => $this->setting->tampilData()->getResult(),
            'tampilGeojson' => $this->FGeojson->callGeojson()->getResult(),
        ];

        return view('admin/geojsonData', $data);
    }

    public function editGeojson($id)
    {
        $data = [
            'title' => 'DATA FEATURES',
            'updateGeojson' => $this->FGeojson->callGeojson($id)->getRow(),
        ];

        return view('admin/updateGeojson', $data);
    }

    public function tambahGeojson()
    {
        $data = [
            'title' => 'DATA FEATURES',
            'tampilData' => $this->setting->tampilData()->getResult(),

        ];

        return view('admin/tambahGeojson', $data);
    }

    // insert data
    public function tambah_Geojson()
    {
        // dd($this->request->getVar());
        // ambil file
        $fileGeojson = $this->request->getFile('Fjson');
        //generate random file name
        $extension = $fileGeojson->getExtension();
        $size = $fileGeojson->getSize();
        $randomName = date('YmdHis') . '_' . $size . '.' . $extension;
        $explode = explode('.', $randomName);
        array_pop($explode);
        $randomName = implode('.', $explode);
        if ($extension != 'zip') {
            $randomName = $randomName . ".geojson";
        } else {
            $randomName = $randomName . ".$extension";
        }
        // pindah file to hosting
        $fileGeojson->move('geojson/', $randomName);

        $data = [
            'nama_features'  => $this->request->getVar('Nkec'),
            'features'  => $randomName,
            'warna'  => $this->request->getVar('Kwarna'),
        ];

        $addGeojson = $this->FGeojson->addGeojson($data);

        if ($addGeojson) {
            session()->setFlashdata('success', 'Data Berhasil ditambahkan.');
            return $this->response->redirect(site_url('/admin/features'));
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan data.');
            return $this->response->redirect(site_url('/admin/features'));
        }
    }

    // update data
    public function update_Geojson()
    {
        // dd($this->request->getVar());
        // ambil file name
        $fileGeojson = $this->request->getFile('Fjson');
        // cek file input
        if ($fileGeojson->getError() !== 4) {
            // Jika ada file baru

            // hapus file lama
            $file = $this->request->getVar('jsonLama');
            unlink("geojson/" . $file);
            // ambil file
            $fileGeojson = $this->request->getFile('Fjson');
            //generate random file name
            $extension = $fileGeojson->getExtension();
            $size = $fileGeojson->getSize();
            $randomName = date('YmdHis') . '_' . $size . '.' . $extension;
            $explode = explode('.', $randomName);
            array_pop($explode);
            $randomName = implode('.', $explode);
            if ($extension != 'zip') {
                $randomName = $randomName . ".geojson";
            } else {
                $randomName = $randomName . ".$extension";
            }
            // pindah file to hosting
            $fileGeojson->move('geojson/', $randomName);
        } else {
            //    Jika tidak ada file baru
            $randomName = $this->request->getPost('jsonLama');
        }

        $id = $this->request->getVar('id');
        $data = [
            'nama_features'  => $this->request->getVar('Nkec'),
            'warna'  => $this->request->getVar('Kwarna'),
            'features'  => $randomName,
        ];

        $this->FGeojson->updateGeojson($data, $id);
        if ($this) {
            session()->setFlashdata('success', 'Data Berhasil diperbarui.');
            return $this->response->redirect(site_url('/admin/features'));
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui data.');
            return $this->response->redirect(site_url('/admin/features'));
        }
    }

    // delete data
    public function delete_Geojson($id)
    {

        $data = $this->FGeojson->callGeojson($id)->getRow();
        $file = $data->features;
        unlink("geojson/" . $file);

        $this->FGeojson->delete(['id' => $id]);
        if ($this) {
            session()->setFlashdata('success', 'Data Berhasil dihapus.');
            return $this->response->redirect(site_url('/admin/features'));
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data.');
            return $this->response->redirect(site_url('/admin/features'));
        }
    }




    //  Data Pengajuan Informasi Ruang Laut  ====================================================================================
    public function DataPerizinanDisetujuiSemua()
    {
        $data = [
            'title' => 'Data Pengajuan Informasi',
            'tampilData' => $this->setting->tampilData()->getResult(),
            'tampilIzin' => $this->izin->getIzin()->getResult(),
        ];
        return view('admin/PermohonanData', $data);
    }
    public function DataPerizinanDisetujuiDenganLampiran()
    {
        $tampilIzin = $this->izin->getIzin()->getResult();
        foreach ($tampilIzin as $dat) {
            if ($dat->dokumen_lampiran != null) {
                $datPermohonan[] = $dat;
            }
        }
        $data = [
            'title' => 'Data Pengajuan Informasi',
            'tampilData' => $this->setting->tampilData()->getResult(),
            'tampilIzin' => $datPermohonan,
        ];
        return view('admin/PermohonanData2', $data);
    }
    public function DataPerizinanDisetujuiTanpaLampiran()
    {
        $tampilIzin = $this->izin->getIzin()->getResult();
        foreach ($tampilIzin as $dat) {
            if ($dat->dokumen_lampiran == null) {
                $datPermohonan[] = $dat;
            }
        }
        $data = [
            'title' => 'Data Pengajuan Informasi',
            'tampilData' => $this->setting->tampilData()->getResult(),
            'tampilIzin' => $datPermohonan,
        ];
        return view('admin/PermohonanData3', $data);
    }
    public function DataPerizinanTidakDisetujui()
    {
        $data = [
            'title' => 'Data Pengajuan Informasi',
            'tampilData' => $this->setting->tampilData()->getResult(),
            'tampilIzin' => $this->izin->getIzin(false, 2)->getResult(),
        ];
        // dd($data);
        return view('admin/PermohonanData4', $data);
    }

    public function editPerizinan($id_perizinan)
    {

        $kegiatanId = $this->izin->getAllPermohonan($id_perizinan)->getRow();
        if (empty($kegiatanId)) {
            throw new PageNotFoundException();
        }
        $kegiatanId = $kegiatanId->id_kegiatan;
        $data = [
            'title' => 'Data Pengajuan Informasi Ruang Laut',
            'tampilIzin' => $this->izin->getAllPermohonan($id_perizinan)->getRow(),
            'jenisKegiatan' => $this->kegiatan->getJenisKegiatan()->getResult(),
            'jenisZona' => $this->kegiatan->getZonaByKegiatanAjax($kegiatanId),
        ];

        return view('admin/updateIzin', $data);
    }


    // Delete Data
    public function delete_izin($id_perizinannya)
    {
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

    public function kegiatan()
    {
        $data = [
            'title' => 'Jenis Kegiatan',
            'dataKegiatan' => $this->kegiatan->getJenisKegiatan()->getResult(),
        ];
        // echo '<pre>';
        // print_r($data['dataKegiatan']);
        // die;
        return view('admin/jenisKegiatan', $data);
    }
    public function tambahKegiatan()
    {
        $data = [
            'title' => 'Tambah Kegiatan',
        ];
        return view('admin/tambahKegiatan', $data);
    }
    public function tambah_kegiatan()
    {
        $data = [
            'nama_kegiatan' => $this->request->getVar('nama_kegiatan'),
        ];
    }

    public function zonasi()
    {
        $data = [
            'title' => 'Jenis Zonasi Kegiatan',
            'dataSubZona' => $this->kegiatan->getSubZona()->getResult(),
        ];
        // echo '<pre>';
        // print_r($data['dataSubZona']);
        // die;
        return view('admin/subZonaKegiatan', $data);
    }

    public function statusZonasi()
    {
        $data = [
            'title' => 'Status Zonasi',
            'kegiatan' => $this->kegiatan->getJenisKegiatan()->getResult(),
            'zona' => $this->kegiatan->getSubZona()->getResult(),
            'dataStatusZonasi' => $this->kegiatan->getStatusZonasi()->getResult(),
        ];
        // echo '<pre>';
        // print_r($data['dataStatusZonasi']);
        // die;
        return view('admin/statusZonasi', $data);
    }
    public function editStatusZonasi($id_kegiatan)
    {
        $data = [
            'title' => 'Edit Status Zonasi',
            'jenisKegiatan' => $this->kegiatan->getJenisKegiatan()->getResult(),
            'dataZonasi' => $this->kegiatan->getStatusZonasiGrouped($id_kegiatan)->getResult(),
        ];
        return view('admin/updateStatusZonasi', $data);
    }
    public function updateStatusZonasi($id_kegiatan)
    {
        $zona = $this->request->getPost('zona');
        $status = $this->request->getPost('statusZonasi');
        $dataZonasi = $this->kegiatan->getStatusZonasiGrouped($id_kegiatan)->getResult();
        $i = 0;
        foreach ($dataZonasi as $dataz) {
            $id_sub = $dataz->id_sub;
            $data = [
                'id_kegiatan' => $id_kegiatan,
                'id_sub' => $dataz->id_sub,
                'status_zonasi' => $status[$i],
            ];
            $i++;
            $this->kegiatan->updateZonasiStatus($id_kegiatan, $id_sub, $data);
        }
        if ($this->kegiatan) {
            session()->setFlashdata('success', 'Data Berhasil diperbarui.');
            return redirect()->to('/admin/statusZonasi');
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui data.');
            return redirect()->to('/admin/statusZonasi');
        }
    }


    public function dumpAddStatusZonasi($id_kegiatan)
    {
        $kegiatan = $this->kegiatan->getJenisKegiatan($id_kegiatan)->getResult();
        $kegiatan = $kegiatan[0]->id_kegiatan;
        $zona = $this->kegiatan->getSubZona()->getResult();

        foreach ($zona as $zona) {
            $data = [
                'id_kegiatan' => $kegiatan,
                'id_sub' => $zona->id_sub,
                'status_zonasi' => '3',
            ];
            $this->kegiatan->addZonasiStatus($data);
            // if ($this) {
            //     echo ("Sukses");
            // }
            echo '<pre>';
            print_r($data);
        }
        return redirect()->to('/admin/statusZonasi');
        die;
    }


    // Pending Data
    public function pending()
    {
        $data = [
            'title' => 'Pending List',
            'tampilDataIzin' => $this->izin->callPendingData()->getResult(),
        ];
        // echo '<pre>';
        // print_r($data);
        // die;
        return view('admin/pendingList', $data);
    }

    // periksa data masuk
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
                return $this->response->redirect(site_url('/admin/pending'));
            } else {
                session()->setFlashdata('error', 'Gagal Menyimpan Tindakan.');
                return $this->response->redirect(site_url('/admin/pending'));
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
                    return $this->response->redirect(site_url('/admin/pending'));
                } else {
                    session()->setFlashdata('error', 'Gagal Menyimpan Tindakan.');
                    return $this->response->redirect(site_url('/admin/pending'));
                }
            } else {
                $data = [
                    'stat_appv' => '1',
                    'date_updated' => date('Y-m-d H:i:s'),
                ];
                $this->izin->saveStatusAppv($data, $id_perizinan);
                if ($this) {
                    session()->setFlashdata('success', 'Berhasil Menyimpan Tindakan.');
                    return $this->response->redirect(site_url('/admin/pending'));
                } else {
                    session()->setFlashdata('error', 'Gagal Menyimpan Tindakan.');
                    return $this->response->redirect(site_url('/admin/pending'));
                }
            }
        } else {
            session()->setFlashdata('error', 'Gagal Menyimpan Tindakan.');
            return $this->response->redirect(site_url('/admin/pending'));
        }
    }

    public function getZonaByKegiatan()
    {
        $kegiatanId = $this->request->getPost('kegiatanId');
        $zonaKegiatan = $this->kegiatan->getZonaByKegiatanAjax($kegiatanId);

        return $this->response->setJSON($zonaKegiatan);
    }




    //  SCRAP KAB/KOT, KECAMATAN, KELURAHAN
    // Ajax Remote Wilayah Administrasi
    public function getDataAjaxRemote()
    {
        if ($this->request->isAJAX()) {
            $search = $this->request->getPost('search');
            $results = $this->Administrasi->getDataAjaxRemote($search);
            if (count($results) > 0) {
                foreach ($results as $row) {
                    $selectajax[] = [
                        'id' => $row['id_kelurahan'] . ", " . $row['id_kecamatan'] . ", " . $row['id_kabupaten'] . ", " . $row['id_provinsi'],
                        'text' => $row['nama_kabupaten'] . ", Kecamatan " . $row['nama_kecamatan'] . ", " . $row['nama_kelurahan'],
                    ];
                };
            }
            // var_dump($selectajax);
            return $this->response->setJSON($selectajax);
        }
    }
    public function getkode()
    {
        $kode = $this->request->getPost('kode');
        $results = $this->Administrasi->getKode($kode);
        $response = [
            'status' => 'Succes',
            'id' => $results[0]['id_kelurahan'] . ", " . $results[0]['id_kecamatan'] . ", " . $results[0]['id_kabupaten'] . ", " . $results[0]['id_provinsi'],
            'text' => $results[0]['nama_kabupaten'] . ", Kecamatan " . $results[0]['nama_kecamatan'] . ", " . $results[0]['nama_kelurahan'],
        ];
        return $this->response->setJSON($response);
    }

    // vardump AjaxRemote
    public function wil()
    {
        $results = $this->Administrasi->Remote();
        if (count($results) > 0) {
            foreach ($results as $row) {
                $selectajax[] = [
                    'id' => $row['id_kelurahan'] . ", " . $row['id_kecamatan'] . ", " . $row['id_kabupaten'],
                    'text' => $row['nama_kabupaten'] . ", Kecamatan " . $row['nama_kecamatan'] . ", " . $row['nama_kelurahan'],
                ];
            };
        }
        echo '<pre>';
        print_r($results);
        print_r($selectajax);
    }


    //  SCRAP KAB/KOT, KECAMATAN, KELURAHAN
    public function kabupaten()
    {
        $id_provinsi = $this->request->getPost('id_provinsi');
        $kab = $this->kafe->allKabupaten($id_provinsi);
        echo '<option value="">--Pilih Kab/Kota--</option>';
        foreach ($kab as $key => $value) {
            echo '<option value=' . $value['id_kabupaten'] . '>' . $value['nama_kabupaten'] . '</option>';
        }
    }
    public function kecamatan()
    {
        $id_kabupaten = $this->request->getPost('id_kabupaten');
        $kec = $this->kafe->allKecamatan($id_kabupaten);
        echo '<option value="">--Pilih Kecamatan--</option>';
        foreach ($kec as $key => $value) {
            echo '<option value=' . $value['id_kecamatan'] . '>' . $value['nama_kecamatan'] . '</option>';
        }
    }
    public function kelurahan()
    {
        $id_kecamatan = $this->request->getPost('id_kecamatan');
        $kel = $this->kafe->allKelurahan($id_kecamatan);
        echo '<option value="">--Pilih Desa/Kelurahan--</option>';
        foreach ($kel as $key => $value) {
            echo '<option value=' . $value['id_kelurahan'] . '>' . $value['nama_kelurahan'] . '</option>';
        }
    }
}
