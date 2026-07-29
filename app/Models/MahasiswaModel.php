<?php

namespace App\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table         = 'mahasiswa';
    protected $primaryKey    = 'id_mahasiswa';
    protected $allowedFields = ['nama', 'nim', 'email', 'jenis_kelamin', 'kelas_id'];
    protected $useTimestamps = false;
    protected $returnType    = 'object';
}