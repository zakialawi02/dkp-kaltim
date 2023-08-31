<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelJenisZona extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tbl_jenis_zona';
    protected $primaryKey       = 'id_zona';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_zona'];

    function __construct()
    {
        $this->db = db_connect();
    }

    public function getZonaType($id_zona = false)
    {
        if ($id_zona === false) {
            return $this->db->table('tbl_jenis_zona')
                ->select('*')
                ->orderBy('id_zona', 'ASC')
                ->get();
        } else {
            return $this->db->table('tbl_jenis_zona')
                ->select('*')
                ->orderBy('id_zona', 'ASC')
                ->Where(['tbl_jenis_zona.id_zona' => $id_zona])
                ->get();
        }
    }
}
