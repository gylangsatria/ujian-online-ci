<?php

namespace App\Models;

use CodeIgniter\Model;

class JurusanMatkulModel extends Model
{
    protected $table         = 'jurusan_matkul';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['jurusan_id', 'matkul_id'];
    protected $useTimestamps = false;
    protected $returnType    = 'object';
}