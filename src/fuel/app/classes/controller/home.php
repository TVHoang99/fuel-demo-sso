<?php

class Controller_Home extends Controller
{
    public function action_index()
    {

        $token = Cookie::get('sso_token');
		// var_dump(Session::get('token_'.$token), '123');die;

        if (!$token) {
            Response::redirect('http://auth.ssodemo.local/auth/login?redirect=' . urlencode('http://ssodemo.local'));
        }

        // Make request without @ to see errors
        $json = file_get_contents("http://auth.ssodemo.local/auth/validate?token=" . $token);
        $data = json_decode($json, true);
        var_dump($data, 22222222);
        die;

        if (empty($data['valid'])) {
            Response::redirect('http://auth.ssodemo.local/auth/login?redirect=' . urlencode('http://ssodemo.local'));
        }

        return "Xin chào, {$data['user']['name']}!<br>Vai trò: {$data['user']['role']}";
    }
}
