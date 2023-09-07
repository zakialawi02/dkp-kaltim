<?php

namespace App\Controllers;

use App\Models\ModelSetting;
use App\Models\ModelUser;
use Myth\Auth\Password;

class User extends BaseController
{
    protected $ModelSetting;
    protected $ModelUser;

    public function __construct()
    {
        $this->setting = new ModelSetting();
        $this->users = new ModelUser();
    }

    public function manajemen()
    {
        $data = [
            'title' => 'USER MANAGEMENT',
            'users' => $this->users->getUsers()->getResult(),
            'auth_groups' => $this->users->allGroup(),
        ];
        return view('admin/userManagement', $data);
    }

    public function list()
    {
        $data = [
            'title' => 'USER LIST',
            'users' => $this->users->getUsers()->getResult(),
        ];
        return view('page/userList', $data);
    }

    public function tambah()
    {
        // dd($this->request->getVar());
        $data = [
            'username' => $this->request->getVar('username'),
            'full_name' => $this->request->getVar('full_name'),
            'email' => $this->request->getVar('email'),
            'password_hash' => Password::hash($this->request->getVar('password_hash')),
            'active' => "1",
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $addUser = $this->users->addUser($data);
        $insert_id = $this->db->insertID();

        $role = $this->request->getVar('role');
        if ($role == "1") {
            $dataA = [
                'group_id' => "1",
                'user_id' => $insert_id,
            ];
        } elseif ($role == "2") {
            $dataA = [
                'group_id' => "2",
                'user_id' => $insert_id,
            ];
        } else {
            $dataA = [
                'group_id' => "3",
                'user_id' => $insert_id,
            ];
        }
        // var_dump($dataA);
        // die;
        $insertUser = $this->users->insertUser($dataA);


        if ($addUser && $insertUser) {
            session()->setFlashdata('success', 'User baru berhasil ditambahkan.');
            return $this->response->redirect(site_url('/user/kelola'));
        } else {
            session()->setFlashdata('error', 'User baru gagal ditambahkan.');
            return $this->response->redirect(site_url('/user/kelola'));
        }
    }

    public function updateUser()
    {
        // dd($this->request->getVar());

        $userid = $this->request->getVar('userid');
        $password = $this->request->getVar('password_hash');
        $data = [
            'id' => $userid,
            'username' => $this->request->getVar('username'),
            'full_name' => $this->request->getVar('full_name'),
            'email' => $this->request->getVar('email'),
            'active' => $this->request->getVar('active'),
        ];

        if (!empty($password)) {
            // Jika password tidak kosong, 
            $pass = [
                'password_hash' => Password::hash($this->request->getVar('password_hash')),
            ];
            $data = $data + $pass;
        } else {
            // Jika password kosong, 
        }

        // var_dump($data);
        // die;
        $updateUser = $this->users->updateUser($data, $userid);

        $role = $this->request->getVar('role');
        if ($role == "1") {
            $dataA = [
                'group_id' => "1",
                'user_id' => $userid,
            ];
        } elseif ($role == "2") {
            $dataA = [
                'group_id' => "2",
                'user_id' => $userid,
            ];
        } else {
            $dataA = [
                'group_id' => "3",
                'user_id' => $userid,
            ];
        }

        $insertUser = $this->users->updateRole($dataA, $userid);

        if ($updateUser && $insertUser) {
            session()->setFlashdata('success', 'Data Berhasil diperbarui.');
            return $this->response->redirect(site_url('/user/kelola'));
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui data.');
            return $this->response->redirect(site_url('/user/kelola'));
        }
    }

    // delete data
    public function delete($id)
    {
        $this->users->deleteRole($id);
        $this->users->deleteUser($id);
        if ($this) {
            session()->setFlashdata('success', 'User berhasil dihapus.');
            return $this->response->redirect(site_url('/user/kelola'));
        } else {
            session()->setFlashdata('error', 'Gagal menghapus user.');
            return $this->response->redirect(site_url('/user/kelola'));
        }
    }
}
