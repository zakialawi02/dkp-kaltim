<?php

namespace App\Models;

use CodeIgniter\Model;


class ModelIzin extends Model
{
    protected $table      = 'tbl_perizinan';
    protected $primaryKey = 'id_perizinan';
    protected $returnType     = 'array';

    protected $allowedFields = ['nik', 'nama', 'kontak', 'longitude', 'latitude', 'id_kegiatan', 'stat_appv', 'id_sub'];

    function __construct()
    {
        $this->db = db_connect();
    }

    function getIzin($id_perizinan = false)
    {
        if ($id_perizinan === false) {
            return $this->db->table('tbl_perizinan')->select('tbl_perizinan.*, tbl_status_appv.*, users.username, tbl_kegiatan.*')
                ->join('tbl_kegiatan', 'tbl_kegiatan.id_kegiatan = tbl_perizinan.id_kegiatan', 'LEFT')
                ->join('tbl_status_appv', 'tbl_status_appv.id_perizinan = tbl_perizinan.id_perizinan', 'LEFT')
                ->join('users', 'users.id = tbl_status_appv.user')
                ->orderBy('updated_at', 'DESC')
                ->getWhere(['stat_appv' => '1']);
        } else {
            return $this->db->table('tbl_perizinan')->select('tbl_perizinan.*, tbl_status_appv.*, users.username, tbl_kegiatan.*')
                ->join('tbl_kegiatan', 'tbl_kegiatan.id_kegiatan = tbl_perizinan.id_kegiatan', 'LEFT')
                ->join('tbl_status_appv', 'tbl_status_appv.id_perizinan = tbl_perizinan.id_perizinan', 'LEFT')
                ->join('users', 'users.id = tbl_status_appv.user')
                ->orderBy('updated_at', 'DESC')
                ->Where(['tbl_perizinan.id_perizinan' => $id_perizinan])
                ->get();
        }
    }

    function callPendingData($id_perizinan = false)
    {
        if ($id_perizinan === false) {
            return $this->db->table('tbl_perizinan')->select('tbl_perizinan.*, tbl_status_appv.*, users.username, tbl_kegiatan.*')
                ->join('tbl_kegiatan', 'tbl_kegiatan.id_kegiatan = tbl_perizinan.id_kegiatan', 'LEFT')
                ->join('tbl_status_appv', 'tbl_status_appv.id_perizinan = tbl_perizinan.id_perizinan', 'LEFT')
                ->join('users', 'users.id = tbl_status_appv.user')
                ->orderBy('updated_at', 'DESC')
                ->getWhere(['stat_appv' => '0']);
        } else {
            return $this->Where(['id_perizinan' => $id_perizinan])->get();
        }
    }

    function getIzinFive()
    {
        $buidler = $this->db->table('tbl_perizinan')->select('tbl_perizinan.*, tbl_status_appv.*, tbl_kegiatan.*')
            ->join('tbl_kegiatan', 'tbl_kegiatan.id_kegiatan = tbl_perizinan.id_kegiatan', 'LEFT')
            ->join('tbl_status_appv', 'tbl_status_appv.id_perizinan = tbl_perizinan.id_perizinan', 'LEFT')
            ->join('users', 'users.id = tbl_status_appv.user')
            ->limit(5)
            ->orderBy('created_at', 'DESC');
        $query = $buidler->getWhere(['stat_appv' => '1']);
        return $query;
    }

    function userSubmitIzin($userid)
    {
        return $this->db->table('tbl_perizinan')->select('tbl_perizinan.*, tbl_status_appv.user, tbl_status_appv.stat_appv, tbl_status_appv.date_updated, tbl_kegiatan.*')
            ->join('tbl_kegiatan', 'tbl_kegiatan.id_kegiatan = tbl_perizinan.id_kegiatan', 'LEFT')
            ->join('tbl_status_appv', 'tbl_status_appv.id_perizinan = tbl_perizinan.id_perizinan', 'LEFT')
            ->join('users', 'users.id = tbl_status_appv.user')
            ->orderBy('created_at', 'DESC')
            ->getWhere(['user' => $userid]);
    }

    function addIzin($addIzin)
    {
        return  $this->db->table('tbl_perizinan')->insert($addIzin);
    }

    public function updateIzin($data, $id_perizinan)
    {
        return $this->db->table('tbl_perizinan')->update($data, ['id_perizinan' => $id_perizinan]);
    }

    function addStatus($addStatus)
    {
        return $this->db->table('tbl_status_appv')->insert($addStatus);
    }
    public function chck_appv($data, $id_perizinan)
    {
        return $this->db->table('tbl_status_appv')->update($data, ['id_perizinan' => $id_perizinan]);
    }




    // SCRAPING DATA FROM DATABASE FOR SELECT FORM MENU

    // PROVINSI
    public function allProvinsi()
    {
        return $this->db->table('tbl_provinsi')->orderBy('id_provinsi', 'ASC')->get()->getResultArray();
    }
    // KABUPATEN/KOTA
    public function allKabupaten($id_provinsi)
    {
        return $this->db->table('tbl_kabupaten')->where('id_provinsi', $id_provinsi)->get()->getResultArray();
    }
    // KECAMATAN
    public function allKecamatan($id_kecamatan)
    {
        return $this->db->table('tbl_kecamatan')->where('id_kabupaten', $id_kecamatan)->get()->getResultArray();
    }
    // KELURAHAN
    public function allKelurahan($id_kelurahan)
    {
        return $this->db->table('tbl_kelurahan')->where('id_kecamatan', $id_kelurahan)->get()->getResultArray();
    }
    function tes()
    {
        return $this->db->table('test')->get();
    }
}
