<?php

namespace App\Models;

use CodeIgniter\Model;


class ModelJenisKegiatan extends Model
{
    protected $table      = 'tbl_kegiatan';
    protected $primaryKey = 'id_kegiatan';
    protected $returnType     = 'array';

    protected $allowedFields = ['nama_kegiatan', 'kode_kegiatan'];

    function __construct()
    {
        $this->db = db_connect();
    }

    public function getJenisKegiatan($id_kegiatan = false)
    {
        if ($id_kegiatan === false) {
            return $this->db->table('tbl_kegiatan')
                ->select('*')
                ->orderBy('id_kegiatan', 'ASC')
                ->get();
        } else {
            return $this->db->table('tbl_kegiatan')
                ->select('*')
                ->orderBy('id_kegiatan', 'ASC')
                ->Where(['tbl_kegiatan.id_kegiatan' => $id_kegiatan])
                ->get();
        }
    }

    public function getJenisKegiatanbyKode($kode_kegiatan = false)
    {
        if ($kode_kegiatan === false) {
            return $this->db->table('tbl_kegiatan')
                ->select('*')
                ->orderBy('kode_kegiatan', 'ASC')
                ->get();
        } else {
            return $this->db->table('tbl_kegiatan')
                ->select('*')
                ->orderBy('kode_kegiatan', 'ASC')
                ->Where(['tbl_kegiatan.kode_kegiatan' => $kode_kegiatan])
                ->get();
        }
    }
}
