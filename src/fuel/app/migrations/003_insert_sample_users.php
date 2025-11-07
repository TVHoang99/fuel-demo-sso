<?php
namespace Fuel\Migrations;

class Insert_sample_users
{
    public function up()
    {
        \DB::insert('users')->set([
            'name' => 'admin',
            'password' => '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9', // pass: admin
            'role' => 'admin',
        ])->execute();

        \DB::insert('users')->set([
            'name' => 'user',
            'password' => 'e606e38b0d8c19b24cf0ee3808183162ea7cd63ff7912dbb22b5e803286b4446', // pass: user
            'role' => 'user',
        ])->execute();
    }

    public function down()
    {
        \DB::delete('users')->where('name', 'IN', ['admin', 'user'])->execute();
    }
}
