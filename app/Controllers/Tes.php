<?php

namespace App\Controllers;

use App\Models\UjianModel;
use App\Models\SoalModel;
use App\Models\HasilUjianModel;
use App\Models\MahasiswaModel;

class Tes extends BaseController
{
    protected $ujianModel;
    protected $soalModel;
    protected $hasilUjianModel;
    protected $mahasiswaModel;

    public function __construct()
    {
        $this->ujianModel = new UjianModel();
        $this->soalModel = new SoalModel();
        $this->hasilUjianModel = new HasilUjianModel();
        $this->mahasiswaModel = new MahasiswaModel();
    }

    public function index()
    {
        $mhs = $this->mahasiswaModel->find(session()->get('mahasiswa_id'));
        
        if (!$mhs) {
            return "User bukan mahasiswa";
        }

        $data = [
            'title' => 'Ujian Tersedia',
            'ujian' => $this->ujianModel->getUjian(),
            'mhs'   => $mhs
        ];
        return view('tes/index', $data);
    }

    public function token($id)
    {
        $data = [
            'title' => 'Konfirmasi Token',
            'ujian' => $this->ujianModel->getUjian($id)
        ];
        return view('tes/token', $data);
    }

    public function cek_token()
    {
        $id_ujian = $this->request->getPost('id_ujian');
        $token = $this->request->getPost('token');
        
        $ujian = $this->ujianModel->find($id_ujian);
        
        if ($ujian->token === $token) {
            return json_encode(['status' => true]);
        } else {
            return json_encode(['status' => false]);
        }
    }

    public function mulai($id)
    {
        $mhs = $this->mahasiswaModel->find(session()->get('mahasiswa_id'));
        
        $exists = $this->hasilUjianModel->where(['ujian_id' => $id, 'mahasiswa_id' => $mhs->id_mahasiswa])->first();
        
        if (!$exists) {
            $ujian = $this->ujianModel->find($id);
            $soal = $this->soalModel->where('matkul_id', $ujian->matkul_id)->orderBy('id_soal', $ujian->jenis == 'acak' ? 'RANDOM' : 'ASC')->limit((int) $ujian->jumlah_soal)->findAll();
            
            $list_soal = "";
            $list_jawaban = "";
            foreach ($soal as $s) {
                $list_soal .= $s->id_soal . ",";
                $list_jawaban .= $s->id_soal . "::N,";
            }
            $list_soal = rtrim($list_soal, ",");
            $list_jawaban = rtrim($list_jawaban, ",");

            $data = [
                'ujian_id'      => $id,
                'mahasiswa_id'  => $mhs->id_mahasiswa,
                'list_soal'     => $list_soal,
                'list_jawaban'  => $list_jawaban,
                'jml_benar'     => 0,
                'nilai'         => 0,
                'nilai_bobot'   => 0,
                'tgl_mulai'     => date('Y-m-d H:i:s'),
                'tgl_selesai'   => date('Y-m-d H:i:s', strtotime('+'.$ujian->waktu.' minutes')),
                'status'        => 'Y'
            ];
            $this->hasilUjianModel->save($data);
            $id_hasil = $this->hasilUjianModel->getInsertID();
        } else {
            $id_hasil = $exists->id;
        }

        return redirect()->to('tes/kerjakan/' . $id_hasil);
    }

    public function kerjakan($id)
    {
        $hasil = $this->hasilUjianModel->find($id);
        $ujian = $this->ujianModel->getUjian($hasil->ujian_id);
        
        $list_soal = explode(',', $hasil->list_soal);
        $soal = $this->soalModel->whereIn('id_soal', $list_soal)->findAll();
        
        // Map soal by id for easy access
        $soal_map = [];
        foreach ($soal as $s) {
            $soal_map[$s->id_soal] = $s;
        }

        // Ordered soal based on list_soal
        $ordered_soal = [];
        foreach ($list_soal as $sid) {
            $ordered_soal[] = $soal_map[$sid];
        }

        // Current answers
        $jawaban_raw = explode(',', $hasil->list_jawaban);
        $jawaban_map = [];
        foreach ($jawaban_raw as $j) {
            $parts = explode('::', $j);
            $jawaban_map[$parts[0]] = $parts[1];
        }

        $data = [
            'title'   => 'Mengerjakan Ujian',
            'hasil'   => $hasil,
            'ujian'   => $ujian,
            'soal'    => $ordered_soal,
            'jawaban' => $jawaban_map
        ];
        return view('tes/kerjakan', $data);
    }

    public function simpan_satu()
    {
        $id_hasil = $this->request->getPost('id_hasil');
        $id_soal = $this->request->getPost('id_soal');
        $jawaban = $this->request->getPost('jawaban');

        $hasil = $this->hasilUjianModel->find($id_hasil);
        $jawaban_raw = explode(',', $hasil->list_jawaban);
        
        $new_jawaban = "";
        foreach ($jawaban_raw as $j) {
            $parts = explode('::', $j);
            if ($parts[0] == $id_soal) {
                $new_jawaban .= $id_soal . "::" . $jawaban . ",";
            } else {
                $new_jawaban .= $j . ",";
            }
        }
        $new_jawaban = rtrim($new_jawaban, ",");

        $this->hasilUjianModel->update($id_hasil, ['list_jawaban' => $new_jawaban]);
        return json_encode(['status' => true]);
    }

    public function selesai()
    {
        $id_hasil = $this->request->getPost('id_hasil');
        $hasil = $this->hasilUjianModel->find($id_hasil);
        $ujian = $this->ujianModel->find($hasil->ujian_id);
        
        $jawaban_raw = explode(',', $hasil->list_jawaban);
        $jml_benar = 0;
        $total_bobot = 0;

        foreach ($jawaban_raw as $j) {
            $parts = explode('::', $j);
            $soal = $this->soalModel->find($parts[0]);
            if ($soal->jawaban == $parts[1]) {
                $jml_benar++;
                $total_bobot += $soal->bobot;
            }
        }

        $nilai = ($jml_benar / $ujian->jumlah_soal) * 100;

        $this->hasilUjianModel->update($id_hasil, [
            'jml_benar'   => $jml_benar,
            'nilai'       => $nilai,
            'nilai_bobot' => $total_bobot,
            'tgl_selesai' => date('Y-m-d H:i:s'),
            'status'      => 'N'
        ]);

        return redirect()->to('tes');
    }
}