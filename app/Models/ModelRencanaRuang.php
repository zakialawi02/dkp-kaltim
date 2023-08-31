<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelRencanaRuang extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tbl_rencana_pemanfaatan';
    protected $primaryKey       = 'id_rencana';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_rencana_pemanfaatan'];

    function __construct()
    {
        $this->db = db_connect();
    }

    public function getRencanaRuang($id_rencana = false)
    {
        if ($id_rencana === false) {
            return $this->db->table('tbl_rencana_pemanfaatan')
                ->select('*')
                ->orderBy('nama_rencana_pemanfaatan', 'ASC')
                ->get();
        } else {
            return $this->db->table('tbl_rencana_pemanfaatan')
                ->select('*')
                ->orderBy('nama_rencana_pemanfaatan', 'ASC')
                ->Where(['tbl_rencana_pemanfaatan.id_rencana' => $id_rencana])
                ->get();
        }
    }
}
