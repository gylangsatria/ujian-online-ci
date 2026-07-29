<?php

namespace App\Models;

use CodeIgniter\Model;

class SoalModel extends Model
{
    protected $table         = 'tb_soal';
    protected $primaryKey    = 'id_soal';
    protected $returnType    = 'object';
    protected $allowedFields = [
        'dosen_id', 'matkul_id', 'bobot', 'file', 'tipe_file',
        'soal', 'opsi_a', 'opsi_b', 'opsi_c', 'opsi_d', 'opsi_e',
        'file_a', 'file_b', 'file_c', 'file_d', 'file_e',
        'jawaban', 'created_on', 'updated_on',
    ];
    protected $useTimestamps = false;

    public function getSoalWithRelasi(int $id = 0)
    {
        $builder = $this->db->table($this->table);
        $builder->select('tb_soal.*, matkul.nama_matkul, dosen.nama_dosen');
        $builder->join('matkul', 'tb_soal.matkul_id = matkul.id_matkul', 'left');
        $builder->join('dosen', 'tb_soal.dosen_id = dosen.id_dosen', 'left');
        if ($id > 0) {
            $builder->where('tb_soal.id_soal', $id);
            return $builder->get()->getRow();
        }
        return $builder->get()->getResult();
    }

    public function getByMatkul(int $matkul_id)
    {
        return $this->where('matkul_id', $matkul_id)->findAll();
    }
}