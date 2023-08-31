<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKesesuaianIzin extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tbl_kesesuaian_izin';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_znkwsn', 'kode_kegiatan', 'status_k'];

    function __construct()
    {
        $this->db = db_connect();
    }

    public function getKesesuaian($id = false)
    {
        if ($id === false) {
            return $this->db->table('tbl_kesesuaian_izin')
                ->select('tbl_kesesuaian_izin.*, tbl_kegiatan.*, tbl_zonakawasan.*, tbl_rencana_pemanfaatan.*, tbl_jenis_zona.*')
                ->join('tbl_kegiatan', 'tbl_kegiatan.kode_kegiatan = tbl_kesesuaian_izin.kode_kegiatan', 'LEFT')
                ->join('tbl_zonakawasan', 'tbl_zonakawasan.id_znkwsn = tbl_kesesuaian_izin.id_znkwsn', 'LEFT')
                ->join('tbl_rencana_pemanfaatan', 'tbl_rencana_pemanfaatan.id_rencana = tbl_zonakawasan.id_rencana_objek', 'LEFT')
                ->join('tbl_jenis_zona', 'tbl_jenis_zona.id_zona = tbl_zonakawasan.id_zona', 'LEFT')
                ->orderBy('id_rencana_objek', 'ASC')
                ->get();
        } else {
            return $this->db->table('tbl_kesesuaian_izin')
                ->select('tbl_kesesuaian_izin.*, tbl_kegiatan.*, tbl_zonakawasan.*, tbl_rencana_pemanfaatan.*, tbl_jenis_zona.*')
                ->join('tbl_kegiatan', 'tbl_kegiatan.kode_kegiatan = tbl_kesesuaian_izin.kode_kegiatan', 'LEFT')
                ->join('tbl_zonakawasan', 'tbl_zonakawasan.id_znkwsn = tbl_kesesuaian_izin.id_znkwsn', 'LEFT')
                ->join('tbl_rencana_pemanfaatan', 'tbl_rencana_pemanfaatan.id_rencana = tbl_zonakawasan.id_rencana_objek', 'LEFT')
                ->join('tbl_jenis_zona', 'tbl_jenis_zona.id_zona = tbl_zonakawasan.id_zona', 'LEFT')
                ->orderBy('id_rencana_objek', 'ASC')
                ->getWhere(['tbl_kesesuaian_izin.id' => $id]);
        }
    }

    function getFilterKesesuaian()
    {
        return $this->db->table('tbl_kesesuaian_izin')
            ->select('tbl_kesesuaian_izin.*, tbl_kegiatan.*, tbl_zonakawasan.*, tbl_rencana_pemanfaatan.*, tbl_jenis_zona.*')
            ->join('tbl_kegiatan', 'tbl_kegiatan.kode_kegiatan = tbl_kesesuaian_izin.kode_kegiatan', 'LEFT')
            ->join('tbl_zonakawasan', 'tbl_zonakawasan.id_znkwsn = tbl_kesesuaian_izin.id_znkwsn', 'LEFT')
            ->join('tbl_rencana_pemanfaatan', 'tbl_rencana_pemanfaatan.id_rencana = tbl_zonakawasan.id_rencana_objek', 'LEFT')
            ->join('tbl_jenis_zona', 'tbl_jenis_zona.id_zona = tbl_zonakawasan.id_zona', 'LEFT')
            ->orderBy('id_rencana_objek', 'ASC')
            ->where(['kode_kawasan' => "KPU-W-17"])
            ->get();
    }

    function addKesesuaian($addKesesuaian)
    {
        return  $this->db->table('tbl_kesesuaian_izin')->insert($addKesesuaian);
    }
    public function updateKesesuaian($data, $id_znkwsn)
    {
        return $this->db->table('tbl_kesesuaian_izin')->update($data, ['id_znkwsn' => $id_znkwsn]);
    }
}
