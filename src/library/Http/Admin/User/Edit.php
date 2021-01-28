<?php

declare(strict_types=1);

namespace App\Ebcms\Ucenter\Http\Admin\User;

use App\Ebcms\Admin\Http\Common;
use App\Ebcms\Ucenter\Model\User;
use Ebcms\Router;
use Ebcms\FormBuilder\Builder;
use Ebcms\FormBuilder\Col;
use Ebcms\FormBuilder\Field\Hidden;
use Ebcms\FormBuilder\Field\Radio;
use Ebcms\FormBuilder\Field\Text;
use Ebcms\FormBuilder\Field\Textarea;
use Ebcms\FormBuilder\Other\Cover;
use Ebcms\FormBuilder\Row;
use Ebcms\RequestFilter;

class Edit extends Common
{
    public function get(
        Router $router,
        User $userModel,
        RequestFilter $requestFilter
    ) {
        $user = $userModel->get('*', [
            'id' => $requestFilter->get('id', 0, ['intval']),
        ]);

        $radio_option = [
            [
                'label' => '正常',
                'value' => 1,
            ], [
                'label' => '禁止登陆',
                'value' => 2,
            ], [
                'label' => '待审核',
                'value' => 99,
            ],
        ];
        $form = new Builder('编辑用户信息');
        $form->addRow(
            (new Row())->addCol(
                (new Col('col-md-8'))->addItem(
                    (new Hidden('id', $user['id'])),
                    (new Cover('头像', 'avatar', $user['avatar'], $router->buildUrl('/ebcms/admin/upload'))),
                    (new Text('昵称', 'nickname', $user['nickname'])),
                    (new Textarea('个人说明', 'introduction', $user['introduction'])),
                    (new Text('电话号码', 'phone', $user['phone'])),
                    (new Radio('状态', 'state', $user['state']))->set('options', $radio_option)->set('inline', true)
                )
            )
        );
        return $this->html($form->__toString());
    }

    public function post(
        RequestFilter $requestFilter,
        User $userModel
    ) {
        $user = $userModel->get('*', [
            'id' => $requestFilter->post('id', 0, ['intval']),
        ]);

        $update = array_intersect_key($requestFilter->post(), [
            'avatar' => '',
            'nickname' => '',
            'introduction' => '',
            'phone' => '',
            'state' => '',
        ]);
        $update = array_merge($user, $update);

        $userModel->update($update, [
            'id' => $user['id'],
        ]);

        return $this->success('操作成功！', 'javascript:history.go(-2)');
    }
}
