<?php

namespace App\Controllers;

use App\Models\MahasiswaModel;
use App\Models\KelasModel;

class Mahasiswa extends BaseController
{
    public function index()
    {
        $data['title']       = 'Mahasiswa';
        $data['group_name']  = $this->auth->getGroupName();
        $data['user_name']   = session()->get('first_name') . ' ' . session()->get('last_name');
        $data['active_menu'] = 'mahasiswa';

        $model = model('App\Models\MahasiswaModel');
        $data['mahasiswa'] = $model->select('mahasiswa.*, kelas.nama_kelas, jurusan.nama_jurusan')
            ->join('kelas', 'kelas.id_kelas = mahasiswa.kelas_id')
            ->join('jurusan', 'jurusan.id_jurusan = kelas.jurusan_id')
            ->findAll();

        return view('master/mahasiswa', $data);
    }

    public function create()
    {
        $data['title']       = 'Tambah Mahasiswa';
        $data['group_name']  = $this->auth->getGroupName();
        $data['user_name']   = session()->get('first_name') . ' ' . session()->get('last_name');
        $data['active_menu'] = 'mahasiswa';
        $data['action']      = '/mahasiswa/create';
        $data['kelas_list']  = model('App\Models\KelasModel')
            ->select('kelas.*, jurusan.nama_jurusan')
            ->join('jurusan', 'jurusan.id_jurusan = kelas.jurusan_id')
            ->findAll();

        if ($this->request->getMethod() === 'POST') {
            $model = model('App\Models\MahasiswaModel');
            $model->save([
                'nama'          => $this->request->getPost('nama'),
                'nim'           => $this->request->getPost('nim'),
                'email'         => $this->request->getPost('email'),
                'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                'kelas_id'      => $this->request->getPost('kelas_id'),
            ]);
            session()->setFlashdata('success', 'Mahasiswa berhasil ditambahkan.');
            return redirect()->to('/mahasiswa');
        }

        return view('master/mahasiswa_form', $data);
    }

    public function update($id)
    {
        $model = model('App\Models\MahasiswaModel');
        $data['title']       = 'Edit Mahasiswa';
        $data['group_name']  = $this->auth->getGroupName();
        $data['user_name']   = session()->get('first_name') . ' ' . session()->get('last_name');
        $data['active_menu'] = 'mahasiswa';
        $data['action']      = '/mahasiswa/update/' . $id;
        $data['kelas_list']  = model('App\Models\KelasModel')
            ->select('kelas.*, jurusan.nama_jurusan')
            ->join('jurusan', 'jurusan.id_jurusan = kelas.jurusan_id')
            ->findAll();

        if ($this->request->getMethod() === 'POST') {
            $model->update($id, [
                'nama'          => $this->request->getPost('nama'),
                'nim'           => $this->request->getPost('nim'),
                'email'         => $this->request->getPost('email'),
                'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                'kelas_id'      => $this->request->getPost('kelas_id'),
            ]);
            session()->setFlashdata('success', 'Mahasiswa berhasil diupdate.');
            return redirect()->to('/mahasiswa');
        }

        $data['row'] = $model->find($id);
        return view('master/mahasiswa_form', $data);
    }

    public function delete($id)
    {
        $model = model('App\Models\MahasiswaModel');
        $model->delete($id);
        session()->setFlashdata('success', 'Mahasiswa berhasil dihapus.');
        return redirect()->to('/mahasiswa');
    }
}