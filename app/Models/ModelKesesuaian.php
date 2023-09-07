<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKesesuaian extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tbl_kesesuaian';
    protected $primaryKey       = 'id_kesesuaian';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['status', 'id_zona', 'kode_kegiatan'];

    public function getKesesuaian($id_kesesuaian = false)
    {
        if ($id_kesesuaian === false) {
            return $this->db->table('tbl_kesesuaian')
                ->select('tbl_kesesuaian.*, tbl_kegiatan.*, tbl_zona.*')
                ->join('tbl_kegiatan', 'tbl_kegiatan.kode_kegiatan = tbl_kesesuaian.kode_kegiatan', 'LEFT')
                ->join('tbl_zona', 'tbl_zona.id_zona = tbl_kesesuaian.id_zona', 'LEFT')
                ->orderBy('id_kesesuaian', 'ASC')
                ->get();
        } else {
            return $this->db->table('tbl_kesesuaian')
                ->select('tbl_kesesuaian.*, tbl_kegiatan.*, tbl_zona.*')
                ->join('tbl_kegiatan', 'tbl_kegiatan.kode_kegiatan = tbl_kesesuaian.kode_kegiatan', 'LEFT')
                ->join('tbl_zona', 'tbl_zona.id_zona = tbl_kesesuaian.id_zona', 'LEFT')
                ->orderBy('id_kesesuaian', 'ASC')
                ->Where(['tbl_kesesuaian.id_kesesuaian' => $id_kesesuaian])
                ->get();
        }
    }

    public function searchKesesuaian($kode_kegiatan = false, $id_zona = false, $kode_kawasan = false)
    {
        if ($kode_kegiatan == false && $id_zona == false && $kode_kawasan == false) {
            return $this->db->table('tbl_kesesuaian')
                ->select('tbl_kesesuaian.*, tbl_kegiatan.*, tbl_zona.*, tbl_zona_kawasan.kode_kawasan as kawasan')
                ->join('tbl_kegiatan', 'tbl_kegiatan.kode_kegiatan = tbl_kesesuaian.kode_kegiatan', 'LEFT')
                ->join('tbl_zona', 'tbl_zona.id_zona = tbl_kesesuaian.id_zona', 'LEFT')
                ->join('tbl_zona_kawasan', 'tbl_zona_kawasan.id_zona = tbl_kesesuaian.id_zona', 'LEFT')
                ->orderBy('id_kesesuaian', 'ASC')
                ->get();
        } else {
            return $this->db->table('tbl_kesesuaian')
                ->select('tbl_kesesuaian.*, tbl_kegiatan.*, tbl_zona.*, tbl_zona_kawasan.kode_kawasan as kawasan')
                ->join('tbl_kegiatan', 'tbl_kegiatan.kode_kegiatan = tbl_kesesuaian.kode_kegiatan', 'LEFT')
                ->join('tbl_zona_kawasan', 'tbl_zona_kawasan.id_zona = tbl_kesesuaian.id_zona', 'LEFT')
                ->join('tbl_zona', 'tbl_zona.id_zona = tbl_kesesuaian.id_zona', 'LEFT')
                ->getWhere([
                    'tbl_kesesuaian.kode_kegiatan' => $kode_kegiatan,
                    'tbl_zona_kawasan.kode_kawasan' => $kode_kawasan,
                    'tbl_kesesuaian.id_zona' => $id_zona,
                ]);
        }
    }
}
