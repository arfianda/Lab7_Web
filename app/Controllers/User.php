<?php

namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
    public function index()
    {
        $title = 'Daftar User';
        $model = new UserModel();
        $users = $model->findAll();

        return view('user/index', compact('users', 'title'));
    }

    public function login()
    {
        helper(['form']);

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (!$email) {
            return view('user/login', ['title' => 'Login']);
        }

        $session = session();
        $model = new UserModel();
        $login = $model->where('useremail', $email)->first();

        if (!$login) {
            $session->setFlashdata('flash_msg', 'Email tidak terdaftar.');
            return redirect()->to('/user/login');
        }

        if (!password_verify((string) $password, $login['userpassword'])) {
            $session->setFlashdata('flash_msg', 'Password salah.');
            return redirect()->to('/user/login');
        }

        $loginData = [
            'user_id' => $login['id'],
            'user_name' => $login['username'],
            'user_email' => $login['useremail'],
            'logged_in' => true,
        ];

        $session->set($loginData);

        return redirect()->to('/admin/artikel');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/user/login');
    }
}
