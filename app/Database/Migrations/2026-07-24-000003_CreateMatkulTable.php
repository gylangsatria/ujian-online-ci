<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMatkulTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_matkul'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_matkul' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => false],
        ]);
        $this->forge->addKey('id_matkul', true);
        $this->forge->createTable('matkul', true);
    }

    public function down()
    {
        $this->forge->dropTable('matkul', true);
    }
}