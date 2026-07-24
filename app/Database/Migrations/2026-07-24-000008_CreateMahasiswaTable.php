<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMahasiswaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_mahasiswa'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama'          => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => false],
            'nim'           => ['type' => 'CHAR', 'constraint' => 20, 'null' => false],
            'email'         => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => false],
            'jenis_kelamin' => ['type' => 'ENUM', 'constraint' => ['L', 'P'], 'null' => false],
            'kelas_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => false],
        ]);
        $this->forge->addKey('id_mahasiswa', true);
        $this->forge->addUniqueKey('nim');
        $this->forge->addUniqueKey('email');
        $this->forge->addForeignKey('kelas_id', 'kelas', 'id_kelas', 'CASCADE', 'CASCADE');
        $this->forge->createTable('mahasiswa', true);
    }

    public function down()
    {
        $this->forge->dropTable('mahasiswa', true);
    }
}