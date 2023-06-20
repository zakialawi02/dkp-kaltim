<?php

namespace App\Controllers;

use App\Models\ModelSetting;
use App\Models\ModelUser;
use Myth\Auth\Password;

class MyProfile extends BaseController
{
    protected $ModelSetting;
    protected $ModelUser;

    public function __construct()
    {
        $this->setting = new ModelSetting();
        $this->users = new ModelUser();
    }

    public function index()
    {
        $data = [
            'title' => 'My Profile',
        ];
        $db      = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->select('users.id as userid, username, email, name, password_hash');
        $builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $query = $builder->get();

        $data['users'] = $query->getResult();
        // $data['validation'] = \Config\Services::validation();;
        return view('page/myProfile', $data);
    }


    public function UpdateMyData()
    {
        $id = $this->request->getPost('id');
        $data = [
            'full_name' => $this->request->getVar('full_name'),
            'user_about' => $this->request->getPost('user_about'),
        ];

        $this->setting->updateMyData($data, $id);

        $response = [
            'status' => 'success',
            'message' => 'Data updated successfully',
            'user' => $data
        ];

        return $this->response->setJSON($response);
    }

    public function updatedUserData()
    {
        $id = $this->request->getPost('id');
        $user = $this->users->getUsers($id)->getRow();

        return json_encode($user);
    }

    public function updatePassword()
    {
        $id = $this->request->getPost('id');
        $currentPassword = $this->request->getVar('currentPassword');
        $newPassword = $this->request->getVar('newPassword');
        $renewPassword = $this->request->getVar('renewPassword');

        // $user = $this->users->verifPass($id)->getRow();
        // $hashed = $user->password_hash;

        // if (!password_verify($currentPassword, $hashed)) {
        //     $response = [
        //         'status' => 'error',
        //         'message' => 'Incorrect current password.'
        //     ];
        //     return $this->response->setJSON($response);
        // }
        if ($newPassword != $renewPassword) {
            $response = [
                'status' => 'error',
                'message' => 'New password does not match re-entered password.'
            ];
            return $this->response->setJSON($response);
        }

        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

        $data = [
            'id' => $id,
            'password_hash' => $newPasswordHash
        ];
        $this->users->UpdatePassword($data, $id);

        $response = [
            'status' => 'success',
            'message' => 'Password updated successfully.'
        ];
        return $this->response->setJSON($response);
    }
}
