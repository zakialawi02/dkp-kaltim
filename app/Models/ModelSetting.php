<?php

namespace App\Models;

use CodeIgniter\Model;


class ModelSetting extends Model
{
    protected $table      = 'tbl_setting';
    protected $primaryKey = 'id';


    protected $allowedFields = ['coordinat_wilayah', 'zoom_view'];

    function __construct()
    {
        $this->db = db_connect();
    }

    function tampilData()
    {
        return $this->Where(['id' => 1])->get();
    }

    function updateData($data)
    {
        return $this->db->table('tbl_setting')->update($data);
    }


    // update data /my-profile
    public function updateMyData($data, $id)
    {
        return $this->db->table('users')->update($data, ['id' => $id]);
    }
}
