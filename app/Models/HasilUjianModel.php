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
}