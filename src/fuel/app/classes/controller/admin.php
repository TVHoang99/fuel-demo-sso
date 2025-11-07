<?php

class Controller_Admin extends Controller
{
    public function action_index()
    {
        $token = Cookie::get('sso_token');
        if (!$token) {
            Response::redirect('http://auth.ssodemo.local/auth/login?redirect=' . urlencode('http://admin.ssodemo.local'));
        }

        $json = file_get_contents("http://auth.ssodemo.local/auth/validate?token={$token}");
        $data = json_decode($json, true);

        if (empty($data['valid']) || $data['user']['role'] !== 'admin') {
            return Response::forge("Bạn không có quyền truy cập trang quản trị.", 403);
        }

        return "Xin chào quản trị viên {$data['user']['name']}!";
    }
}
