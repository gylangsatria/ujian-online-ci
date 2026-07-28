<?php

namespace App\Controllers;

use App\Models\JurusanMatkulModel;
use App\Models\JurusanModel;
use App\Models\MatkulModel;

class JurusanMatkul extends BaseController
{
    public function index()
    {
        $data['title']       = 'Jurusan - Matkul';
        $data['group_name']  = $this->auth->getGroupName();
        $data['user_name']   = session()->get('first_name') . ' ' . session()->get('last_name');
        $data['active_menu'] = 'jurusan-matkul';

        $model = model('App\Models\JurusanMatkulModel');
        $data['relasi'] = $model->select('jurusan_matkul.*, jurusan.nama_jurusan, matkul.nama_matkul')
            ->join('jurusan', 'jurusan.id_jurusan = jurusan_matkul.jurusan_id')
            ->join('matkul', 'matkul.id_matkul = jurusan_matkul.matkul_id')
            ->findAll();

        return view('master/jurusan_matkul', $data);
    }

    public function create()
    {
        $data['title']        = 'Tambah Relasi Jurusan-Matkul';
        $data['group_name']   = $this->auth->getGroupName();
        $data['user_name']    = session()->get('first_name') . ' ' . session()->get('last_name');
        $data['active_menu']  = 'jurusan-matkul';
        $data['action']       = '/jurusan-matkul/create';
        $data['jurusan_list'] = model('App\Models\JurusanModel')->findAll();
        $data['matkul_list']  = model('App\Models\MatkulModel')->findAll();

        if ($this->request->getMethod() === 'POST') {
            $model = model('App\Models\JurusanMatkulModel');
            $model->save([
                'jurusan_id' => $this->request->getPost('jurusan_id'),
                'matkul_id'  => $this->request->getPost('matkul_id'),
            ]);
            session()->setFlashdata('success', 'Relasi berhasil ditambahkan.');
            return redirect()->to('/jurusan-matkul');
        }

        return view('master/jurusan_matkul_form', $data);
    }

    public function delete($id)
    {
        $model = model('App\Models\JurusanMatkulModel');
        $model->delete($id);
        session()->setFlashdata('success', 'Relasi berhasil dihapus.');
        return redirect()->to('/jurusan-matkul');
    }
}