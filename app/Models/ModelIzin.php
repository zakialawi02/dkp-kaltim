<?php

namespace App\Models;

use CodeIgniter\Model;


class ModelIzin extends Model
{
    protected $table      = 'tbl_perizinan';
    protected $primaryKey = 'id_perizinan';
    protected $returnType     = 'array';

    protected $allowedFields = ['nik', 'nib', 'nama', 'kontak', 'alamat', 'lokasi', 'id_kegiatan', 'uploadFiles', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'nik' => 'required|numeric|min_length[16]|max_length[16]',
        'nib' => 'required|min_length[10]|max_length[20]',
        'nama' => 'required|min_length[3]|max_length[100]',
        'kontak' => 'required|numeric|min_length[6]|max_length[20]',
        'alamat' => 'required|min_length[3]|max_length[200]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    function __construct()
    {
        $this->db = db_connect();
    }

    function getAllPermohonan($id_perizinan = false)
    {
        if ($id_perizinan === false) {
            return $this->db->table('tbl_perizinan')->select('tbl_perizinan.*, tbl_status_appv.*, users.username, tbl_kegiatan.*')
                ->join('tbl_kegiatan', 'tbl_kegiatan.id_kegiatan = tbl_perizinan.id_kegiatan', 'LEFT')
                ->join('tbl_status_appv', 'tbl_status_appv.id_perizinan = tbl_perizinan.id_perizinan', 'LEFT')
                ->join('users', 'users.id = tbl_status_appv.user')
                ->orderBy('updated_at', 'DESC')
                ->get();
        } else {
            return $this->db->table('tbl_perizinan')->select('tbl_perizinan.*, tbl_status_appv.*, users.username, tbl_kegiatan.*')
                ->join('tbl_kegiatan', 'tbl_kegiatan.id_kegiatan = tbl_perizinan.id_kegiatan', 'LEFT')
                ->join('tbl_status_appv', 'tbl_status_appv.id_perizinan = tbl_perizinan.id_perizinan', 'LEFT')
                ->join('users', 'users.id = tbl_status_appv.user')
                ->orderBy('updated_at', 'DESC')
                ->getWhere(['tbl_perizinan.id_perizinan' => $id_perizinan]);
        }
    }


    function getIzin($id_perizinan = false, $status = "1")
    {
        if ($id_perizinan === false) {
            return $this->db->table('tbl_perizinan')->select('tbl_perizinan.*, tbl_status_appv.*, users.username, tbl_kegiatan.*')
                ->join('tbl_kegiatan', 'tbl_kegiatan.id_kegiatan = tbl_perizinan.id_kegiatan', 'LEFT')
                ->join('tbl_status_appv', 'tbl_status_appv.id_perizinan = tbl_perizinan.id_perizinan', 'LEFT')
                ->join('users', 'users.id = tbl_status_appv.user')
                ->orderBy('updated_at', 'DESC')
                ->getWhere(['stat_appv' => $status]);
        } else {
            return $this->db->table('tbl_perizinan')->select('tbl_perizinan.*, tbl_status_appv.*, users.username, tbl_kegiatan.*')
                ->join('tbl_kegiatan', 'tbl_kegiatan.id_kegiatan = tbl_perizinan.id_kegiatan', 'LEFT')
                ->join('tbl_status_appv', 'tbl_status_appv.id_perizinan = tbl_perizinan.id_perizinan', 'LEFT')
                ->join('users', 'users.id = tbl_status_appv.user')
                ->orderBy('updated_at', 'DESC')
                ->getWhere(['stat_appv' => $status, 'tbl_perizinan.id_perizinan' => $id_perizinan]);
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
            return $this->db->table('tbl_perizinan')->select('tbl_perizinan.*, tbl_status_appv.*, users.username, tbl_kegiatan.*')
                ->join('tbl_kegiatan', 'tbl_kegiatan.id_kegiatan = tbl_perizinan.id_kegiatan', 'LEFT')
                ->join('tbl_status_appv', 'tbl_status_appv.id_perizinan = tbl_perizinan.id_perizinan', 'LEFT')
                ->join('users', 'users.id = tbl_status_appv.user')
                ->orderBy('updated_at', 'DESC')
                ->getWhere(['stat_appv' => '0', 'tbl_perizinan.id_perizinan' => $id_perizinan]);
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

    function addPengajuan($addPengajuan)
    {
        return  $this->db->table('tbl_perizinan')->insert($addPengajuan);
    }

    public function updatePengajuan($data, $id_perizinan)
    {
        return $this->db->table('tbl_perizinan')->update($data, ['id_perizinan' => $id_perizinan]);
    }

    function addStatus($addStatus)
    {
        return $this->db->table('tbl_status_appv')->insert($addStatus);
    }
    public function saveStatusAppv($data, $id_perizinan)
    {
        return $this->db->table('tbl_status_appv')->update($data, ['id_perizinan' => $id_perizinan]);
    }
}
