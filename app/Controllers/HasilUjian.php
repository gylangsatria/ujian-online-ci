<?php

namespace App\Controllers;

use App\Models\HasilUjianModel;
use App\Models\MahasiswaModel;
use App\Models\UjianModel;
use App\Libraries\Auth;
use Dompdf\Dompdf;
use Dompdf\Options;

class HasilUjian extends BaseController
{
    protected $hasilUjianModel;
    protected $mahasiswaModel;
    protected $ujianModel;
    protected $auth;

    public function __construct()
    {
        $this->hasilUjianModel = new HasilUjianModel();
        $this->mahasiswaModel = new MahasiswaModel();
        $this->ujianModel = new UjianModel();
        $this->auth = new Auth();
    }

    public function index()
    {
        if ($this->auth->isAdmin()) {
            $hasil = $this->hasilUjianModel->getHasilUjian();
        } elseif ($this->auth->isDosen()) {
            $dosen_id = session()->get('dosen_id');
            $hasil = $this->hasilUjianModel
                ->select('h_ujian.*, m_ujian.nama_ujian, m_ujian.jumlah_soal, mahasiswa.nama, mahasiswa.nim')
                ->join('m_ujian', 'm_ujian.id_ujian = h_ujian.ujian_id')
                ->join('mahasiswa', 'mahasiswa.id_mahasiswa = h_ujian.mahasiswa_id')
                ->where('m_ujian.dosen_id', $dosen_id)
                ->findAll();
        } else {
            $mhs = $this->mahasiswaModel->find(session()->get('mahasiswa_id'));
            $hasil = $this->hasilUjianModel->getHasilUjianByMahasiswa($mhs->id_mahasiswa);
        }

        $data = [
            'title' => 'Hasil Ujian',
            'hasil' => $hasil
        ];

        return view('ujian/hasil', $data);
    }

    public function detail($id)
    {
        $hasil = $this->hasilUjianModel->getHasilUjian($id);
        if (!$hasil) {
            return redirect()->to('hasilujian');
        }

        // Ownership check
        if ($this->auth->isDosen()) {
            $ujian = $this->ujianModel->find($hasil->ujian_id);
            if ($ujian->dosen_id != session()->get('dosen_id')) {
                return redirect()->to('hasilujian')->with('error', 'Forbidden');
            }
        } elseif ($this->auth->isMahasiswa()) {
            if ($hasil->mahasiswa_id != session()->get('mahasiswa_id')) {
                return redirect()->to('hasilujian')->with('error', 'Forbidden');
            }
        }

        $data = [
            'title' => 'Detail Hasil Ujian',
            'hasil' => $hasil
        ];

        return view('ujian/detail_hasil', $data);
    }

    public function cetak($id)
    {
        $hasil = $this->hasilUjianModel->getHasilUjian($id);
        if (!$hasil) {
            return redirect()->to('hasilujian');
        }

        // Ownership check
        if ($this->auth->isDosen()) {
            $ujian = $this->ujianModel->find($hasil->ujian_id);
            if ($ujian->dosen_id != session()->get('dosen_id')) {
                return redirect()->to('hasilujian')->with('error', 'Forbidden');
            }
        } elseif ($this->auth->isMahasiswa()) {
            if ($hasil->mahasiswa_id != session()->get('mahasiswa_id')) {
                return redirect()->to('hasilujian')->with('error', 'Forbidden');
            }
        }

        $data = [
            'title' => 'Hasil Ujian',
            'hasil' => $hasil
        ];

        $html = view('ujian/cetak', $data);

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Arial');
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        $filename = 'Hasil_Ujian_' . $hasil->nim . '_' . str_replace(' ', '_', $hasil->nama_ujian) . '.pdf';
        
        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
            ->setBody($dompdf->output());
    }
}
