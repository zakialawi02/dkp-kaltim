<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelKv;
use App\Models\ModelGeojson;
use CodeIgniter\RESTful\ResourceController;

class Api extends ResourceController
{
    protected $format = 'json';
    protected $ModelKv;
    protected $ModelGeojson;
    public function __construct()
    {
        $this->kafe = new ModelKv();
        $this->FGeojson = new ModelGeojson();
    }

    public function aprv()
    {
        $dataKafe = $this->kafe->callKafe()->getResult();

        $feature = [];
        foreach ($dataKafe as $row) {
            $feature[] = [
                'type' => 'Feature',
                'properties' => [
                    'id_kafe' => $row->id_kafe,
                    'nama_kafe' => $row->nama_kafe,
                    'longitude' => $row->longitude,
                    'latitude' => $row->latitude,
                    'alamat_kafe' => $row->alamat_kafe,
                    'instagram_kafe' => $row->instagram_kafe,
                    'id_provinsi' => $row->id_provinsi,
                    'nama_provinsi' => $row->nama_provinsi,
                    'id_kabupaten' => $row->id_kabupaten,
                    'nama_kabupaten' => $row->nama_kabupaten,
                    'id_kecamatan' => $row->id_kecamatan,
                    'nama_kecamatan' => $row->nama_kecamatan,
                    'id_kelurahan' => $row->id_kelurahan,
                    'nama_kelurahan' => $row->nama_kelurahan,
                    'created_at' => $row->created_at,
                    'updated_at' => $row->updated_at,
                    'user' => $row->user,
                    'stat_appv' => $row->stat_appv,
                    'nama_foto' => ["$row->nama_foto"],
                    'jam_oprasional' => [$row->jam_oprasional],
                ],
                'geometry' => [
                    'coordinates' => [
                        $row->longitude,
                        $row->latitude
                    ],
                    'type' => 'Point',
                ],
            ];

            $geojson = [
                'type' => 'FeatureCollection',
                'features' => $feature,
            ];
        }
        // return print_r($dataKafe);
        return $this->respond($geojson);
    }

    public function submit($userid)
    {
        $dataKafe = $this->kafe->userSubmitKafe($userid)->getResult();

        $feature = [];
        foreach ($dataKafe as $row) {
            $feature[] = [
                'type' => 'Feature',
                'properties' => [
                    'id_kafe' => $row->id_kafe,
                    'nama_kafe' => $row->nama_kafe,
                    'longitude' => $row->longitude,
                    'latitude' => $row->latitude,
                    'alamat_kafe' => $row->alamat_kafe,
                    'instagram_kafe' => $row->instagram_kafe,
                    'id_provinsi' => $row->id_provinsi,
                    'nama_provinsi' => $row->nama_provinsi,
                    'id_kabupaten' => $row->id_kabupaten,
                    'nama_kabupaten' => $row->nama_kabupaten,
                    'id_kecamatan' => $row->id_kecamatan,
                    'nama_kecamatan' => $row->nama_kecamatan,
                    'id_kelurahan' => $row->id_kelurahan,
                    'nama_kelurahan' => $row->nama_kelurahan,
                    'created_at' => $row->created_at,
                    'updated_at' => $row->updated_at,
                    'user' => $row->user,
                    'stat_appv' => $row->stat_appv,
                    'nama_foto' => ["$row->nama_foto"],
                    'jam_oprasional' => [$row->jam_oprasional],
                ],
                'geometry' => [
                    'coordinates' => [
                        $row->longitude,
                        $row->latitude
                    ],
                    'type' => 'Point',
                ],
            ];

            $geojson = [
                'type' => 'FeatureCollection',
                'features' => $feature,
            ];
        }
        // return print_r($dataKafe);
        return $this->respond($geojson);
    }
}
