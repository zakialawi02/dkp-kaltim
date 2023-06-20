<?php

namespace App\Models;

use CodeIgniter\Model;


class ModelGeojson extends Model
{
    protected $table      = 'tbl_features';
    protected $primaryKey = 'id';


    protected $allowedFields = ['nama_features', 'features', 'warna'];

    function __construct()
    {
        $this->db = db_connect();
    }

    function callGeojson($id = false)
    {
        if ($id === false) {
            return $this->db->table('tbl_features')->get();
        } else {
            return $this->Where(['id' => $id])->get();
        }
    }

    function addGeojson($addGeojson)
    {
        return $this->db->table('tbl_features')->insert($addGeojson);
    }

    public function updateGeojson($data, $id)
    {
        return $this->db->table('tbl_features')->update($data, ['id' => $id]);
    }
}
