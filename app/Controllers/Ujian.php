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
        $group = $this->auth->getGroupName();
        $ujian = ($group === 'dosen')
            ? $this->ujianModel->where('m_ujian.dosen_id', session()->get('dosen_id'))->getUjian()
            : $this->ujianModel->getUjian();

        $data = [
            'title' => 'Jadwal Ujian',
            'ujian' => $ujian
        ];
        return view('ujian/index', $data);
    }

    public function add()
    {
        $isDosen = $this->auth->isDosen();
        $dosen_id = session()->get('dosen_id');

        if ($isDosen) {
            $dosen = $this->dosenModel->find($dosen_id);
            $matkul = $dosen ? $this->matkulModel->where('id_matkul', $dosen->matkul_id)->findAll() : [];
            $dosen_list = $dosen ? [$dosen] : [];
        } else {
            $matkul = $this->matkulModel->findAll();
            $dosen_list = $this->dosenModel->findAll();
        }

        $data = [
            'title'  => 'Tambah Ujian',
            'matkul' => $matkul,
            'dosen'  => $dosen_list,
            'token'  => strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 5))
        ];
        return view('ujian/add', $data);
    }

    public function edit($id)
    {
        $ujian = $this->ujianModel->find($id);
        if (!$ujian) {
            return redirect()->to('ujian')->with('error', 'Not found');
        }

        // PENGAMAN: Dosen hanya bisa edit miliknya sendiri
        if ($this->auth->isDosen() && $ujian->dosen_id != session()->get('dosen_id')) {
            return redirect()->to('ujian')->with('error', 'Tidak punya akses ke jadwal dosen lain.');
        }

        $isDosen = $this->auth->isDosen();
        if ($isDosen) {
            $dosen = $this->dosenModel->find(session()->get('dosen_id'));
            $matkul = $dosen ? $this->matkulModel->where('id_matkul', $dosen->matkul_id)->findAll() : [];
            $dosen_list = $dosen ? [$dosen] : [];
        } else {
            $matkul = $this->matkulModel->findAll();
            $dosen_list = $this->dosenModel->findAll();
        }

        $data = [
            'title'  => 'Edit Ujian',
            'ujian'  => $ujian,
            'matkul' => $matkul,
            'dosen'  => $dosen_list,
        ];
        return view('ujian/edit', $data);
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

        $id = $this->request->getPost('id_ujian');
        if ($id) {
            $ujian = $this->ujianModel->find($id);
            if (!$ujian) {
                return redirect()->to('ujian')->with('error', 'Not found');
            }
            // PENGAMAN: Dosen hanya bisa update miliknya sendiri
            if ($this->auth->isDosen() && $ujian->dosen_id != session()->get('dosen_id')) {
                return redirect()->to('ujian')->with('error', 'Tidak punya akses ke jadwal dosen lain.');
            }
        }

        $dosen_id = $this->auth->isDosen() 
            ? session()->get('dosen_id') 
            : $this->request->getPost('dosen_id');

        $data = [
            'dosen_id'    => $dosen_id,
            'matkul_id'   => $this->request->getPost('matkul_id'),
            'nama_ujian'  => $this->request->getPost('nama_ujian'),
            'jumlah_soal' => $this->request->getPost('jumlah_soal'),
            'tgl_mulai'   => $this->request->getPost('tgl_mulai'),
            'terlambat'   => $this->request->getPost('terlambat'),
            'waktu'       => $this->request->getPost('waktu'),
            'jenis'       => $this->request->getPost('jenis'),
            'token'       => $this->request->getPost('token'),
        ];

        if ($id) {
            $this->ujianModel->update($id, $data);
        } else {
            $this->ujianModel->save($data);
        }
        
        return redirect()->to('ujian')->with('success', 'Data berhasil disimpan');
    }

    public function token($id)
    {
        $ujian = $this->ujianModel->find($id);
        if (!$ujian) {
            return json_encode(['error' => 'Not found']);
        }

        // PENGAMAN: Dosen hanya bisa refresh token miliknya sendiri
        if ($this->auth->isDosen() && $ujian->dosen_id != session()->get('dosen_id')) {
            return json_encode(['error' => 'Forbidden']);
        }

        $token = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 5));
        $this->ujianModel->update($id, ['token' => $token]);
        return json_encode(['token' => $token]);
    }

    public function delete($id)
    {
        $ujian = $this->ujianModel->find($id);
        if (!$ujian) {
            return redirect()->to('ujian')->with('error', 'Not found');
        }

        // PENGAMAN: Dosen hanya bisa hapus miliknya sendiri
        if ($this->auth->isDosen() && $ujian->dosen_id != session()->get('dosen_id')) {
            return redirect()->to('ujian')->with('error', 'Tidak punya akses ke jadwal dosen lain.');
        }

        $this->ujianModel->delete($id);
        return redirect()->to('ujian')->with('success', 'Data berhasil dihapus');
    }
}