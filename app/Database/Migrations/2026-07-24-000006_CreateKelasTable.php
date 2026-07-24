<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKelasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kelas'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_kelas' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => false],
            'jurusan_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => false],
        ]);
        $this->forge->addKey('id_kelas', true);
        $this->forge->addForeignKey('jurusan_id', 'jurusan', 'id_jurusan', 'CASCADE', 'CASCADE');
        $this->forge->createTable('kelas', true);
    }

    public function down()
    {
        $this->forge->dropTable('kelas', true);
    }
}