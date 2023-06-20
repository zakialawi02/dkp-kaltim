<?php

namespace App\Models;

use CodeIgniter\Model;


class ModelFoto extends Model
{
    protected $table      = 'tbl_foto_kafe';
    protected $primaryKey = 'id';


    protected $allowedFields = ['id_kafe', 'nama_file_foto'];

    function __construct()
    {
        $this->db = db_connect();
    }

    function getFoto($id_kafe = false)
    {
        if ($id_kafe === false) {
            return $this->db->table('tbl_foto_kafe')->get();
        } else {
            return $this->db->table('tbl_foto_kafe')->Where(['id_kafe' => $id_kafe])->get();
        }
    }


    public function getImgRow($id)
    {
        return $this->Where(['id' => $id])->get();
    }


    function addFoto($addFoto)
    {
        return $this->db->table('tbl_foto_kafe')->insert($addFoto);
    }
}
