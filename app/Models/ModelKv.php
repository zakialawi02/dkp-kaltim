<?php

namespace App\Models;

use CodeIgniter\Model;


class ModelKv extends Model
{
    protected $table      = 'tbl_kafe';
    protected $primaryKey = 'id_kafe';
    protected $returnType     = 'array';

    protected $allowedFields = ['nama_kafe', 'alamat_kafe', 'longitude', 'latitude', 'foto_kafe', 'id_provinsi', 'id_kabkot', 'id_kecamatan', 'id_kelurahan', 'stat_appv'];

    function __construct()
    {
        $this->db = db_connect();
    }

    function callKafe($id_kafe = false)
    {
        if ($id_kafe === false) {

            $subquery = $this->db->table('tbl_jam_operasional')
                ->select("json_agg(json_build_object('hari', hari, 'open_time', open_time, 'close_time', close_time))")
                ->where('kafe_id = tbl_kafe.id_kafe')
                ->groupBy('kafe_id')
                ->getCompiledSelect();

            $builder = $this->db->table('tbl_kafe')
                ->select('tbl_kafe.*, tbl_provinsi.nama_provinsi, tbl_kabupaten.nama_kabupaten, tbl_kecamatan.nama_kecamatan, tbl_kelurahan.nama_kelurahan, tbl_status_appv.user, tbl_status_appv.stat_appv, tbl_status_appv.date_updated')
                ->join('tbl_provinsi', 'tbl_provinsi.id_provinsi = tbl_kafe.id_provinsi')
                ->join('tbl_kabupaten', 'tbl_kabupaten.id_kabupaten = tbl_kafe.id_kabupaten')
                ->join('tbl_kecamatan', 'tbl_kecamatan.id_kecamatan = tbl_kafe.id_kecamatan')
                ->join('tbl_kelurahan', 'tbl_kelurahan.id_kelurahan = tbl_kafe.id_kelurahan')
                ->join('tbl_status_appv', 'tbl_status_appv.id_kafe = tbl_kafe.id_kafe', 'LEFT')
                ->groupBy('tbl_kafe.id_kafe, tbl_provinsi.nama_provinsi, tbl_kabupaten.nama_kabupaten, tbl_kecamatan.nama_kecamatan, tbl_kelurahan.nama_kelurahan, tbl_status_appv.user, tbl_status_appv.stat_appv, tbl_status_appv.date_updated')
                ->select("string_agg(DISTINCT tbl_foto_kafe.nama_file_foto, ',') AS nama_foto")
                ->join('tbl_foto_kafe', 'tbl_foto_kafe.id_kafe = tbl_kafe.id_kafe', 'left', false)
                ->select("($subquery) AS jam_oprasional")
                ->orderBy('id_kafe', 'DESC')
                ->getWhere(['stat_appv' => '1']);

            return $builder;
        } else {
            $subquery = $this->db->table('tbl_jam_operasional')
                ->select("json_agg(json_build_object('hari', hari, 'open_time', open_time, 'close_time', close_time))")
                ->where('kafe_id = tbl_kafe.id_kafe')
                ->groupBy('kafe_id')
                ->getCompiledSelect();

            $builder = $this->db->table('tbl_kafe')
                ->select('tbl_kafe.*, tbl_provinsi.nama_provinsi, tbl_kabupaten.nama_kabupaten, tbl_kecamatan.nama_kecamatan, tbl_kelurahan.nama_kelurahan, tbl_status_appv.user, tbl_status_appv.stat_appv, tbl_status_appv.date_updated, users.username')
                ->join('tbl_provinsi', 'tbl_provinsi.id_provinsi = tbl_kafe.id_provinsi')
                ->join('tbl_kabupaten', 'tbl_kabupaten.id_kabupaten = tbl_kafe.id_kabupaten')
                ->join('tbl_kecamatan', 'tbl_kecamatan.id_kecamatan = tbl_kafe.id_kecamatan')
                ->join('tbl_kelurahan', 'tbl_kelurahan.id_kelurahan = tbl_kafe.id_kelurahan')
                ->join('tbl_status_appv', 'tbl_status_appv.id_kafe = tbl_kafe.id_kafe', 'LEFT')
                ->join('users', 'users.id = tbl_status_appv.user', 'LEFT')
                ->groupBy('tbl_kafe.id_kafe, tbl_provinsi.nama_provinsi, tbl_kabupaten.nama_kabupaten, tbl_kecamatan.nama_kecamatan, tbl_kelurahan.nama_kelurahan, tbl_status_appv.user, tbl_status_appv.stat_appv, tbl_status_appv.date_updated, users.username')
                ->select("string_agg(DISTINCT tbl_foto_kafe.nama_file_foto, ',') AS nama_foto")
                ->join('tbl_foto_kafe', 'tbl_foto_kafe.id_kafe = tbl_kafe.id_kafe', 'left', false)
                ->select("($subquery) AS jam_oprasional")
                ->orderBy('id_kafe', 'DESC')
                ->Where(['tbl_kafe.id_kafe' => $id_kafe])
                ->get();

            return $builder;
        }
    }

    function callPendingData($id_kafe = false)
    {
        if ($id_kafe === false) {
            $subquery = $this->db->table('tbl_jam_operasional')
                ->select("json_agg(json_build_object('hari', hari, 'open_time', open_time, 'close_time', close_time))")
                ->where('kafe_id = tbl_kafe.id_kafe')
                ->groupBy('kafe_id')
                ->getCompiledSelect();

            $builder = $this->db->table('tbl_kafe')
                ->select('tbl_kafe.*, tbl_provinsi.nama_provinsi, tbl_kabupaten.nama_kabupaten, tbl_kecamatan.nama_kecamatan, tbl_kelurahan.nama_kelurahan, tbl_status_appv.user, tbl_status_appv.stat_appv, tbl_status_appv.date_updated, users.username')
                ->join('tbl_provinsi', 'tbl_provinsi.id_provinsi = tbl_kafe.id_provinsi')
                ->join('tbl_kabupaten', 'tbl_kabupaten.id_kabupaten = tbl_kafe.id_kabupaten')
                ->join('tbl_kecamatan', 'tbl_kecamatan.id_kecamatan = tbl_kafe.id_kecamatan')
                ->join('tbl_kelurahan', 'tbl_kelurahan.id_kelurahan = tbl_kafe.id_kelurahan')
                ->join('tbl_status_appv', 'tbl_status_appv.id_kafe = tbl_kafe.id_kafe', 'LEFT')
                ->join('users', 'users.id = tbl_status_appv.user', 'LEFT')
                ->groupBy('tbl_kafe.id_kafe, tbl_provinsi.nama_provinsi, tbl_kabupaten.nama_kabupaten, tbl_kecamatan.nama_kecamatan, tbl_kelurahan.nama_kelurahan, tbl_status_appv.user, tbl_status_appv.stat_appv, tbl_status_appv.date_updated, users.username')
                ->select("string_agg(DISTINCT tbl_foto_kafe.nama_file_foto, ',') AS nama_foto")
                ->join('tbl_foto_kafe', 'tbl_foto_kafe.id_kafe = tbl_kafe.id_kafe', 'left', false)
                ->select("($subquery) AS jam_oprasional")
                ->orderBy('id_kafe', 'DESC')
                ->getWhere(['stat_appv' => '0']);

            return $builder;
        } else {
            return $this->Where(['id_kafe' => $id_kafe])->get();
        }
    }
    function callTolakData($id_kafe = false)
    {
        if ($id_kafe === false) {
            $subquery = $this->db->table('tbl_jam_operasional')
                ->select("json_agg(json_build_object('hari', hari, 'open_time', open_time, 'close_time', close_time))")
                ->where('kafe_id = tbl_kafe.id_kafe')
                ->groupBy('kafe_id')
                ->getCompiledSelect();

            $builder = $this->db->table('tbl_kafe')
                ->select('tbl_kafe.*, tbl_provinsi.nama_provinsi, tbl_kabupaten.nama_kabupaten, tbl_kecamatan.nama_kecamatan, tbl_kelurahan.nama_kelurahan, tbl_status_appv.user, tbl_status_appv.stat_appv, tbl_status_appv.date_updated, users.username')
                ->join('tbl_provinsi', 'tbl_provinsi.id_provinsi = tbl_kafe.id_provinsi')
                ->join('tbl_kabupaten', 'tbl_kabupaten.id_kabupaten = tbl_kafe.id_kabupaten')
                ->join('tbl_kecamatan', 'tbl_kecamatan.id_kecamatan = tbl_kafe.id_kecamatan')
                ->join('tbl_kelurahan', 'tbl_kelurahan.id_kelurahan = tbl_kafe.id_kelurahan')
                ->join('tbl_status_appv', 'tbl_status_appv.id_kafe = tbl_kafe.id_kafe', 'LEFT')
                ->join('users', 'users.id = tbl_status_appv.user', 'LEFT')
                ->groupBy('tbl_kafe.id_kafe, tbl_provinsi.nama_provinsi, tbl_kabupaten.nama_kabupaten, tbl_kecamatan.nama_kecamatan, tbl_kelurahan.nama_kelurahan, tbl_status_appv.user, tbl_status_appv.stat_appv, tbl_status_appv.date_updated, users.username')
                ->select("string_agg(DISTINCT tbl_foto_kafe.nama_file_foto, ',') AS nama_foto")
                ->join('tbl_foto_kafe', 'tbl_foto_kafe.id_kafe = tbl_kafe.id_kafe', 'left', false)
                ->select("($subquery) AS jam_oprasional")
                ->orderBy('id_kafe', 'DESC')
                ->getWhere(['stat_appv' => '2']);

            return $builder;
        } else {
            return $this->Where(['id_kafe' => $id_kafe])->get();
        }
    }

    function userSubmitKafe($userid)
    {
        $subquery = $this->db->table('tbl_jam_operasional')
            ->select("json_agg(json_build_object('hari', hari, 'open_time', open_time, 'close_time', close_time))")
            ->where('kafe_id = tbl_kafe.id_kafe')
            ->groupBy('kafe_id')
            ->getCompiledSelect();

        $builder = $this->db->table('tbl_kafe')
            ->select('tbl_kafe.*, tbl_provinsi.nama_provinsi, tbl_kabupaten.nama_kabupaten, tbl_kecamatan.nama_kecamatan, tbl_kelurahan.nama_kelurahan, tbl_status_appv.user, tbl_status_appv.stat_appv, tbl_status_appv.date_updated')
            ->join('tbl_provinsi', 'tbl_provinsi.id_provinsi = tbl_kafe.id_provinsi')
            ->join('tbl_kabupaten', 'tbl_kabupaten.id_kabupaten = tbl_kafe.id_kabupaten')
            ->join('tbl_kecamatan', 'tbl_kecamatan.id_kecamatan = tbl_kafe.id_kecamatan')
            ->join('tbl_kelurahan', 'tbl_kelurahan.id_kelurahan = tbl_kafe.id_kelurahan')
            ->join('tbl_status_appv', 'tbl_status_appv.id_kafe = tbl_kafe.id_kafe', 'LEFT')
            ->groupBy('tbl_kafe.id_kafe, tbl_provinsi.nama_provinsi, tbl_kabupaten.nama_kabupaten, tbl_kecamatan.nama_kecamatan, tbl_kelurahan.nama_kelurahan, tbl_status_appv.user, tbl_status_appv.stat_appv, tbl_status_appv.date_updated')
            ->select("string_agg(DISTINCT tbl_foto_kafe.nama_file_foto, ',') AS nama_foto")
            ->join('tbl_foto_kafe', 'tbl_foto_kafe.id_kafe = tbl_kafe.id_kafe', 'left', false)
            ->select("($subquery) AS jam_oprasional")
            ->orderBy('id_kafe', 'DESC')
            ->getWhere(['user' => $userid]);

        return $builder;
    }

    function getFiveKafe()
    {
        $buidler = $this->db->table('tbl_kafe')->select('tbl_kafe.id_kafe, nama_kafe, alamat_kafe, latitude, longitude, instagram_kafe, tbl_provinsi.id_provinsi as id_provinsi, nama_provinsi, tbl_kabupaten.id_kabupaten as id_kabupaten, nama_kabupaten, tbl_kecamatan.id_kecamatan as id_kecamatan, nama_kecamatan, tbl_kelurahan.id_kelurahan as id_kelurahan, nama_kelurahan, tbl_kafe.created_at, tbl_kafe.updated_at, tbl_status_appv.stat_appv as stat_appv, tbl_status_appv.user as user, users.username as username')
            ->join('tbl_provinsi', 'tbl_provinsi.id_provinsi = tbl_kafe.id_provinsi', 'LEFT')
            ->join('tbl_kabupaten', 'tbl_kabupaten.id_kabupaten = tbl_kafe.id_kabupaten', 'LEFT')
            ->join('tbl_kecamatan', 'tbl_kecamatan.id_kecamatan = tbl_kafe.id_kecamatan', 'LEFT')
            ->join('tbl_kelurahan', 'tbl_kelurahan.id_kelurahan = tbl_kafe.id_kelurahan', 'LEFT')
            ->join('tbl_status_appv', 'tbl_status_appv.id_kafe = tbl_kafe.id_kafe', 'LEFT')
            ->join('users', 'users.id = tbl_status_appv.user')
            ->limit(5)
            ->orderBy('created_at', 'DESC');
        $query = $buidler->getWhere(['stat_appv' => '1']);
        return $query;
    }

    function cariKafe($keyword)
    {
        return $this->db->table('tbl_kafe')
            ->join('tbl_status_appv', 'tbl_status_appv.id_kafe = tbl_kafe.id_kafe')
            ->Where(['stat_appv' => '1'])
            ->like('nama_kafe', $keyword)
            ->get()
            ->getResult();
    }

    function randomFour()
    {
        return $this->db->table('tbl_kafe')
            ->join('tbl_foto_kafe', 'tbl_foto_kafe.id_kafe = tbl_kafe.id_kafe', 'left', false)
            ->join('tbl_status_appv', 'tbl_status_appv.id_kafe = tbl_kafe.id_kafe')
            ->orderBy('RANDOM()')->limit(4)->getWhere(['stat_appv' => '1']);
    }

    function countAllKafe()
    {
        return $this->db->table('tbl_kafe')
            ->join('tbl_status_appv', 'tbl_status_appv.id_kafe = tbl_kafe.id_kafe')
            ->Where(['stat_appv' => '1'])->countAllResults();
    }

    function countAllPending()
    {
        return $this->db->table('tbl_kafe')
            ->join('tbl_status_appv', 'tbl_status_appv.id_kafe = tbl_kafe.id_kafe')
            ->Where(['stat_appv' => '0'])->countAllResults();
    }

    function addKafe($addKafe)
    {
        return  $this->db->table('tbl_kafe')->insert($addKafe);
    }

    public function updateKafe($data, $id_kafe)
    {
        return $this->db->table('tbl_kafe')->update($data, ['id_kafe' => $id_kafe]);
    }

    function addStatus($addStatus)
    {
        return $this->db->table('tbl_status_appv')->insert($addStatus);
    }
    public function chck_appv($data, $id_kafe)
    {
        return $this->db->table('tbl_status_appv')->update($data, ['id_kafe' => $id_kafe]);
    }

    function addTime($addTime)
    {
        return $this->db->table('tbl_jam_operasional')->insertBatch($addTime);
    }
    public function updateTime($data, $kafe_id, $hari)
    {
        return $this->db->table('tbl_jam_operasional')->update($data, ['kafe_id' => $kafe_id, 'hari' => $hari]);
    }




    // SCRAPING DATA FROM DATABASE FOR SELECT FORM MENU

    // PROVINSI
    public function allProvinsi()
    {
        return $this->db->table('tbl_provinsi')->orderBy('id_provinsi', 'ASC')->get()->getResultArray();
    }
    // KABUPATEN/KOTA
    public function allKabupaten($id_provinsi)
    {
        return $this->db->table('tbl_kabupaten')->where('id_provinsi', $id_provinsi)->get()->getResultArray();
    }
    // KECAMATAN
    public function allKecamatan($id_kecamatan)
    {
        return $this->db->table('tbl_kecamatan')->where('id_kabupaten', $id_kecamatan)->get()->getResultArray();
    }
    // KELURAHAN
    public function allKelurahan($id_kelurahan)
    {
        return $this->db->table('tbl_kelurahan')->where('id_kecamatan', $id_kelurahan)->get()->getResultArray();
    }
    function tes()
    {
        return $this->db->table('test')->get();
    }
}
