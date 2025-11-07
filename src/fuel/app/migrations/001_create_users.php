<?php
namespace Fuel\Migrations;

class Create_users
{
    public function up()
    {
        \DBUtil::create_table('users', [
            'id'         => ['type' => 'int', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true],
            'name'       => ['type' => 'varchar', 'constraint' => 100, 'null' => false],
            'role'       => ['type' => 'enum', 'constraint' => "'admin','user'", 'default' => 'user'],
            'password'   => ['type' => 'varchar', 'constraint' => 255, 'null' => false],
            'created_at' => ['type' => 'timestamp', 'default' => \DB::expr('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'timestamp', 'default' => \DB::expr('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')],
        ], ['id'], true, 'InnoDB', 'latin1');

        \DBUtil::create_index('users', 'name', 'idx_name', 'UNIQUE');
    }

    public function down()
    {
        \DBUtil::drop_table('users');
    }
}
