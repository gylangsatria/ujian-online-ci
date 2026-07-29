<?php

namespace App\Controllers;

class Settings extends BaseController
{
    public function index()
    {
        if (!$this->auth->isAdmin()) {
            return redirect()->to('dashboard');
        }

        $data = [
            'title' => 'Settings',
            'user'  => $this->auth->user(),
        ];

        return view('settings', $data);
    }

    public function update_password()
    {
        $id = $this->auth->user()->id;
        
        $rules = [
            'old_password'     => 'required',
            'new_password'     => 'required|min_length[8]',
            'confirm_password' => 'required|matches[new_password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = $this->db->table('users')->where('id', $id)->get()->getRow();

        if (!password_verify($this->request->getPost('old_password'), $user->password)) {
            return redirect()->back()->with('error', 'Old password incorrect');
        }

        $this->db->table('users')->where('id', $id)->update([
            'password' => password_hash($this->request->getPost('new_password'), PASSWORD_BCRYPT)
        ]);

        return redirect()->to('settings')->with('message', 'Password updated successfully');
    }
}