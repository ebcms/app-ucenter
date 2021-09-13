<?php

declare(strict_types=1);

namespace App\Ebcms\Ucenter\Http\Admin\User;

use App\Ebcms\Admin\Http\Common;
use App\Ebcms\Ucenter\Model\User;
use Ebcms\Router;
use Ebcms\FormBuilder\Builder;
use Ebcms\FormBuilder\Col;
use Ebcms\FormBuilder\Field\Cover;
use Ebcms\FormBuilder\Field\Hidden;
use Ebcms\FormBuilder\Field\Input;
use Ebcms\FormBuilder\Field\Radio;
use Ebcms\FormBuilder\Field\Textarea;
use Ebcms\FormBuilder\Row;
use Ebcms\Request;

class Edit extends Common
{
    public function get(
        Router $router,
        User $userModel,
        Request $request
    ) {
        $user = $userModel->get('*', [
            'id' => $request->get('id', 0),
        ]);

        $form = new Builder('编辑用户信息');
        $form->addRow(
            (new Row())->addCol(
                (new Col('col-md-3'))->addItem(
                    (new Hidden('id', $user['id'])),
                    (new Cover('头像', 'avatar', $user['avatar'], $router->buildUrl('/ebcms/admin/upload'))),
                    (new Input('电话号码', 'phone', $user['phone'])),
                    (new Radio('状态', 'state', $user['state'], [
                        '1' => '正常',
                        '2' => '禁止登陆',
                        '99' => '待审核',
                    ]))
                ),
                (new Col('col-md-9'))->addItem(
                    (new Input('昵称', 'nickname', $user['nickname'])),
                    (new Textarea('个人说明', 'introduction', $user['introduction']))
                )
            )
        );
        return $this->html($form->__toString());
    }

    public function post(
        Request $request,
        User $userModel
    ) {
        $user = $userModel->get('*', [
            'id' => $request->post('id', 0),
        ]);

        $update = array_intersect_key($request->post(), [
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
