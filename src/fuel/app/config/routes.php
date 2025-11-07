<?php
/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.9-dev
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2019 Fuel Development Team
 * @link       https://fuelphp.com
 */

$host = \Input::server('HTTP_HOST');

if (strpos($host, 'admin.ssodemo.local') !== false) {
    // Routes cho admin domain
    return array(
        '_root_'  => 'admin/index',
        'auth/login' => 'auth/login',
        'auth/validate' => 'auth/validate',
    );
} else {
    // Routes cho domain chính
    return array(
        '_root_'  => 'home/index',
        'auth/login' => 'auth/login',
        'auth/validate' => 'auth/validate',
    );
}