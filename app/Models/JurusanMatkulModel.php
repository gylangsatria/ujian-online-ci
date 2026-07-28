<?php

namespace App\Models;

use CodeIgniter\Model;

class JurusanMatkulModel extends Model
{
    protected $table         = 'jurusan_matkul';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['matkul_id', 'jurusan_id'];
    protected $useTimestamps = false;
}