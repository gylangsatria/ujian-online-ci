<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersGroupsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => false],
            'group_id' => ['type' => 'MEDIUMINT', 'unsigned' => true, 'null' => false],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['user_id', 'group_id']);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('group_id', 'groups', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('users_groups', true);
    }

    public function down()
    {
        $this->forge->dropTable('users_groups', true);
    }
}