<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelNamaZona extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tbl_zona';
    protected $primaryKey       = 'id_zona';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_zona'];


    public function getZona($id_zona = false)
    {
        if ($id_zona === false) {
            return $this->db->table('tbl_zona')
                ->select('tbl_zona.*')
                ->orderBy('id_zona', 'ASC')
                ->get();
        } else {
            return $this->db->table('tbl_zona')
                ->select('*')
                ->orderBy('id_zona', 'ASC')
                ->Where(['tbl_zona.id_zona' => $id_zona])
                ->get();
        }
    }

    public function whereZona($params = false)
    {
        return $this->db->table('tbl_zona')
            ->select('*')
            ->orderBy('id_zona', 'ASC')
            ->Where(['tbl_zona.nama_zona' => $params])
            ->get();
    }

    public function searchZona($key = false)
    {
        return $this->db->table('tbl_zona')
            ->select('*')
            ->orderBy('id_zona', 'ASC')
            ->like(['tbl_zona.nama_zona' => $key])
            ->get();
    }
}
