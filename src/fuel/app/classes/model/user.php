<?php

class Model_User extends Orm\Model
{
    protected static $_properties = array(
        'id',
        'name',
        'role',
        'password',
        'created_at',
        'updated_at',
    );

    public static function find_by_credentials($name, $password)
    {
        $user = self::query()->where('name', $name)->get_one();
        if ($user && hash('sha256', $password) === $user->password) {
            return $user;
        }
        return null;
    }
}
