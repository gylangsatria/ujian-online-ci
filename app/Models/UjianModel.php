<?php

namespace App\Models;

use CodeIgniter\Model;

class UjianModel extends Model
{
    protected $table            = 'm_ujian';
    protected $primaryKey       = 'id_ujian';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'dosen_id',
        'matkul_id',
        'nama_ujian',
        'jumlah_soal',
        'waktu',
        'jenis',
        'tgl_mulai',
        'terlambat',
        'token'
    ];

    public function getUjian($id = null)
    {
        $this->select('m_ujian.*, dosen.nama_dosen, matkul.nama_matkul');
        $this->join('dosen', 'm_ujian.dosen_id = dosen.id_dosen');
        $this->join('matkul', 'm_ujian.matkul_id = matkul.id_matkul');
        
        if ($id !== null) {
            return $this->where('m_ujian.id_ujian', $id)->first();
        }
        
        return $this->findAll();
    }
}