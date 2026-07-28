<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Users extends BaseController
{
    protected $usersModel;

    public function __construct()
    {
        $this->usersModel = new UsersModel();
    }

    public function index()
    {
        if (!$this->auth->is_admin()) {
            return redirect()->to('dashboard');
        }

        $data = [
            'title' => 'Users Management',
            'user'  => $this->auth->user(),
            'users' => $this->usersModel->select('users.*, groups.name as group_name')
                ->join('users_groups', 'users_groups.user_id = users.id')
                ->join('groups', 'groups.id = users_groups.group_id')
                ->findAll()
        ];

        return view('users/index', $data);
    }

    public function edit($id)
    {
        if (!$this->auth->is_admin()) {
            return redirect()->to('dashboard');
        }

        $user = $this->usersModel->find($id);
        if (!$user) {
            return redirect()->to('users')->with('error', 'User not found');
        }

        $data = [
            'title' => 'Edit User',
            'user'  => $this->auth->user(),
            'data'  => $user,
            'groups' => $this->db->table('groups')->get()->getResult()
        ];

        return view('users/edit', $data);
    }

    public function update()
    {
        if (!$this->auth->is_admin()) {
            return redirect()->to('dashboard');
        }

        $id = $this->request->getPost('id');
        $rules = [
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => "required|valid_email|is_unique[users.email,id,{$id}]",
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[8]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'email'      => $this->request->getPost('email'),
            'phone'      => $this->request->getPost('phone'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_BCRYPT);
        }

        $this->usersModel->update($id, $data);

        return redirect()->to('users')->with('message', 'User updated successfully');
    }

    public function delete($id)
    {
        if (!$this->auth->is_admin()) {
            return redirect()->to('dashboard');
        }

        if ($this->auth->user()->id == $id) {
            return redirect()->to('users')->with('error', 'Cannot delete your own account');
        }

        $this->usersModel->delete($id);
        return redirect()->to('users')->with('message', 'User deleted successfully');
    }

    public function activate($id)
    {
        if (!$this->auth->is_admin()) {
            return redirect()->to('dashboard');
        }

        $this->usersModel->update($id, ['active' => 1]);
        return redirect()->to('users')->with('message', 'User activated');
    }

    public function deactivate($id)
    {
        if (!$this->auth->is_admin()) {
            return redirect()->to('dashboard');
        }

        if ($this->auth->user()->id == $id) {
            return redirect()->to('users')->with('error', 'Cannot deactivate your own account');
        }

        $this->usersModel->update($id, ['active' => 0]);
        return redirect()->to('users')->with('message', 'User deactivated');
    }
}