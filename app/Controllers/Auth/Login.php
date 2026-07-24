<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Libraries\Auth;

class Login extends BaseController
{
    protected $auth;

    public function __construct()
    {
        $this->auth = new Auth();
    }

    public function index()
    {
        // Redirect if already logged in
        if ($this->auth->isLoggedIn()) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    public function process()
    {
        $identity = $this->request->getPost('identity');
        $password = $this->request->getPost('password');

        if (!$identity || !$password) {
            return redirect()->back()->with('error', 'Username/Email dan password wajib diisi.');
        }

        if ($this->auth->login($identity, $password)) {
            return redirect()->to('/dashboard');
        }

        return redirect()->back()->with('error', 'Login gagal. Periksa username/email dan password.');
    }

    public function logout()
    {
        $this->auth->logout();
        return redirect()->to('/login');
    }
}