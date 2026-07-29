<?php

namespace App\Models;

use CodeIgniter\Model;

class MatkulModel extends Model
{
    protected $table         = 'matkul';
    protected $primaryKey    = 'id_matkul';
    protected $allowedFields = ['nama_matkul'];
    protected $useTimestamps = false;
    protected $returnType    = 'object';
}