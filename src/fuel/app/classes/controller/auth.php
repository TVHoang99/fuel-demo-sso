<?php

class Controller_Auth extends Controller
{
    public function action_login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = Input::post('name');
            $pass = Input::post('password');
            $redirect = Input::post('redirect') ?: 'http://ssodemo.local';

            $user = Model_User::find_by_credentials($name, $pass);

            if ($user) {
                $token = bin2hex(random_bytes(32));

                // Set cookie dùng chung cho toàn bộ .ssodemo.local
                Cookie::set('sso_token', $token, 3600 * 24 * 3, '/', '.ssodemo.local');

                // Lưu token tạm vào session PHP (demo)
                Session::set('token_'.$token, $user->id);
				// var_dump(Session::get('token_' . $token), $token); die;

				// var_dump($redirect); die;
                Response::redirect($redirect);
            }

            return 'Sai tài khoản hoặc mật khẩu';
        }

        $redirect = Input::get('redirect', 'http://ssodemo.local');
        return View::forge('auth/login', ['redirect' => $redirect]);
    }

    public function action_validate()
    {
        $token = Input::get('token');
		var_dump(Session::get('token_'.$token));
		die;
        $uid = Session::get('token_'.$token);

        if ($uid) {
            $user = Model_User::find($uid);
            return json_encode([
                'valid' => true,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'role' => $user->role,
                ],
            ]);
        }

        return json_encode(['valid' => $token]);
    }
}
