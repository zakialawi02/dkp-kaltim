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
            ->select('*')
            ->get();
    }

    public function getSubZona()
    {
        return $this->db->table('tbl_zona_pemanfaatan')
            ->select('*')
            ->get();
    }
    public function getStatusZonasi()
    {
        return $this->db->table('tbl_izin_zonasi')
            ->select('*')
            ->join('tbl_kegiatan', 'tbl_kegiatan.id_kegiatan = tbl_izin_zonasi.id_kegiatan', 'LEFT')
            ->join('tbl_zona_pemanfaatan', 'tbl_zona_pemanfaatan.id_sub = tbl_izin_zonasi.id_sub', 'LEFT')
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
