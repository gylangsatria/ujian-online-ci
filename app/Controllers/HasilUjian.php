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
        $user_id = session()->get('user_id');
        
        if ($this->auth->is_admin()) {
            $hasil = $this->hasilUjianModel->getHasilUjian();
        } elseif ($this->auth->in_group('dosen')) {
            // TODO: Filter by dosen matkul if needed
            $hasil = $this->hasilUjianModel->getHasilUjian();
        } else {
            $mhs = $this->mahasiswaModel->where('user_id', $user_id)->first();
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
