<?php

declare(strict_types=1);

namespace App\Ebcms\Ucenter\Http\Auth;

use App\Ebcms\Ucenter\Model\Log;
use App\Ebcms\Ucenter\Model\User;
use Ebcms\Config;
use Ebcms\Router;
use Ebcms\Request;
use Ebcms\Session;
use Ebcms\Template;

class Login extends Common
{

    public function get(
        Router $router,
        Request $request,
        Session $session,
        Config $config,
        Template $template
    ) {

        if ($config->get('auth.allow_login@ebcms.ucenter') != 1) {
            return $this->failure('暂时关闭登陆！');
        }

        if ($request->get('redirect_uri')) {
            $session->set('login_redirect_uri', $request->get('redirect_uri'));
        }

        return $this->html($template->renderFromFile('auth/login@ebcms/ucenter', [
            'router' => $router,
        ]));
    }

    public function post(
        Router $router,
        Request $request,
        User $userModel,
        Config $config,
        Log $log,
        Session $session
    ) {

        if ($config->get('auth.allow_login@ebcms.ucenter') != 1) {
            return $this->failure('暂时关闭登陆！');
        }

        if (!$code = $request->post('code')) {
            return $this->failure('请输入短信校验码！', '', 5);
        }

        if (!$verify_count = $session->get('verify_count')) {
            $session->delete('verify_count');
            $session->delete('verify_phone');
            $session->delete('verify_code');
            return $this->failure('请重新获取校验码！', '', 0);
        }
        $session->set('verify_count', $verify_count - 1);

        if ($code != $session->get('verify_code')) {
            if ($verify_count - 1 <= 0) {
                $session->delete('verify_count');
                $session->delete('verify_phone');
                $session->delete('verify_code');
                return $this->failure('短信校验码不正确！', '', 0);
            } else {
                return $this->failure('短信校验码不正确！剩余' . ($verify_count - 1) . '次校验机会！', '', $verify_count - 1);
            }
        }

        if (!$phone = $session->get('verify_phone')) {
            $session->delete('verify_count');
            $session->delete('verify_phone');
            $session->delete('verify_code');
            return $this->failure('非法操作！', '', 0);
        }

        if (!$user = $userModel->get('*', [
            'phone' => $phone,
        ])) {
            $userModel->insert([
                'phone' => $phone,
                'nickname' => '用户' . ($userModel->get('id', [
                    'ORDER' => [
                        'id' => 'DESC'
                    ]
                ]) + 1),
                'state' => $config->get('reg.default_state@ebcms.ucenter', 1),
                'salt' => md5(uniqid() . $phone),
            ]);
            $user = $userModel->get('*', [
                'phone' => $phone,
            ]);

            $log->record($user['id'], 'reg');
        }

        if ($user['state'] != 1) {
            $session->delete('verify_count');
            $session->delete('verify_phone');
            $session->delete('verify_code');
            return $this->failure('该账户无法登陆！', '', 0);
        }

        $session->delete('verify_count');
        $session->delete('verify_phone');
        $session->delete('verify_code');

        $userModel->login($user['id']);

        if ($url = $session->get('login_redirect_uri')) {
            $session->delete('login_redirect_uri');
        } else {
            $url = $router->buildUrl('/ebcms/ucenter/console/index');
        }

        return $this->success('登陆成功！', $url);
    }
}
