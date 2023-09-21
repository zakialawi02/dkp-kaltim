<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUpload extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tbl_file_upload';
    protected $primaryKey       = 'id_upload';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['file', 'id_perizinan'];


    public function getFiles($id_perizinan = false)
    {
        if ($id_perizinan == false) {
            return $this->db->table('tbl_file_upload')
                ->select('tbl_file_upload.*')
                ->orderBy('tbl_file_upload.id_upload', 'ASC')
                ->get();
        } else {
            return $this->db->table('tbl_file_upload')
                ->select('tbl_file_upload.file as uploadFiles')
                ->orderBy('tbl_file_upload.id_upload', 'ASC')
                ->Where(['tbl_file_upload.id_perizinan' => $id_perizinan])
                ->get();
        }
    }
}
