<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKelasDosenTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'kelas_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => false],
            'dosen_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => false],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('kelas_id', 'kelas', 'id_kelas', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('dosen_id', 'dosen', 'id_dosen', 'CASCADE', 'CASCADE');
        $this->forge->createTable('kelas_dosen', true);
    }

    public function down()
    {
        $this->forge->dropTable('kelas_dosen', true);
    }
}