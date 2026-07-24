<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMUjianTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_ujian'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'dosen_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => false],
            'matkul_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => false],
            'nama_ujian'  => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => false],
            'jumlah_soal' => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'waktu'       => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'jenis'       => ['type' => 'ENUM', 'constraint' => ['acak', 'urut'], 'null' => false],
            'tgl_mulai'   => ['type' => 'DATETIME', 'null' => false],
            'terlambat'   => ['type' => 'DATETIME', 'null' => false],
            'token'       => ['type' => 'VARCHAR', 'constraint' => 5, 'null' => false],
        ]);
        $this->forge->addKey('id_ujian', true);
        $this->forge->addForeignKey('dosen_id', 'dosen', 'id_dosen', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('matkul_id', 'matkul', 'id_matkul', 'CASCADE', 'CASCADE');
        $this->forge->createTable('m_ujian', true);
    }

    public function down()
    {
        $this->forge->dropTable('m_ujian', true);
    }
}