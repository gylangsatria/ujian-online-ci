<?php

namespace App\Controllers;

use App\Models\KelasDosenModel;
use App\Models\KelasModel;
use App\Models\DosenModel;

class KelasDosen extends BaseController
{
    public function index()
    {
        $data['title']       = 'Kelas - Dosen';
        $data['group_name']  = $this->auth->getGroupName();
        $data['user_name']   = session()->get('first_name') . ' ' . session()->get('last_name');
        $data['active_menu'] = 'kelas-dosen';

        $model = model('App\Models\KelasDosenModel');
        $data['relasi'] = $model->select('kelas_dosen.*, kelas.nama_kelas, dosen.nama_dosen')
            ->join('kelas', 'kelas.id_kelas = kelas_dosen.kelas_id')
            ->join('dosen', 'dosen.id_dosen = kelas_dosen.dosen_id')
            ->findAll();

        return view('master/kelas_dosen', $data);
    }

    public function create()
    {
        $data['title']       = 'Tambah Relasi Kelas-Dosen';
        $data['group_name']  = $this->auth->getGroupName();
        $data['user_name']   = session()->get('first_name') . ' ' . session()->get('last_name');
        $data['active_menu'] = 'kelas-dosen';
        $data['action']      = '/kelas-dosen/create';
        $data['kelas_list']  = model('App\Models\KelasModel')
            ->select('kelas.*, jurusan.nama_jurusan')
            ->join('jurusan', 'jurusan.id_jurusan = kelas.jurusan_id')
            ->findAll();
        $data['dosen_list']  = model('App\Models\DosenModel')
            ->select('dosen.*, matkul.nama_matkul')
            ->join('matkul', 'matkul.id_matkul = dosen.matkul_id')
            ->findAll();

        if ($this->request->getMethod() === 'POST') {
            $model = model('App\Models\KelasDosenModel');
            $model->save([
                'kelas_id' => $this->request->getPost('kelas_id'),
                'dosen_id' => $this->request->getPost('dosen_id'),
            ]);
            session()->setFlashdata('success', 'Relasi berhasil ditambahkan.');
            return redirect()->to('/kelas-dosen');
        }

        return view('master/kelas_dosen_form', $data);
    }

    public function delete($id)
    {
        $model = model('App\Models\KelasDosenModel');
        $model->delete($id);
        session()->setFlashdata('success', 'Relasi berhasil dihapus.');
        return redirect()->to('/kelas-dosen');
    }
}