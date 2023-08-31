<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelZonaKawasan extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tbl_zonakawasan';
    protected $primaryKey       = 'id_znkwsn';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_rencana_objek', 'id_zona', 'kode_kawasan'];

    function __construct()
    {
        $this->db = db_connect();
    }

    public function getZonaKawasan($id_znkwsn = false)
    {
        if ($id_znkwsn === false) {
            return $this->db->table('tbl_zonakawasan')
                ->select('tbl_zonakawasan.*, tbl_rencana_pemanfaatan.*, tbl_jenis_zona.*')
                ->join('tbl_rencana_pemanfaatan', 'tbl_rencana_pemanfaatan.id_rencana = tbl_zonakawasan.id_rencana_objek', 'LEFT')
                ->join('tbl_jenis_zona', 'tbl_jenis_zona.id_zona = tbl_zonakawasan.id_zona', 'LEFT')
                ->orderBy('id_rencana_objek', 'ASC')
                ->get();
        } else {
            return $this->db->table('tbl_zonakawasan')
                ->select('tbl_zonakawasan.*, tbl_rencana_pemanfaatan.*, tbl_jenis_zona.*')
                ->join('tbl_rencana_pemanfaatan', 'tbl_rencana_pemanfaatan.id_rencana = tbl_zonakawasan.id_rencana_objek', 'LEFT')
                ->join('tbl_jenis_zona', 'tbl_jenis_zona.id_zona = tbl_zonakawasan.id_zona', 'LEFT')
                ->orderBy('id_rencana_objek', 'ASC')
                ->Where(['tbl_zonakawasan.id_znkwsn' => $id_znkwsn])
                ->get();
        }
    }

    function addKawasann($addKawasann)
    {
        return  $this->db->table('tbl_zonakawasan')->insert($addKawasann);
    }
    public function updateKawasan($data, $id_znkwsn)
    {
        return $this->db->table('tbl_zonakawasan')->update($data, ['id_znkwsn' => $id_znkwsn]);
    }
}
