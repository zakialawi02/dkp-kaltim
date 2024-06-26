<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelModul extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tbl_modul';
    protected $primaryKey       = 'id_modul';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['judul_modul', 'deskripsi', 'file_modul', 'thumb_modul'];

    // Validation
    protected $validationRules      = [
        'judul_modul' => 'required|min_length[4]',
        'deskripsi' => 'required|min_length[10]',
        // 'file_modul' => 'uploaded[file_modul]|max_size[file_modul,52428800]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;


    public function getModul($id_modul = false)
    {
        if ($id_modul == false) {
            return $this->db->table('tbl_modul')
                ->select('tbl_modul.*')
                ->get();
        } else {
            return $this->db->table('tbl_modul')
                ->select('tbl_modul.*')
                ->Where(['tbl_modul.id_modul' => $id_modul])
                ->get();
        }
    }
}
