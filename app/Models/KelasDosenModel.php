<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasDosenModel extends Model
{
    protected $table         = 'kelas_dosen';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['kelas_id', 'dosen_id'];
    protected $useTimestamps = false;
}