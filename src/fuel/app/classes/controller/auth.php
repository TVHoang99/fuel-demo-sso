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

                Model_SsoToken::find_by_token($token);

                $sso = Model_SsoToken::forge();
                $sso->token = $token;
                $sso->user_id = $user->id;
                $sso->expires_at = time() + 3600 * 24 * 3;
                $sso->save();

                // Set cookie dùng chung cho toàn bộ .ssodemo.local
                Cookie::set('sso_token', $token, 3600 * 24 * 3, '/', '.ssodemo.local');

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
        if (!$token) return json_encode(['valid' => false]);

        $sso = Model_SsoToken::find_by_token($token);
        if (!$sso) return json_encode(['valid' => false]);

        $user = Model_User::find($sso->user_id);
        if (!$user) return json_encode(['valid' => false]);

        return json_encode([
            'valid' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'role' => $user->role,
            ],
        ]);
    }

    public function action_logout()
    {
        $token = Cookie::get('sso_token');
        if ($token) {
            Model_SsoToken::query()->where('token', $token)->delete();
            Cookie::delete('sso_token', '/', '.ssodemo.local');
        }
        Response::redirect('http://auth.ssodemo.local/auth/login');
    }
}
