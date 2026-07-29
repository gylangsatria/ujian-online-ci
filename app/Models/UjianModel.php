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
        $builder = $this->db->table($this->table . ' a');
        $builder->select('a.*, b.nama_dosen, c.nama_matkul');
        $builder->join('dosen b', 'a.dosen_id = b.id_dosen');
        $builder->join('matkul c', 'a.matkul_id = c.id_matkul');
        
        if ($id !== null) {
            return $builder->where('a.id_ujian', $id)->get()->getRow();
        }
        
        return $builder->get()->getResult();
    }
}