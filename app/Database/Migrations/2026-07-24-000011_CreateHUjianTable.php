<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHUjianTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'ujian_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => false],
            'mahasiswa_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => false],
            'list_soal'     => ['type' => 'LONGTEXT', 'null' => false],
            'list_jawaban'  => ['type' => 'LONGTEXT', 'null' => false],
            'jml_benar'     => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'nilai'         => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => false],
            'nilai_bobot'   => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => false],
            'tgl_mulai'     => ['type' => 'DATETIME', 'null' => false],
            'tgl_selesai'   => ['type' => 'DATETIME', 'null' => false],
            'status'        => ['type' => 'ENUM', 'constraint' => ['Y', 'N'], 'null' => false],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('ujian_id', 'm_ujian', 'id_ujian', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('mahasiswa_id', 'mahasiswa', 'id_mahasiswa', 'CASCADE', 'CASCADE');
        $this->forge->createTable('h_ujian', true);
    }

    public function down()
    {
        $this->forge->dropTable('h_ujian', true);
    }
}