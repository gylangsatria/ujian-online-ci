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
        $builder = $this->db->table($this->table . ' h');
        $builder->select('h.*, u.nama_ujian, u.jumlah_soal, m.nama as nama_mahasiswa, m.nim, mk.nama_matkul');
        $builder->join('m_ujian u', 'u.id_ujian = h.ujian_id');
        $builder->join('mahasiswa m', 'm.id_mahasiswa = h.mahasiswa_id');
        $builder->join('matkul mk', 'mk.id_matkul = u.matkul_id');

        if ($id !== null) {
            $builder->where('h.id', $id);
            return $builder->get()->getRow();
        }

        return $builder->get()->getResult();
    }

    public function getHasilUjianByMahasiswa($mahasiswa_id)
    {
        $builder = $this->db->table($this->table . ' h');
        $builder->select('h.*, u.nama_ujian, u.jumlah_soal, m.nama as nama_mahasiswa, m.nim, mk.nama_matkul');
        $builder->join('m_ujian u', 'u.id_ujian = h.ujian_id');
        $builder->join('mahasiswa m', 'm.id_mahasiswa = h.mahasiswa_id');
        $builder->join('matkul mk', 'mk.id_matkul = u.matkul_id');
        $builder->where('h.mahasiswa_id', $mahasiswa_id);
        return $builder->get()->getResult();
    }
}
