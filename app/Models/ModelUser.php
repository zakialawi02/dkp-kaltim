<?php

namespace App\Models;

use CodeIgniter\Model;


class ModelUser extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['full_name', 'user_image', 'email', 'user_about', 'password_hash', 'active'];

    function __construct()
    {
        $this->db = db_connect();
    }


    function getUsers($id = false)
    {
        if ($id == false) {
            $db      = \Config\Database::connect();
            $builder = $db->table('users');
            $builder->select('users.id as userid, username, email, active, group_id, name, created_at,  full_name, user_about, user_image');
            $builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
            $builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
            $query = $builder->orderBy('group_id', 'ASC')->get();
            return $query;
        } else {
            $db      = \Config\Database::connect();
            $builder = $db->table('users');
            $builder->select('users.id as userid, username, email, active, group_id, name, created_at,  full_name, user_about, user_image, password_hash');
            $builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
            $builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
            $query = $builder->Where(['users.id' => $id])->get();
            return $query;
        }
    }

    public function verifPass($id)
    {
        $builder = $this->db->table('users')->select('*');
        $query = $builder->Where(['id' => $id])->get();
        return $query;
    }

    public function UpdatePassword($data, $id)
    {
        return $this->db->table('users')->update($data, ['id' => $id]);
    }

    function addUser($addUser)
    {
        return $this->db->table('users')->insert($addUser);
    }

    function insertUser($insertUser)
    {
        return $this->db->table('auth_groups_users')->insert($insertUser);
    }

    public function updateUser($data, $userid)
    {
        return $this->db->table('users')->update($data, ['id' => $userid]);
    }

    public function updateRole($dataA, $userid)
    {
        return $this->db->table('auth_groups_users')->update($dataA, ['user_id' => $userid]);
    }

    public function deleteUser($id)
    {
        return $this->db->table('users')->delete(['id' => $id]);
    }
    public function deleteRole($id)
    {
        return $this->db->table('auth_groups_users')->delete(['user_id' => $id]);
    }

    function userMonth()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->select('users.id as userid, username, email, group_id, name, created_at,  full_name');
        $builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $query = $builder->where("created_at BETWEEN CURRENT_TIMESTAMP - INTERVAL '30 day' AND CURRENT_TIMESTAMP")->orderBy('created_at', 'DESC')->limit(5)->get();

        return $query;
    }

    function countAllUser()
    {
        return $this->db->table('users')->countAll();
    }



    // SCRAPING DATA FROM DATABASE FOR SELECT FORM MENU
    // AUTH GROUP
    public function allGroup()
    {
        return $this->db->table('auth_groups')->orderBy('id', 'ASC')->get()->getResultArray();
    }
}
