<?php

declare(strict_types=1);

namespace App\Ebcms\Ucenter\Http\Auth;

use App\Ebcms\Ucenter\Model\Log;
use App\Ebcms\Ucenter\Model\User;
use Ebcms\Config;
use Ebcms\RequestFilter;
use Ebcms\Session;

class SendCode extends Common
{

    public function post(
        Config $config,
        RequestFilter $input,
        Log $log,
        User $user,
        Session $session
    ) {
        $captcha = $input->post('captcha');
        if (!$captcha || $captcha != $session->get('ucenter_auth_captcha')) {
            return $this->failure('验证码不正确！');
        }
        $session->delete('ucenter_auth_captcha');

        if ($config->get('auth.allow_login@ebcms.ucenter') != 1) {
            return $this->failure('暂时关闭登陆！');
        }

        $code = random_int(100000, 999999);
        $phone = $input->post('phone');

        $handler = $config->get('sendcode_handler@ebcms.ucenter');
        if (!$handler || !is_callable($handler)) {
            return $this->failure('未配置校验码发送方式！');
        }
        if (true !== $handler($phone, $code)) {
            return $this->failure('校验码发送失败！');
        }

        $log->record($user->get('id', [
            'phone' => $phone,
        ]) ?: 0, '发送校验码', [
            'phone' => $phone
        ]);

        $session->set('verify_count', 5);
        $session->set('verify_phone', $phone);
        $session->set('verify_code', $code);

        return $this->success('校验码发送成功！');
    }
}
