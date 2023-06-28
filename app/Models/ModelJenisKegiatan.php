<?php

namespace App\Models;

use CodeIgniter\Model;


class ModelJenisKegiatan extends Model
{
    protected $table      = 'tbl_kegiatan';
    protected $primaryKey = 'id_kegiatan';
    protected $returnType     = 'array';

    protected $allowedFields = ['nama_kegiatan'];

    function __construct()
    {
        $this->db = db_connect();
    }

    public function getJenisKegiatan()
    {
        return $this->db->table('tbl_kegiatan')
            ->select('tbl_kegiatan.*')
            ->get();
    }

    // Ajax Remote Wilayah Administrasi
    public function getDataAjaxRemote($search)
    {
        return $this->db->table('tbl_kelurahan')
            ->select('tbl_kelurahan.id_kelurahan as id_kelurahan, nama_kelurahan, tbl_kecamatan.id_kecamatan as id_kecamatan, nama_kecamatan, tbl_kabupaten.id_kabupaten as id_kabupaten, nama_kabupaten, tbl_provinsi.id_provinsi as id_provinsi, nama_provinsi')
            ->join('tbl_kecamatan', 'tbl_kecamatan.id_kecamatan = tbl_kelurahan.id_kecamatan')
            ->join('tbl_kabupaten', 'tbl_kabupaten.id_kabupaten = tbl_kecamatan.id_kabupaten')
            ->join('tbl_provinsi', 'tbl_provinsi.id_provinsi = tbl_kabupaten.id_provinsi')
            ->like('nama_kecamatan', $search)
            ->orLike('nama_kelurahan', $search)
            ->get()->getResultArray();
    }
    public function getKode($kode)
    {
        return $this->db->table('tbl_kelurahan')
            ->select('tbl_kelurahan.id_kelurahan as id_kelurahan, nama_kelurahan, tbl_kecamatan.id_kecamatan as id_kecamatan, nama_kecamatan, tbl_kabupaten.id_kabupaten as id_kabupaten, nama_kabupaten, tbl_provinsi.id_provinsi as id_provinsi, nama_provinsi')
            ->join('tbl_kecamatan', 'tbl_kecamatan.id_kecamatan = tbl_kelurahan.id_kecamatan')
            ->join('tbl_kabupaten', 'tbl_kabupaten.id_kabupaten = tbl_kecamatan.id_kabupaten')
            ->join('tbl_provinsi', 'tbl_provinsi.id_provinsi = tbl_kabupaten.id_provinsi')
            ->where('tbl_kelurahan.id_kelurahan',  $kode)
            ->get()->getResultArray();
    }
    // vardump AjaxRemote
    public function Remote()
    {
        return $this->db->table('tbl_kelurahan')
            ->select('tbl_kelurahan.id_kelurahan as id_kelurahan, nama_kelurahan, tbl_kecamatan.id_kecamatan as id_kecamatan, nama_kecamatan, tbl_kabupaten.id_kabupaten as id_kabupaten, nama_kabupaten, tbl_provinsi.id_provinsi as id_provinsi, nama_provinsi')
            ->join('tbl_kecamatan', 'tbl_kecamatan.id_kecamatan = tbl_kelurahan.id_kecamatan')
            ->join('tbl_kabupaten', 'tbl_kabupaten.id_kabupaten = tbl_kecamatan.id_kabupaten')
            ->join('tbl_provinsi', 'tbl_provinsi.id_provinsi = tbl_kabupaten.id_provinsi')
            ->like('nama_kecamatan', 'keput')
            ->orLike('nama_kelurahan', 'keput')
            ->get()->getResultArray();
    }
}
