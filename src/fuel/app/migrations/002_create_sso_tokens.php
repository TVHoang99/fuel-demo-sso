<?php
namespace Fuel\Migrations;

class Create_sso_tokens
{
    public function up()
    {
        \DBUtil::create_table('sso_tokens', [
            'token'      => ['type' => 'char', 'constraint' => 64, 'null' => false],
            'user_id'    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => false],
            'expires_at' => ['type' => 'int', 'constraint' => 11, 'null' => false],
        ], ['token'], true, 'InnoDB', 'utf8mb4');

        \DBUtil::create_index('sso_tokens', 'user_id', 'idx_user_id');

        // Foreign key
        \DBUtil::add_foreign_key('sso_tokens', [
            'constraint' => 'sso_tokens_ibfk_1',
            'key'        => 'user_id',
            'reference'  => [
                'table'  => 'users',
                'column' => 'id',
            ],
            'on_delete' => 'CASCADE',
            'on_update' => 'RESTRICT'
        ]);
    }

    public function down()
    {
        \DBUtil::drop_table('sso_tokens');
    }
}
