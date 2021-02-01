<?php

declare(strict_types=1);

namespace App\Ebcms\Ucenter\Http\Auth;

use App\Ebcms\Ucenter\Model\Log;
use App\Ebcms\Ucenter\Model\User;
use Ebcms\Router;

class Logout extends Common
{

    public function get(
        Router $router,
        User $userModel,
        Log $logModel
    ) {
        $logModel->record($userModel->getLoginId(), 'logout');
        $userModel->logout();
        return $this->success('已退出！', $router->buildUrl('/ebcms/ucenter/auth/login'));
    }
}
