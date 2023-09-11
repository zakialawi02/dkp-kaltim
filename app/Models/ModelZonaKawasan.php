<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelZonaKawasan extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tbl_zona_kawasan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];


    public function getKawasan($id_znkwsn = false)
    {
        if ($id_znkwsn === false) {
            return $this->db->table('tbl_zona_kawasan')
                ->select('tbl_zona_kawasan.*, tbl_zona.*')
                ->join('tbl_zona', 'tbl_zona.id_zona = tbl_zona_kawasan.id_zona', 'LEFT')
                ->orderBy('id_znkwsn', 'ASC')
                ->get();
        } else {
            return $this->db->table('tbl_zona_kawasan')
                ->select('tbl_zona_kawasan.*, tbl_zona.*')
                ->join('tbl_zona', 'tbl_zona.id_zona = tbl_zona_kawasan.id_zona', 'LEFT')
                ->orderBy('id_znkwsn', 'ASC')
                ->Where(['tbl_zona_kawasan.id_znkwsn' => $id_znkwsn])
                ->get();
        }
    }
    public function getZKawasan($id_zona = false)
    {
        return $this->db->table('tbl_zona_kawasan')
            ->select('tbl_zona_kawasan.*, tbl_zona.*')
            ->join('tbl_zona', 'tbl_zona.id_zona = tbl_zona_kawasan.id_zona', 'LEFT')
            ->orderBy('id_znkwsn', 'ASC')
            ->Where(['tbl_zona_kawasan.id_zona' => $id_zona])
            ->get();
    }
}
