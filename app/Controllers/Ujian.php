<?php

namespace App\Controllers;

use App\Models\UjianModel;
use App\Models\MatkulModel;
use App\Models\DosenModel;

class Ujian extends BaseController
{
    protected $ujianModel;
    protected $matkulModel;
    protected $dosenModel;

    public function __construct()
    {
        $this->ujianModel = new UjianModel();
        $this->matkulModel = new MatkulModel();
        $this->dosenModel = new DosenModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Jadwal Ujian',
            'ujian' => $this->ujianModel->getUjian()
        ];
        return view('ujian/index', $data);
    }

    public function add()
    {
        $data = [
            'title'  => 'Tambah Ujian',
            'matkul' => $this->matkulModel->findAll(),
            'dosen'  => $this->dosenModel->findAll(),
            'token'  => strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 5))
        ];
        return view('ujian/add', $data);
    }

    public function save()
    {
        $rules = [
            'nama_ujian'  => 'required',
            'jumlah_soal' => 'required|numeric',
            'tgl_mulai'   => 'required',
            'terlambat'   => 'required',
            'waktu'       => 'required|numeric',
            'jenis'       => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'dosen_id'    => $this->request->getPost('dosen_id'),
            'matkul_id'   => $this->request->getPost('matkul_id'),
            'nama_ujian'  => $this->request->getPost('nama_ujian'),
            'jumlah_soal' => $this->request->getPost('jumlah_soal'),
            'tgl_mulai'   => $this->request->getPost('tgl_mulai'),
            'terlambat'   => $this->request->getPost('terlambat'),
            'waktu'       => $this->request->getPost('waktu'),
            'jenis'       => $this->request->getPost('jenis'),
            'token'       => $this->request->getPost('token'),
        ];

        $this->ujianModel->save($data);
        return redirect()->to('ujian')->with('success', 'Data berhasil disimpan');
    }

    public function token($id)
    {
        $token = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 5));
        $this->ujianModel->update($id, ['token' => $token]);
        return json_encode(['token' => $token]);
    }

    public function delete($id)
    {
        $this->ujianModel->delete($id);
        return redirect()->to('ujian')->with('success', 'Data berhasil dihapus');
    }
}