<?php

namespace App\Controllers;

use App\Models\JurusanModel;

class Jurusan extends BaseController
{
    public function index()
    {
        $data['title']      = 'Jurusan';
        $data['group_name'] = $this->auth->getGroupName();
        $data['user_name']  = session()->get('first_name') . ' ' . session()->get('last_name');
        $data['active_menu'] = 'jurusan';

        $model = model('App\Models\JurusanModel');
        $data['jurusan'] = $model->findAll();

        return view('master/jurusan', $data);
    }

    public function create()
    {
        if ($this->request->getMethod() === 'POST') {
            $model = model('App\Models\JurusanModel');
            $model->save([
                'nama_jurusan' => $this->request->getPost('nama_jurusan'),
            ]);
            session()->setFlashdata('success', 'Jurusan berhasil ditambahkan.');
            return redirect()->to('/jurusan');
        }

        $data['title']      = 'Tambah Jurusan';
        $data['group_name'] = $this->auth->getGroupName();
        $data['user_name']  = session()->get('first_name') . ' ' . session()->get('last_name');
        $data['active_menu'] = 'jurusan';
        $data['action']     = '/jurusan/create';

        return view('master/jurusan_form', $data);
    }

    public function update($id)
    {
        $model = model('App\Models\JurusanModel');

        if ($this->request->getMethod() === 'POST') {
            $model->update($id, [
                'nama_jurusan' => $this->request->getPost('nama_jurusan'),
            ]);
            session()->setFlashdata('success', 'Jurusan berhasil diupdate.');
            return redirect()->to('/jurusan');
        }

        $data['title']       = 'Edit Jurusan';
        $data['group_name']  = $this->auth->getGroupName();
        $data['user_name']   = session()->get('first_name') . ' ' . session()->get('last_name');
        $data['active_menu'] = 'jurusan';
        $data['action']      = '/jurusan/update/' . $id;
        $data['row']         = $model->find($id);

        return view('master/jurusan_form', $data);
    }

    public function delete($id)
    {
        $model = model('App\Models\JurusanModel');
        $model->delete($id);
        session()->setFlashdata('success', 'Jurusan berhasil dihapus.');
        return redirect()->to('/jurusan');
    }
}