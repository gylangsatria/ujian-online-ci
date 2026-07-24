<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJurusanMatkulTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'matkul_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => false],
            'jurusan_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => false],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('matkul_id', 'matkul', 'id_matkul', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('jurusan_id', 'jurusan', 'id_jurusan', 'CASCADE', 'CASCADE');
        $this->forge->createTable('jurusan_matkul', true);
    }

    public function down()
    {
        $this->forge->dropTable('jurusan_matkul', true);
    }
}