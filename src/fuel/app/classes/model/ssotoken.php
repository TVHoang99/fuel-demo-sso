<?php

class Model_SsoToken extends Orm\Model
{
    protected static $_properties = [
        'token' => ['data_type' => 'varchar', 'constraint' => 64],
        'user_id',
        'expires_at',
    ];

    protected static $_primary_key = ['token'];

    // Đảm bảo ORM không bỏ qua trường token
    protected static $_observers = [
        'Orm\Observer_Typing' => [],
    ];

    public static function find_by_token($token)
    {
        return static::query()
            ->where('token', $token)
            ->where('expires_at', '>', time())
            ->get_one();
    }
}
