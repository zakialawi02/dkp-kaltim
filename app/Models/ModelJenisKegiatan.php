<?php

namespace App\Models;

use CodeIgniter\Model;


class ModelJenisKegiatan extends Model
{
    protected $table      = 'tbl_kegiatan';
    protected $primaryKey = 'id_kegiatan';
    protected $returnType     = 'array';

    protected $allowedFields = ['nama_kegiatan'];

    function __construct()
    {
        $this->db = db_connect();
    }

    public function getJenisKegiatan($id_kegiatan = false)
    {
        if ($id_kegiatan === false) {
            return $this->db->table('tbl_kegiatan')
                ->select('*')
                ->orderBy('id_kegiatan', 'ASC')
                ->get();
        } else {
            return $this->db->table('tbl_kegiatan')
                ->select('*')
                ->orderBy('id_kegiatan', 'ASC')
                ->Where(['tbl_kegiatan.id_kegiatan' => $id_kegiatan])
                ->get();
        }
    }

    public function getSubZona($id_sub = false)
    {
        if ($id_sub === false) {
            return $this->db->table('tbl_zona_pemanfaatan')
                ->select('*')
                ->orderBy('id_sub', 'ASC')
                ->get();
        } else {
            return $this->db->table('tbl_zona_pemanfaatan')
                ->select('*')
                ->orderBy('id_sub', 'ASC')
                ->Where(['tbl_zona_pemanfaatan.id_sub' => $id_sub])
                ->get();
        }
    }
    public function getStatusZonasi($id_kegiatan = false, $id_sub = false)
    {
        if ($id_kegiatan === false && $id_sub === false) {
            return $this->db->table('tbl_izin_zonasi')
                ->select('*')
                ->join('tbl_kegiatan', 'tbl_kegiatan.id_kegiatan = tbl_izin_zonasi.id_kegiatan', 'LEFT')
                ->join('tbl_zona_pemanfaatan', 'tbl_zona_pemanfaatan.id_sub = tbl_izin_zonasi.id_sub', 'LEFT')
                ->orderBy('tbl_izin_zonasi.id_kegiatan', 'ASC')
                ->get();
        } else {
            return $this->db->table('tbl_izin_zonasi')
                ->select('*')
                ->join('tbl_kegiatan', 'tbl_kegiatan.id_kegiatan = tbl_izin_zonasi.id_kegiatan', 'LEFT')
                ->join('tbl_zona_pemanfaatan', 'tbl_zona_pemanfaatan.id_sub = tbl_izin_zonasi.id_sub', 'LEFT')
                ->orderBy('tbl_izin_zonasi.id_kegiatan', 'ASC')
                ->where(['tbl_kegiatan.id_kegiatan' => $id_kegiatan, 'tbl_zona_pemanfaatan.id_sub' => $id_sub])
                ->get();
        }
    }

    public function getStatusZonasiGrouped($id_kegiatan = false)
    {
        if ($id_kegiatan === false) {
            return $this->db->table('tbl_izin_zonasi')
                ->select('*')
                ->join('tbl_kegiatan', 'tbl_kegiatan.id_kegiatan = tbl_izin_zonasi.id_kegiatan', 'LEFT')
                ->join('tbl_zona_pemanfaatan', 'tbl_zona_pemanfaatan.id_sub = tbl_izin_zonasi.id_sub', 'LEFT')
                ->orderBy('tbl_izin_zonasi.id_sub', 'ASC')
                ->get();
        } else {
            return $this->db->table('tbl_izin_zonasi')
                ->select('*')
                ->join('tbl_kegiatan', 'tbl_kegiatan.id_kegiatan = tbl_izin_zonasi.id_kegiatan', 'LEFT')
                ->join('tbl_zona_pemanfaatan', 'tbl_zona_pemanfaatan.id_sub = tbl_izin_zonasi.id_sub', 'LEFT')
                ->orderBy('tbl_izin_zonasi.id_sub', 'ASC')
                ->where(['tbl_kegiatan.id_kegiatan' => $id_kegiatan])
                ->get();
        }
    }

    public function addZonasiStatus($data)
    {
        return  $this->db->table('tbl_izin_zonasi')->insert($data);
    }
    public function updateZonasiStatus($id_kegiatan, $id_sub, $data)
    {
        return $this->db->table('tbl_izin_zonasi')->update($data, ['id_kegiatan' => $id_kegiatan, 'id_sub' => $id_sub]);
    }


    // AJAX Remote Dropdown
    public function getZonaByKegiatanAjax($kegiatanId)
    {
        return $this->db->table('tbl_izin_zonasi')
            ->select('tbl_izin_zonasi.*, tbl_kegiatan.*, tbl_zona_pemanfaatan.*')
            ->join('tbl_kegiatan', 'tbl_kegiatan.id_kegiatan = tbl_izin_zonasi.id_kegiatan', 'LEFT')
            ->join('tbl_zona_pemanfaatan', 'tbl_zona_pemanfaatan.id_sub = tbl_izin_zonasi.id_sub', 'LEFT')
            ->where('tbl_izin_zonasi.id_kegiatan', $kegiatanId)
            ->get()->getResultArray();
    }
}
