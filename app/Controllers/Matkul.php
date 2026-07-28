<?php

namespace App\Controllers;

use App\Models\MatkulModel;

class Matkul extends BaseController
{
    public function index()
    {
        $data['title']       = 'Mata Kuliah';
        $data['group_name']  = $this->auth->getGroupName();
        $data['user_name']   = session()->get('first_name') . ' ' . session()->get('last_name');
        $data['active_menu'] = 'matkul';

        $model = model('App\Models\MatkulModel');
        $data['matkul'] = $model->findAll();

        return view('master/matkul', $data);
    }

    public function create()
    {
        if ($this->request->getMethod() === 'POST') {
            $model = model('App\Models\MatkulModel');
            $model->save([
                'nama_matkul' => $this->request->getPost('nama_matkul'),
            ]);
            session()->setFlashdata('success', 'Matkul berhasil ditambahkan.');
            return redirect()->to('/matkul');
        }

        $data['title']       = 'Tambah Matkul';
        $data['group_name']  = $this->auth->getGroupName();
        $data['user_name']   = session()->get('first_name') . ' ' . session()->get('last_name');
        $data['active_menu'] = 'matkul';
        $data['action']      = '/matkul/create';

        return view('master/matkul_form', $data);
    }

    public function update($id)
    {
        $model = model('App\Models\MatkulModel');

        if ($this->request->getMethod() === 'POST') {
            $model->update($id, [
                'nama_matkul' => $this->request->getPost('nama_matkul'),
            ]);
            session()->setFlashdata('success', 'Matkul berhasil diupdate.');
            return redirect()->to('/matkul');
        }

        $data['title']       = 'Edit Matkul';
        $data['group_name']  = $this->auth->getGroupName();
        $data['user_name']   = session()->get('first_name') . ' ' . session()->get('last_name');
        $data['active_menu'] = 'matkul';
        $data['action']      = '/matkul/update/' . $id;
        $data['row']         = $model->find($id);

        return view('master/matkul_form', $data);
    }

    public function delete($id)
    {
        $model = model('App\Models\MatkulModel');
        $model->delete($id);
        session()->setFlashdata('success', 'Matkul berhasil dihapus.');
        return redirect()->to('/matkul');
    }
}