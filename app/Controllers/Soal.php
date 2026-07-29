<?php

namespace App\Controllers;

use App\Models\SoalModel;
use App\Models\MatkulModel;
use App\Models\DosenModel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Soal extends BaseController
{
    public function index()
    {
        $data['title']       = 'Bank Soal';
        $data['group_name']  = $this->auth->getGroupName();
        $data['user_name']   = session()->get('first_name') . ' ' . session()->get('last_name');
        $data['active_menu'] = 'soal';

        $model = model('App\Models\SoalModel');

        if ($this->auth->isDosen()) {
            $dosen_id = session()->get('dosen_id');
            $data['soal'] = $model->select('tb_soal.*, matkul.nama_matkul')
                ->join('matkul', 'tb_soal.matkul_id = matkul.id_matkul', 'left')
                ->where('tb_soal.dosen_id', $dosen_id)
                ->findAll();
        } else {
            $data['soal'] = $model->getSoalWithRelasi();
        }

        return view('soal/index', $data);
    }

    public function create()
    {
        $data['title']       = 'Tambah Soal';
        $data['group_name']  = $this->auth->getGroupName();
        $data['user_name']   = session()->get('first_name') . ' ' . session()->get('last_name');
        $data['active_menu'] = 'soal';
        $data['action']      = '/soal/create';

        $matkulModel = model('App\Models\MatkulModel');

        if ($this->auth->isDosen()) {
            $dosenModel  = model('App\Models\DosenModel');
            $dosen       = $dosenModel->find(session()->get('dosen_id'));
            $matkul_list = $dosen ? $matkulModel->where('id_matkul', $dosen->matkul_id)->findAll() : [];
        } else {
            $matkul_list = $matkulModel->findAll();
        }
        $data['matkul_list'] = $matkul_list;

        $data['dosen_list'] = model('App\Models\DosenModel')
            ->select('dosen.*, matkul.nama_matkul')
            ->join('matkul', 'matkul.id_matkul = dosen.matkul_id', 'left')
            ->findAll();

        if ($this->request->getMethod() === 'POST') {
            return $this->save();
        }

        return view('soal/form', $data);
    }

    public function update($id)
    {
        $model = model('App\Models\SoalModel');

        $data['title']       = 'Edit Soal';
        $data['group_name']  = $this->auth->getGroupName();
        $data['user_name']   = session()->get('first_name') . ' ' . session()->get('last_name');
        $data['active_menu'] = 'soal';
        $data['action']      = '/soal/update/' . $id;

        $matkulModel = model('App\Models\MatkulModel');

        if ($this->auth->isDosen()) {
            $dosenModel  = model('App\Models\DosenModel');
            $dosen       = $dosenModel->find(session()->get('dosen_id'));
            $matkul_list = $dosen ? $matkulModel->where('id_matkul', $dosen->matkul_id)->findAll() : [];
        } else {
            $matkul_list = $matkulModel->findAll();
        }
        $data['matkul_list'] = $matkul_list;

        $data['dosen_list'] = model('App\Models\DosenModel')
            ->select('dosen.*, matkul.nama_matkul')
            ->join('matkul', 'matkul.id_matkul = dosen.matkul_id', 'left')
            ->findAll();

        if ($this->request->getMethod() === 'POST') {
            return $this->save($id);
        }

        $data['row'] = $model->find($id);
        if (!$data['row']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Dosen hanya bisa edit soal sendiri
        if ($this->auth->isDosen() && $data['row']->dosen_id != session()->get('dosen_id')) {
            return redirect()->to('/soal')->with('error', 'Tidak punya akses.');
        }

        return view('soal/form', $data);
    }

    public function delete($id)
    {
        $model = model('App\Models\SoalModel');
        $soal  = $model->find($id);

        if (!$soal) {
            return redirect()->to('/soal')->with('error', 'Soal tidak ditemukan.');
        }

        // Dosen hanya bisa hapus soal sendiri
        if ($this->auth->isDosen() && $soal->dosen_id != session()->get('dosen_id')) {
            return redirect()->to('/soal')->with('error', 'Tidak punya akses.');
        }

        // Hapus file terkait
        $fileFields = ['file', 'file_a', 'file_b', 'file_c', 'file_d', 'file_e'];
        foreach ($fileFields as $f) {
            if (!empty($soal->$f)) {
                $path = FCPATH . 'uploads/soal/' . $soal->$f;
                if (file_exists($path)) @unlink($path);
            }
        }

        $model->delete($id);
        session()->setFlashdata('success', 'Soal berhasil dihapus.');
        return redirect()->to('/soal');
    }

    public function import()
    {
        $data['title']       = 'Import Soal (Excel)';
        $data['group_name']  = $this->auth->getGroupName();
        $data['user_name']   = session()->get('first_name') . ' ' . session()->get('last_name');
        $data['active_menu'] = 'soal';

        $matkulModel = model('App\Models\MatkulModel');

        if ($this->auth->isDosen()) {
            $dosenModel  = model('App\Models\DosenModel');
            $dosen       = $dosenModel->find(session()->get('dosen_id'));
            $matkul_list = $dosen ? $matkulModel->where('id_matkul', $dosen->matkul_id)->findAll() : [];
        } else {
            $matkul_list = $matkulModel->findAll();
        }
        $data['matkul_list'] = $matkul_list;

        if ($this->request->getMethod() === 'POST') {
            $file = $this->request->getFile('file_excel');
            if (!$file || !$file->isValid()) {
                session()->setFlashdata('error', 'File tidak valid.');
                return redirect()->to('/soal/import');
            }

            $matkul_id = (int) $this->request->getPost('matkul_id');
            $bobot     = (int) $this->request->getPost('bobot') ?: 1;

            if (!$matkul_id) {
                session()->setFlashdata('error', 'Pilih matkul.');
                return redirect()->to('/soal/import');
            }

            $dosen_id = $this->auth->isDosen()
                ? session()->get('dosen_id')
                : (int) $this->request->getPost('dosen_id');

            if (!$dosen_id) {
                session()->setFlashdata('error', 'Pilih dosen.');
                return redirect()->to('/soal/import');
            }

            $spreadsheet = IOFactory::load($file->getTempName());
            $worksheet   = $spreadsheet->getActiveSheet();
            $rows        = $worksheet->toArray();
            $headers     = array_shift($rows); // skip header

            $model   = model('App\Models\SoalModel');
            $now     = time();
            $success = 0;
            $errors  = [];

            foreach ($rows as $idx => $row) {
                if (empty(array_filter($row))) continue;
                $soal_text = trim($row[0] ?? '');
                if (empty($soal_text)) continue;

                // Map kolom: soal, opsi_a..e, jawaban
                $dataInsert = [
                    'dosen_id'   => $dosen_id,
                    'matkul_id'  => $matkul_id,
                    'bobot'      => $bobot,
                    'soal'       => $soal_text,
                    'opsi_a'     => trim($row[1] ?? ''),
                    'opsi_b'     => trim($row[2] ?? ''),
                    'opsi_c'     => trim($row[3] ?? ''),
                    'opsi_d'     => trim($row[4] ?? ''),
                    'opsi_e'     => trim($row[5] ?? ''),
                    'jawaban'    => strtoupper(trim($row[6] ?? '')),
                    'file'       => '',
                    'tipe_file'  => '',
                    'file_a'     => '', 'file_b' => '', 'file_c' => '', 'file_d' => '', 'file_e' => '',
                    'created_on' => $now,
                ];

                if (!in_array($dataInsert['jawaban'], ['A', 'B', 'C', 'D', 'E'])) {
                    $errors[] = "Baris " . ($idx + 2) . ": jawaban tidak valid ({$dataInsert['jawaban']})";
                    continue;
                }

                $model->insert($dataInsert);
                $success++;
            }

            $msg = "$success soal berhasil diimport.";
            if (!empty($errors)) {
                $msg .= ' ' . implode('; ', array_slice($errors, 0, 10));
            }
            session()->setFlashdata('success', $msg);
            return redirect()->to('/soal');
        }

        // Untuk admin: daftar dosen untuk dropdown
        $data['dosen_list'] = model('App\Models\DosenModel')
            ->select('dosen.*, matkul.nama_matkul')
            ->join('matkul', 'matkul.id_matkul = dosen.matkul_id', 'left')
            ->findAll();

        return view('soal/import', $data);
    }

    public function template()
    {
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Soal');
        $sheet->setCellValue('B1', 'Opsi A');
        $sheet->setCellValue('C1', 'Opsi B');
        $sheet->setCellValue('D1', 'Opsi C');
        $sheet->setCellValue('E1', 'Opsi D');
        $sheet->setCellValue('F1', 'Opsi E');
        $sheet->setCellValue('G1', 'Jawaban');

        // Contoh baris
        $sheet->setCellValue('A2', 'Ibu kota Indonesia adalah...');
        $sheet->setCellValue('B2', 'Jakarta');
        $sheet->setCellValue('C2', 'Surabaya');
        $sheet->setCellValue('D2', 'Bandung');
        $sheet->setCellValue('E2', 'Medan');
        $sheet->setCellValue('F2', 'Yogyakarta');
        $sheet->setCellValue('G2', 'A');

        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'template_import_soal.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }

    public function export()
    {
        $matkul_id = (int) $this->request->getGet('matkul_id');

        $model = model('App\Models\SoalModel');
        $builder = $model->select('tb_soal.*, matkul.nama_matkul, dosen.nama_dosen')
            ->join('matkul', 'tb_soal.matkul_id = matkul.id_matkul', 'left')
            ->join('dosen', 'tb_soal.dosen_id = dosen.id_dosen', 'left');

        if ($this->auth->isDosen()) {
            $builder->where('tb_soal.dosen_id', session()->get('dosen_id'));
        }

        if ($matkul_id > 0) {
            $builder->where('tb_soal.matkul_id', $matkul_id);
        }

        $soal = $builder->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'Soal');
        $sheet->setCellValue('B1', 'Opsi A');
        $sheet->setCellValue('C1', 'Opsi B');
        $sheet->setCellValue('D1', 'Opsi C');
        $sheet->setCellValue('E1', 'Opsi D');
        $sheet->setCellValue('F1', 'Opsi E');
        $sheet->setCellValue('G1', 'Jawaban');
        $sheet->setCellValue('H1', 'Matkul');
        $sheet->setCellValue('I1', 'Dosen');
        $sheet->setCellValue('J1', 'Bobot');

        $row = 2;
        foreach ($soal as $s) {
            $sheet->setCellValue('A' . $row, $s->soal);
            $sheet->setCellValue('B' . $row, $s->opsi_a);
            $sheet->setCellValue('C' . $row, $s->opsi_b);
            $sheet->setCellValue('D' . $row, $s->opsi_c);
            $sheet->setCellValue('E' . $row, $s->opsi_d);
            $sheet->setCellValue('F' . $row, $s->opsi_e);
            $sheet->setCellValue('G' . $row, $s->jawaban);
            $sheet->setCellValue('H' . $row, $s->nama_matkul ?? '');
            $sheet->setCellValue('I' . $row, $s->nama_dosen ?? '');
            $sheet->setCellValue('J' . $row, $s->bobot);
            $row++;
        }

        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'bank_soal_' . date('Ymd') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }

    protected function save(int $id = 0)
    {
        $model   = model('App\Models\SoalModel');
        $dosen_id = $this->auth->isDosen()
            ? session()->get('dosen_id')
            : (int) $this->request->getPost('dosen_id');

        $matkul_id = (int) $this->request->getPost('matkul_id');
        $bobot     = (int) $this->request->getPost('bobot') ?: 1;
        $jawaban   = strtoupper(trim($this->request->getPost('jawaban')));
        $soal_text = $this->request->getPost('soal');

        $data = [
            'dosen_id'   => $dosen_id,
            'matkul_id'  => $matkul_id,
            'bobot'      => $bobot,
            'soal'       => $soal_text,
            'opsi_a'     => $this->request->getPost('opsi_a'),
            'opsi_b'     => $this->request->getPost('opsi_b'),
            'opsi_c'     => $this->request->getPost('opsi_c'),
            'opsi_d'     => $this->request->getPost('opsi_d'),
            'opsi_e'     => $this->request->getPost('opsi_e'),
            'jawaban'    => $jawaban,
        ];

        // Handle file upload soal
        $fileSoal = $this->request->getFile('file');
        if ($fileSoal && $fileSoal->isValid() && !$fileSoal->hasMoved()) {
            $newName = $fileSoal->getRandomName();
            $fileSoal->move(FCPATH . 'uploads/soal', $newName);
            $data['file']      = $newName;
            $data['tipe_file'] = $fileSoal->getClientMimeType();
        }

        // Handle file upload opsi
        $optKeys = ['file_a', 'file_b', 'file_c', 'file_d', 'file_e'];
        foreach ($optKeys as $key) {
            $f = $this->request->getFile($key);
            if ($f && $f->isValid() && !$f->hasMoved()) {
                $newName = $f->getRandomName();
                $f->move(FCPATH . 'uploads/soal', $newName);
                $data[$key] = $newName;
            }
        }

        if ($id > 0) {
            $data['updated_on'] = time();
            $model->update($id, $data);
            session()->setFlashdata('success', 'Soal berhasil diupdate.');
        } else {
            $data['created_on'] = time();
            $model->insert($data);
            session()->setFlashdata('success', 'Soal berhasil ditambahkan.');
        }

        return redirect()->to('/soal');
    }
}