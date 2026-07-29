<?php

namespace App\Models;

use CodeIgniter\Model;

class HasilUjianModel extends Model
{
    protected $table            = 'h_ujian';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'ujian_id',
        'mahasiswa_id',
        'list_soal',
        'list_jawaban',
        'jml_benar',
        'nilai',
        'nilai_bobot',
        'tgl_mulai',
        'tgl_selesai',
        'status'
    ];

    public function getHasilUjian($id = null)
    {
        $this->select('h_ujian.*, u.nama_ujian, u.jumlah_soal, m.nama as nama_mahasiswa, m.nim, mk.nama_matkul');
        $this->join('m_ujian u', 'u.id_ujian = h_ujian.ujian_id');
        $this->join('mahasiswa m', 'm.id_mahasiswa = h_ujian.mahasiswa_id');
        $this->join('matkul mk', 'mk.id_matkul = u.matkul_id');

        if ($id !== null) {
            return $this->where('h_ujian.id', $id)->first();
        }

        return $this->findAll();
    }

    public function getHasilUjianByMahasiswa($mahasiswa_id)
    {
        return $this->select('h_ujian.*, u.nama_ujian, u.jumlah_soal, m.nama as nama_mahasiswa, m.nim, mk.nama_matkul')
            ->join('m_ujian u', 'u.id_ujian = h_ujian.ujian_id')
            ->join('mahasiswa m', 'm.id_mahasiswa = h_ujian.mahasiswa_id')
            ->join('matkul mk', 'mk.id_matkul = u.matkul_id')
            ->where('h_ujian.mahasiswa_id', $mahasiswa_id)
            ->findAll();
    }
}
