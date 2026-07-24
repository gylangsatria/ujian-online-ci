<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDosenTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_dosen'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nip'       => ['type' => 'CHAR', 'constraint' => 12, 'null' => false],
            'nama_dosen' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => false],
            'email'     => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => false],
            'matkul_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => false],
        ]);
        $this->forge->addKey('id_dosen', true);
        $this->forge->addUniqueKey('nip');
        $this->forge->addUniqueKey('email');
        $this->forge->addForeignKey('matkul_id', 'matkul', 'id_matkul', 'CASCADE', 'CASCADE');
        $this->forge->createTable('dosen', true);
    }

    public function down()
    {
        $this->forge->dropTable('dosen', true);
    }
}