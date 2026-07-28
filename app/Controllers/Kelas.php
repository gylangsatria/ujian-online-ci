<?php

namespace App\Controllers;

use App\Models\KelasModel;
use App\Models\JurusanModel;

class Kelas extends BaseController
{
    public function index()
    {
        $data['title']       = 'Kelas';
        $data['group_name']  = $this->auth->getGroupName();
        $data['user_name']   = session()->get('first_name') . ' ' . session()->get('last_name');
        $data['active_menu'] = 'kelas';

        $model = model('App\Models\KelasModel');
        $data['kelas'] = $model->select('kelas.*, jurusan.nama_jurusan')
            ->join('jurusan', 'jurusan.id_jurusan = kelas.jurusan_id')
            ->findAll();

        return view('master/kelas', $data);
    }

    public function create()
    {
        $data['title']        = 'Tambah Kelas';
        $data['group_name']   = $this->auth->getGroupName();
        $data['user_name']    = session()->get('first_name') . ' ' . session()->get('last_name');
        $data['active_menu']  = 'kelas';
        $data['action']       = '/kelas/create';
        $data['jurusan_list'] = model('App\Models\JurusanModel')->findAll();

        if ($this->request->getMethod() === 'POST') {
            $model = model('App\Models\KelasModel');
            $model->save([
                'nama_kelas' => $this->request->getPost('nama_kelas'),
                'jurusan_id' => $this->request->getPost('jurusan_id'),
            ]);
            session()->setFlashdata('success', 'Kelas berhasil ditambahkan.');
            return redirect()->to('/kelas');
        }

        return view('master/kelas_form', $data);
    }

    public function update($id)
    {
        $model = model('App\Models\KelasModel');
        $data['title']        = 'Edit Kelas';
        $data['group_name']   = $this->auth->getGroupName();
        $data['user_name']    = session()->get('first_name') . ' ' . session()->get('last_name');
        $data['active_menu']  = 'kelas';
        $data['action']       = '/kelas/update/' . $id;
        $data['jurusan_list'] = model('App\Models\JurusanModel')->findAll();

        if ($this->request->getMethod() === 'POST') {
            $model->update($id, [
                'nama_kelas' => $this->request->getPost('nama_kelas'),
                'jurusan_id' => $this->request->getPost('jurusan_id'),
            ]);
            session()->setFlashdata('success', 'Kelas berhasil diupdate.');
            return redirect()->to('/kelas');
        }

        $data['row'] = $model->find($id);
        return view('master/kelas_form', $data);
    }

    public function delete($id)
    {
        $model = model('App\Models\KelasModel');
        $model->delete($id);
        session()->setFlashdata('success', 'Kelas berhasil dihapus.');
        return redirect()->to('/kelas');
    }
}