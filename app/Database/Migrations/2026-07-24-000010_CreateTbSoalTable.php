<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbSoalTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_soal'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'dosen_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => false],
            'matkul_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => false],
            'bobot'       => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'file'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false, 'default' => ''],
            'tipe_file'   => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => false, 'default' => ''],
            'soal'        => ['type' => 'LONGTEXT', 'null' => false],
            'opsi_a'      => ['type' => 'LONGTEXT', 'null' => false],
            'opsi_b'      => ['type' => 'LONGTEXT', 'null' => false],
            'opsi_c'      => ['type' => 'LONGTEXT', 'null' => false],
            'opsi_d'      => ['type' => 'LONGTEXT', 'null' => false],
            'opsi_e'      => ['type' => 'LONGTEXT', 'null' => false],
            'file_a'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false, 'default' => ''],
            'file_b'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false, 'default' => ''],
            'file_c'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false, 'default' => ''],
            'file_d'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false, 'default' => ''],
            'file_e'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false, 'default' => ''],
            'jawaban'     => ['type' => 'VARCHAR', 'constraint' => 5, 'null' => false],
            'created_on'  => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'updated_on'  => ['type' => 'INT', 'constraint' => 11, 'null' => true],
        ]);
        $this->forge->addKey('id_soal', true);
        $this->forge->addForeignKey('matkul_id', 'matkul', 'id_matkul', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('dosen_id', 'dosen', 'id_dosen', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_soal', true);
    }

    public function down()
    {
        $this->forge->dropTable('tb_soal', true);
    }
}