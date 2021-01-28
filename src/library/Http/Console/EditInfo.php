<?php

declare(strict_types=1);

namespace App\Ebcms\Ucenter\Http\Console;

use App\Ebcms\Ucenter\Model\Log;
use App\Ebcms\Ucenter\Model\User;
use Ebcms\Router;
use Psr\Http\Message\ResponseInterface;
use Ebcms\FormBuilder\Builder;
use Ebcms\FormBuilder\Field\Textarea;
use Ebcms\FormBuilder\Other\Cover;
use Ebcms\RequestFilter;
use Ebcms\Session;

class EditInfo extends Common
{

    public function get(
        Router $router,
        Session $session,
        User $user
    ) {
        $my = $user->get('*', $session->get('ucenter_user_id'));
        $form = new Builder('修改个人信息');
        $form->addItem(
            (new Cover('头像', 'avatar', $my['avatar'], $router->buildUrl('/ebcms/ucenter/console/upload'))),
            (new Textarea('个人简介', 'introduction', $my['introduction']))
        );
        return $this->html($form->__toString());
    }

    public function post(
        Session $session,
        User $userModel,
        Log $log,
        RequestFilter $input
    ): ResponseInterface {
        $update = [];
        if ($input->has('post.introduction')) {
            $update['introduction'] = $input->post('introduction');
        }
        if ($input->has('post.avatar')) {
            $update['avatar'] = $input->post('avatar');
        }
        if ($update) {
            $userModel->update($update, [
                'id' => $session->get('ucenter_user_id'),
            ]);
        }

        $log->record($session->get('ucenter_user_id'), '修改个人信息', $update);

        return $this->success('操作成功！', 'javascript:history.back(-2);');
    }
}
