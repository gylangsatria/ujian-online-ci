<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'ip_address'               => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => false],
            'username'                 => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'password'                 => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'email'                    => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => true],
            'activation_selector'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'activation_code'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'forgotten_password_selector' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'forgotten_password_code'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'forgotten_password_time'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'remember_selector'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'remember_code'            => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_on'               => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => false],
            'last_login'               => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'active'                   => ['type' => 'TINYINT', 'constraint' => 1, 'unsigned' => true, 'null' => true],
            'first_name'               => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'last_name'                => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'company'                  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'phone'                    => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('activation_selector');
        $this->forge->addUniqueKey('forgotten_password_selector');
        $this->forge->addUniqueKey('remember_selector');
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('users', true);
    }

    public function down()
    {
        $this->forge->dropTable('users', true);
    }
}