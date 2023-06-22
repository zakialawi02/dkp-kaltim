<?php

namespace App\Controllers;

use CodeIgniter\Validation\Exceptions\ValidationException;
use CodeIgniter\Validation\Validation;
use App\Controllers\BaseController;
use App\Models\ModelSetting;
use App\Models\ModelAdministrasi;
use App\Models\ModelGeojson;
use App\Models\ModelIzin;
use App\Models\ModelFoto;
use App\Models\ModelUser;
use Faker\Extension\Helper;

class Admin extends BaseController
{
    protected $ModelSetting;
    protected $ModelUser;
    protected $ModelAdministrasi;
    protected $ModelGeojson;
    protected $ModelIzin;
    protected $ModelFoto;
    public function __construct()
    {
        helper(['form', 'url']);
        $this->setting = new ModelSetting();
        $this->user = new ModelUser();
        $this->Administrasi = new ModelAdministrasi();
        $this->FGeojson = new ModelGeojson();
        $this->izin = new ModelIzin();
        $this->fotoKafe = new ModelFoto();
    }

    public function index()
    {
        $userid = user_id();
        $data = [
            'title' => 'Dashboard',
            'userid' => $userid,
            'countAllPerizinan' => $this->izin->getIzinFive()->getNumRows(),
            'countAllPending' => $this->izin->callPendingData()->getNumRows(),
            'countAllUser' => $this->user->countAllUser(),
            'userMonth' => $this->user->userMonth()->getResult(),
            'tampilIzin' => $this->izin->getIzinFive()->getResult(),
            'userSubmitIzin' => $this->izin->userSubmitIzin($userid)->getResult(),
        ];
        // echo '<pre>';
        // print_r($data);
        // die;
        return view('admin/dashboard', $data);
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
            'nama_web' => $this->request->getPost('nama_web'),
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




    //  KV  ====================================================================================
    public function DataPerizinan()
    {
        $data = [
            'title' => 'DATA PERIZINAN',
            'tampilData' => $this->setting->tampilData()->getResult(),
            'tampilGeojson' => $this->FGeojson->callGeojson()->getResult(),
            'updateGeojson' => $this->FGeojson->callGeojson()->getRow(),
            'tampilIzin' => $this->izin->getIzin()->getResult(),
        ];
        // echo '<pre>';
        // print_r($data['tampilKafe']);
        // die;
        return view('admin/PerizinanData', $data);
    }

    public function tambahKafe()
    {
        $data = [
            'title' => 'DATA KAFE',
            'tampilData' => $this->setting->tampilData()->getResult(),
            'tampilGeojson' => $this->FGeojson->callGeojson()->getResult(),
            'provinsi' => $this->kafe->allProvinsi(),
            'validation' => \Config\Services::validation()
        ];
        return view('admin/tambahKafe', $data);
    }

    public function editKafe($id_kafe)
    {
        $data = [
            'title' => 'DATA KAFE',
            'tampilData' => $this->setting->tampilData()->getResult(), //ambil settingan mapView
            'tampilGeojson' => $this->FGeojson->callGeojson()->getResult(), //ambil data geojson
            'tampilKafe' => $this->kafe->callKafe($id_kafe)->getRow(),
            'getFoto' => $this->fotoKafe->getFoto($id_kafe)->getResult(),
            'provinsi' => $this->kafe->allProvinsi(),
        ];

        return view('admin/updateKafe', $data);
    }

    // insert data
    public function tambah_Kafe()
    {
        // dd($this->request->getVar());
        $wilayah  = $this->request->getVar('wilayah');
        $wilayah = explode(',', $wilayah);
        $id_kelurahan = $wilayah[0];
        $id_kecamatan = $wilayah[1];
        $id_kabupaten = $wilayah[2];
        $id_provinsi = $wilayah[3];

        $user = user_id();
        $data = [
            'nama_kafe' => $this->request->getVar('nama_kafe'),
            'alamat_kafe'  => $this->request->getVar('alamat_kafe'),
            'longitude'  => $this->request->getVar('longitude'),
            'latitude'  => $this->request->getVar('latitude'),
            'instagram_kafe'  => $this->request->getVar('instagram_kafe'),
            'id_provinsi'  => $id_provinsi,
            'id_kabupaten'  => $id_kabupaten,
            'id_kecamatan'  => $id_kecamatan,
            'id_kelurahan'  => $id_kelurahan,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $addKafe = $this->kafe->addKafe($data);
        $insert_id = $this->db->insertID();
        $status = [
            'id_kafe' => $insert_id,
            'stat_appv' => $this->request->getVar('stat_appv'),
            'user' => $user,
        ];
        $addStatus = $this->kafe->addStatus($status);

        $files = $this->request->getFiles();
        if (isset($files['foto_kafe']) && !empty($files['foto_kafe'])) {
            foreach ($files['foto_kafe'] as $key => $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $imageName = $img->getRandomName();
                    // Image manipulation(compress)
                    $image = \Config\Services::image()
                        ->withFile($img)
                        ->resize(1200, 900, true, 'height')
                        ->save(FCPATH . '/img/kafe/' . $imageName);

                    $dataF = [
                        'id_kafe' => $insert_id,
                        'nama_file_foto' => $imageName,
                    ];
                    $this->fotoKafe->addFoto($dataF);
                }
            }
        }


        $opens = $this->request->getVar('open-time[]');
        $open = [];
        foreach ($opens as $item) {
            if ($item == '') {
                $open[] = null;
            } else {
                $open[] = $item;
            }
        }
        // print_r($open);
        $closes = $this->request->getVar('close-time[]');
        $close = [];
        foreach ($closes as $item) {
            if ($item == '') {
                $close[] = null;
            } else {
                $close[] = $item;
            }
        }
        // print_r($close);
        $day = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        // Mengambil id kafe
        $id = [];
        foreach ($open as $key) {
            $id[] = $insert_id;
        }
        // print_r($id);
        $datas = [
            'kafe_id' => $id,
            'hari' => $day,
            'open_time' => $open,
            'close_time' => $close
        ];
        $data = [];
        $i = 0;
        foreach ($datas as $key => $val) {
            $i = 0;
            foreach ($val as $k => $v) {
                $data[$i][$key] = $v;
                $i++;
            }
        }
        $addTime = $this->kafe->addTime($data);
        if ($addKafe && $addTime) {
            session()->setFlashdata('success', 'Data Berhasil Ditambahkan.');
            return $this->response->redirect(site_url('/admin/data/data-perizinan'));
        } else {
            session()->setFlashdata('error', 'Data gagal ditambahkan.');
            return $this->response->redirect(site_url('/admin/data/data-perizinan'));
        }
    }

    // update data
    public function update_Kafe()
    {
        // dd($this->request->getVar());
        $wilayahLama  = $this->request->getVar('wilayahLama');
        $wilayah  = $this->request->getVar('wilayah');
        $id_kafe = $this->request->getPost('id');

        if ($wilayah != $wilayahLama) {
            // jika ada berubahan wilayah
            $wilayah = explode(',', $this->request->getVar('wilayah'));
            $id_kelurahan = $wilayah[0];
            $id_kecamatan = $wilayah[1];
            $id_kabupaten = $wilayah[2];
            $id_provinsi = $wilayah[3];
            $data = [
                'id_kafe' => $id_kafe,
                'id_provinsi'  => $id_provinsi,
                'id_kabupaten'  => $id_kabupaten,
                'id_kecamatan'  => $id_kecamatan,
                'id_kelurahan'  => $id_kelurahan,
                'nama_kafe' => $this->request->getVar('nama_kafe'),
                'alamat_kafe'  => $this->request->getVar('alamat_kafe'),
                'longitude'  => $this->request->getVar('longitude'),
                'latitude'  => $this->request->getVar('latitude'),
                'instagram_kafe'  => $this->request->getVar('instagram_kafe'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        } else {
            // jika wilayah tetap
            $data = [
                'id_kafe' => $id_kafe,
                'nama_kafe' => $this->request->getVar('nama_kafe'),
                'alamat_kafe'  => $this->request->getVar('alamat_kafe'),
                'longitude'  => $this->request->getVar('longitude'),
                'latitude'  => $this->request->getVar('latitude'),
                'instagram_kafe'  => $this->request->getVar('instagram_kafe'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }
        $updateKafe = $this->kafe->updateKafe($data, $id_kafe);
        // echo '<pre>';
        // var_dump($data);

        $opens = $this->request->getVar('open-time[]');
        $open = [];
        foreach ($opens as $item) {
            if ($item == '') {
                $open[] = null;
            } else {
                $open[] = $item;
            }
        }
        // print_r($open);
        $closes = $this->request->getVar('close-time[]');
        $close = [];
        foreach ($closes as $item) {
            if ($item == '') {
                $close[] = null;
            } else {
                $close[] = $item;
            }
        }
        // print_r($close);
        $day = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        // Mengambil id kafe
        $id = [];
        foreach ($open as $key) {
            $id[] = $id_kafe;
        }
        // print_r($id);
        $datas = [
            'kafe_id' => $id,
            'hari' => $day,
            'open_time' => $open,
            'close_time' => $close
        ];
        $data = [];
        $i = 0;
        foreach ($datas as $key => $val) {
            $i = 0;
            foreach ($val as $k => $v) {
                $data[$i][$key] = $v;
                $i++;
            }
        }
        foreach ($data as $time) {
            $update = $time;
            $hari = $update['hari'];
            $updateTime = $this->kafe->updateTime($update, $id_kafe, $hari);
        }
        // var_dump($update);
        // die;

        $files = $this->request->getFiles();
        if (isset($files['foto_kafe']) && !empty($files['foto_kafe'])) {
            foreach ($files['foto_kafe'] as $key => $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $imageName = $img->getRandomName();
                    // Image manipulation(compress)
                    $image = \Config\Services::image()
                        ->withFile($img)
                        ->resize(1200, 900, true, 'height')
                        ->save(FCPATH . '/img/kafe/' . $imageName);

                    $dataF = [
                        'id_kafe' => $id_kafe,
                        'nama_file_foto' => $imageName,
                    ];
                    $this->fotoKafe->addFoto($dataF);
                }
            }
        }

        if (in_groups('User')) {
            $status = [
                'stat_appv' => '0',
                'date_updated' => date('Y-m-d H:i:s'),
            ];
            $this->kafe->chck_appv($status, $id_kafe);
        }

        if ($updateKafe && $updateTime) {
            session()->setFlashdata('success', 'Data Berhasil diperbarui.');
            if (in_groups('User')) {
                return $this->response->redirect(site_url('/dashboard'));
            } else {
                return $this->response->redirect(site_url('/admin/data/data-perizinan'));
            }
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui data.');
            if (in_groups('User')) {
                return $this->response->redirect(site_url('/dashboard'));
            } else {
                return $this->response->redirect(site_url('/admin/data/data-perizinan'));
            }
        }
    }

    // Delete Data
    public function delete_Kafe($id_kafe)
    {
        $files = $this->fotoKafe->getFoto($id_kafe)->getResult();
        foreach ($files as $img) {
            $file = $img->nama_file_foto;
            unlink("img/kafe/" . $file);
        }
        $this->kafe->delete(['id_kafe' => $id_kafe]);
        if ($this) {
            session()->setFlashdata('success', 'Data berhasil dihapus.');
            if (in_groups('User')) {
                return $this->response->redirect(site_url('/dashboard'));
            } else {
                return $this->response->redirect(site_url('/admin/data/data-perizinan'));
            }
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data.');
            if (in_groups('User')) {
                return $this->response->redirect(site_url('/dashboard'));
            } else {
                return $this->response->redirect(site_url('/admin/data/data-perizinan'));
            }
        }
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

    // approve data
    public function approveKafe($id_kafe)
    {
        $data = [
            'stat_appv' => '1',
            'date_updated' => date('Y-m-d H:i:s'),
        ];
        $this->kafe->chck_appv($data, $id_kafe);
        if ($this) {
            session()->setFlashdata('success', 'Data Approved.');
            return $this->response->redirect(site_url('/admin/pending'));
        } else {
            session()->setFlashdata('error', 'Proses gagal.');
            return $this->response->redirect(site_url('/admin/pending'));
        }
    }

    // reject data
    public function rejectKafe($id_kafe)
    {
        $data = [
            'stat_appv' => '2',
            'date_updated' => date('Y-m-d H:i:s'),
        ];
        $this->kafe->chck_appv($data, $id_kafe);
        if ($this) {
            session()->setFlashdata('success', 'Data Rejected.');
            return $this->response->redirect(site_url('/admin/pending'));
        } else {
            session()->setFlashdata('error', 'Proses gagal.');
            return $this->response->redirect(site_url('/admin/pending'));
        }
    }



    public function autodel()
    { // Mendapatkan waktu saat ini
        $now = time();
        $thirtyMinutesAgo = $now - (7 * 24 * 60 * 60); // Mengurangi 7 hari dalam detik

        // $query = "DELETE FROM tbl_kafe WHERE stat_appv = 0 AND created_at < '$sevenDaysAgo'";
        $query = $this->kafe->callTolakData()->getResult();

        $delete = [];
        foreach ($query as $row) {
            $createdAt = strtotime($row->created_at);
            if ($createdAt < $thirtyMinutesAgo) {
                $id_del[] = $row->id_kafe;
                $delete[] = $row;
            }
        }
        // Mengubah array $id_del menjadi string dengan pemisah koma
        $idDelString = implode(',', $id_del);
        if (!empty($delete)) {
            // Data ditemukan, lakukan penghapusan
            $files = $this->fotoKafe->getFoto($idDelString)->getResult();
            if (!empty($files)) {
                foreach ($files as $img) {
                    $file = $img->nama_file_foto;
                    unlink("img/kafe/" . $file);
                }
            }
            $this->kafe->delete(['id_kafe' => $idDelString]);
            if ($this) {
                echo "Data kafe yang tidak disetujui (stat_appv = 2) yang lebih dari 7 hari berhasil dihapus.";
            } else {
                echo "Gagal menghapus data kafe.";
            }
        } else {
            echo "Tidak ada data kafe yang memenuhi kriteria penghapusan.";
        }
    }

    // side server delete image
    public function deleteImage()
    {
        // Menerima ID data yang akan dihapus dari permintaan POST
        $id = $this->request->getPost('id');
        $imgData = $this->fotoKafe->getImgRow($id)->getRow();
        // Remove files from the server  
        $file = $imgData->nama_file_foto;
        unlink("img/kafe/" . $file);
        // Delete image data 
        $this->fotoKafe->delete(['id' => $id]);
        // Ambil data gambar dari database
        $imageUrl = $this->fotoKafe->getFoto()->getResult();
        // Kembalikan data ke client dalam format JSON
        return json_encode(['status' => true, 'imageUrl' => $imageUrl]);
    }


    // side server preview image
    public function previewImg($id_kafe)
    {
        $data = [
            'getFoto' => $this->fotoKafe->getFoto($id_kafe)->getResult(),
        ];
        return view('serverSide/previewImg', $data);
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
