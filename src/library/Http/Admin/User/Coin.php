<?php

declare(strict_types=1);

namespace App\Ebcms\Ucenter\Http\Admin\User;

use App\Ebcms\Admin\Http\Common;
use App\Ebcms\Ucenter\Model\Log;
use App\Ebcms\Ucenter\Model\User;
use Ebcms\FormBuilder\Builder;
use Ebcms\FormBuilder\Col;
use Ebcms\FormBuilder\Field\Number;
use Ebcms\FormBuilder\Field\Text;
use Ebcms\FormBuilder\Field\Textarea;
use Ebcms\FormBuilder\Row;
use Ebcms\Request;

class Coin extends Common
{
    public function get(
        Request $input
    ) {

        $form = new Builder('金币操作');
        $form->addRow(
            (new Row())->addCol(
                (new Col('col-md-3'))->addItem(
                    (new Text('用户ID', 'user_id', $input->get('user_id', 0, ['intval']))),
                    (new Number('金币数量', 'num')),
                    (new Textarea('原因', 'tips')),
                ),
                (new Col('col-md-9'))->addItem()
            )
        );
        return $form;
    }

    public function post(
        Request $input,
        Log $logModel,
        User $userModel
    ) {
        $coin = $input->post('num', 0, ['intval']);
        if ($coin == 0) {
            return $this->failure('参数错误~');
        }

        $user = $userModel->get('*', [
            'id' => $input->post('user_id', 0, ['intval']),
        ]);

        if ($coin + $user['coin'] < 0) {
            return $this->failure('数量不足！');
        }


        if ($coin > 0) {
            $userModel->update([
                'coin[+]' => $coin,
            ], [
                'id' => $user['id'],
            ]);
        } elseif ($coin < 0) {
            $userModel->update([
                'coin[-]' => abs($coin),
            ], [
                'id' => $user['id'],
            ]);
        }
        $logModel->record($user['id'], 'coin', [
            'coin' => $coin,
            'tips' => $input->post('tips'),
        ]);

        return $this->success('操作成功！', 'javascript:history.go(-2)');
    }
}
