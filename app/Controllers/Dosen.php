<?php

namespace App\Controllers;

use App\Models\DosenModel;
use App\Models\MatkulModel;

class Dosen extends BaseController
{
    public function index()
    {
        $data['title']       = 'Dosen';
        $data['group_name']  = $this->auth->getGroupName();
        $data['user_name']   = session()->get('first_name') . ' ' . session()->get('last_name');
        $data['active_menu'] = 'dosen';

        $model = model('App\Models\DosenModel');
        $data['dosen'] = $model->select('dosen.*, matkul.nama_matkul')
            ->join('matkul', 'matkul.id_matkul = dosen.matkul_id')
            ->findAll();

        return view('master/dosen', $data);
    }

    public function create()
    {
        $data['title']       = 'Tambah Dosen';
        $data['group_name']  = $this->auth->getGroupName();
        $data['user_name']   = session()->get('first_name') . ' ' . session()->get('last_name');
        $data['active_menu'] = 'dosen';
        $data['action']      = '/dosen/create';
        $data['matkul_list'] = model('App\Models\MatkulModel')->findAll();

        if ($this->request->getMethod() === 'POST') {
            $model = model('App\Models\DosenModel');
            $model->save([
                'nip'        => $this->request->getPost('nip'),
                'nama_dosen' => $this->request->getPost('nama_dosen'),
                'email'      => $this->request->getPost('email'),
                'matkul_id'  => $this->request->getPost('matkul_id'),
            ]);
            session()->setFlashdata('success', 'Dosen berhasil ditambahkan.');
            return redirect()->to('/dosen');
        }

        return view('master/dosen_form', $data);
    }

    public function update($id)
    {
        $model = model('App\Models\DosenModel');
        $data['title']       = 'Edit Dosen';
        $data['group_name']  = $this->auth->getGroupName();
        $data['user_name']   = session()->get('first_name') . ' ' . session()->get('last_name');
        $data['active_menu'] = 'dosen';
        $data['action']      = '/dosen/update/' . $id;
        $data['matkul_list'] = model('App\Models\MatkulModel')->findAll();

        if ($this->request->getMethod() === 'POST') {
            $model->update($id, [
                'nip'        => $this->request->getPost('nip'),
                'nama_dosen' => $this->request->getPost('nama_dosen'),
                'email'      => $this->request->getPost('email'),
                'matkul_id'  => $this->request->getPost('matkul_id'),
            ]);
            session()->setFlashdata('success', 'Dosen berhasil diupdate.');
            return redirect()->to('/dosen');
        }

        $data['row'] = $model->find($id);
        return view('master/dosen_form', $data);
    }

    public function delete($id)
    {
        $model = model('App\Models\DosenModel');
        $model->delete($id);
        session()->setFlashdata('success', 'Dosen berhasil dihapus.');
        return redirect()->to('/dosen');
    }
}