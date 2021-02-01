<?php

declare(strict_types=1);

namespace App\Ebcms\Ucenter\Http\Console;

use App\Ebcms\Ucenter\Model\Log;
use App\Ebcms\Ucenter\Model\User;
use Ebcms\Router;
use Psr\Http\Message\ResponseInterface;
use Ebcms\FormBuilder\Builder;
use Ebcms\FormBuilder\Col;
use Ebcms\FormBuilder\Field\Text;
use Ebcms\FormBuilder\Field\Textarea;
use Ebcms\FormBuilder\Other\Cover;
use Ebcms\FormBuilder\Row;
use Ebcms\RequestFilter;

class EditInfo extends Common
{

    public function get(
        Router $router,
        User $userModel
    ) {
        $my = $userModel->get('*', [
            'id' => $userModel->getLoginId(),
        ]);
        $form = new Builder('修改个人信息');
        $form->addRow(
            (new Row())->addCol(
                (new Col('col-md-3'))->addItem(
                    (new Cover('头像', 'avatar', $my['avatar'], $router->buildUrl('/ebcms/ucenter/console/upload')))
                ),
                (new Col('col-md-9'))->addItem(
                    (new Text('昵称', 'nickname', $my['nickname'])),
                    (new Textarea('个人简介', 'introduction', $my['introduction']))
                )
            )
        );
        return $form;
    }

    public function post(
        User $userModel,
        Log $logModel,
        RequestFilter $input
    ): ResponseInterface {
        $update = [];
        if ($input->has('post.introduction')) {
            $update['introduction'] = $input->post('introduction');
        }
        if ($input->has('post.avatar')) {
            $update['avatar'] = $input->post('avatar');
        }
        if (trim($input->post('nickname'))) {
            $update['nickname'] = mb_substr(trim($input->post('nickname')), 0, 8);
        }
        if ($update) {
            $userModel->update($update, [
                'id' => $userModel->getLoginId(),
            ]);
        }

        $logModel->record($userModel->getLoginId(), 'edit_info', $update);

        return $this->success('操作成功！', 'javascript:history.go(-2);');
    }
}
