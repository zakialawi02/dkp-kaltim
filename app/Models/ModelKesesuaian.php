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

    public function getKesesuaian($id_kesesuaian = false, $kode_kawasan = false)
    {
        if ($id_kesesuaian === false && $kode_kawasan === false) {
            return $this->db->table('tbl_kesesuaian')
                ->select('tbl_kesesuaian.*, tbl_kegiatan.*, tbl_zona.*')
                ->join('tbl_kegiatan', 'tbl_kegiatan.kode_kegiatan = tbl_kesesuaian.kode_kegiatan', 'LEFT')
                ->join('tbl_zona', 'tbl_zona.id_zona = tbl_kesesuaian.id_zona', 'LEFT')
                ->orderBy('tbl_kesesuaian.id_zona', 'ASC')
                ->orderBy('tbl_kegiatan.id_kegiatan', 'ASC')
                ->get();
        } else if ($id_kesesuaian === false) {
            return $this->db->table('tbl_kesesuaian')
                ->select('tbl_kesesuaian.*, tbl_kegiatan.*, tbl_zona.*, tbl_zona_kawasan.kode_kawasan as kode_kawasan')
                ->join('tbl_kegiatan', 'tbl_kegiatan.kode_kegiatan = tbl_kesesuaian.kode_kegiatan', 'LEFT')
                ->join('tbl_zona', 'tbl_zona.id_zona = tbl_kesesuaian.id_zona', 'LEFT')
                ->join('tbl_zona_kawasan', 'tbl_zona_kawasan.id_zona = tbl_zona.id_zona', 'LEFT')
                ->orderBy('tbl_kesesuaian.id_zona', 'ASC')
                ->orderBy('tbl_kegiatan.id_kegiatan', 'ASC')
                ->Where(['tbl_kesesuaian.id_kesesuaian' => $id_kesesuaian])
                ->get();
        } else {
            return $this->db->table('tbl_kesesuaian')
                ->select('tbl_kesesuaian.*, tbl_kegiatan.*, tbl_zona.*, tbl_zona_kawasan.kode_kawasan as kode_kawasan')
                ->join('tbl_kegiatan', 'tbl_kegiatan.kode_kegiatan = tbl_kesesuaian.kode_kegiatan', 'LEFT')
                ->join('tbl_zona', 'tbl_zona.id_zona = tbl_kesesuaian.id_zona', 'LEFT')
                ->join('tbl_zona_kawasan', 'tbl_zona_kawasan.id_zona = tbl_zona.id_zona', 'LEFT')
                ->orderBy('tbl_kesesuaian.id_zona', 'ASC')
                ->orderBy('tbl_kegiatan.id_kegiatan', 'ASC')
                ->getWhere(['tbl_kesesuaian.id_kesesuaian' => $id_kesesuaian, 'kode_kawasan' => $kode_kawasan,]);
        }
    }

    public function searchKesesuaian($kode_kegiatan = "", $id_zona = "", $kode_kawasan = "", $sub_zona = "")
    {
        $query = $this->db->table('tbl_kesesuaian')
            ->select('tbl_kesesuaian.*, tbl_kegiatan.*, tbl_zona.*, tbl_zona_kawasan.kode_kawasan as kawasan')
            ->join('tbl_kegiatan', 'tbl_kegiatan.kode_kegiatan = tbl_kesesuaian.kode_kegiatan', 'LEFT')
            ->join('tbl_zona', 'tbl_zona.id_zona = tbl_kesesuaian.id_zona', 'LEFT')
            ->join('tbl_zona_kawasan', 'tbl_zona_kawasan.id_zona = tbl_kesesuaian.id_zona', 'LEFT');

        if (!empty($kode_kegiatan) && !empty($id_zona) && !empty($kode_kawasan) && !empty($sub_zona)) {
            return $query->orderBy('tbl_kesesuaian.id_zona', 'ASC')
                ->orderBy('tbl_kegiatan.id_kegiatan', 'ASC')
                ->getWhere([
                    'tbl_kesesuaian.kode_kegiatan' => $kode_kegiatan,
                    'tbl_kesesuaian.id_zona' => $id_zona,
                    'kode_kawasan' => $kode_kawasan,
                    'sub_zona' => $sub_zona,
                ]);
        } else if (!empty($kode_kegiatan) && !empty($id_zona) && !empty($kode_kawasan)) {
            return $query->orderBy('tbl_kesesuaian.id_zona', 'ASC')
                ->orderBy('tbl_kegiatan.id_kegiatan', 'ASC')
                ->getWhere([
                    'tbl_kesesuaian.kode_kegiatan' => $kode_kegiatan,
                    'tbl_kesesuaian.id_zona' => $id_zona,
                    'kode_kawasan' => $kode_kawasan,
                ]);
        } else if (!empty($kode_kegiatan) && !empty($kode_kawasan) && !empty($sub_zona)) {
            return $query->orderBy('tbl_kesesuaian.id_zona', 'ASC')
                ->orderBy('tbl_kesesuaian.id_zona', 'ASC')
                ->getWhere([
                    'tbl_kesesuaian.kode_kegiatan' => $kode_kegiatan,
                    'tbl_kesesuaian.id_zona' => $id_zona,
                    'kode_kawasan' => $kode_kawasan,
                ]);
        } else {
            return $query->orderBy('tbl_kesesuaian.id_zona', 'ASC')
                ->orderBy('tbl_kegiatan.id_kegiatan', 'ASC')
                ->get();
        }
    }

    public function  getKesesuaianByZona($id_zona)
    {
        return $query = $this->db->table('tbl_kesesuaian')
            ->select('tbl_kesesuaian.*, tbl_kegiatan.*, tbl_zona.*, tbl_zona_kawasan.kode_kawasan as kawasan')
            ->join('tbl_kegiatan', 'tbl_kegiatan.kode_kegiatan = tbl_kesesuaian.kode_kegiatan', 'LEFT')
            ->join('tbl_zona', 'tbl_zona.id_zona = tbl_kesesuaian.id_zona', 'LEFT')
            ->join('tbl_zona_kawasan', 'tbl_zona_kawasan.id_zona = tbl_kesesuaian.id_zona', 'LEFT')
            ->orderBy('tbl_kesesuaian.id_zona', 'ASC')
            ->orderBy('tbl_kegiatan.id_kegiatan', 'ASC')
            ->getWhere([
                'tbl_kesesuaian.id_zona' => $id_zona,
            ]);
    }

    public function selectedByKegiatan($kode_kegiatan)
    {
        return $this->db->table('tbl_kesesuaian')
            ->select('tbl_kesesuaian.*, tbl_kegiatan.*, tbl_zona.*, tbl_zona_kawasan.kode_kawasan as kawasan')
            ->join('tbl_kegiatan', 'tbl_kegiatan.kode_kegiatan = tbl_kesesuaian.kode_kegiatan', 'LEFT')
            ->join('tbl_zona_kawasan', 'tbl_zona_kawasan.id_zona = tbl_kesesuaian.id_zona', 'LEFT')
            ->join('tbl_zona', 'tbl_zona.id_zona = tbl_kesesuaian.id_zona', 'LEFT')
            ->getWhere([
                'tbl_kesesuaian.kode_kegiatan' => $kode_kegiatan,
            ]);
    }
}
