<?php

declare(strict_types=1);

namespace App\Ebcms\Ucenter\Http\Auth;

use App\Ebcms\Ucenter\Model\Log;
use Ebcms\Router;
use Ebcms\Session;

class Logout extends Common
{

    public function get(
        Router $router,
        Log $log,
        Session $session
    ) {
        $log->record($session->get('ucenter_user_id'), '退出登陆');

        $session->delete('ucenter_user_id');

        return $this->success('已退出！', $router->buildUrl('/ebcms/ucenter/auth/login'));
    }
}
