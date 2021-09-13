<?php

declare(strict_types=1);

namespace App\Ebcms\Ucenter\Http\Admin\User;

use App\Ebcms\Admin\Http\Common;
use App\Ebcms\Ucenter\Model\Log;
use App\Ebcms\Ucenter\Model\User;
use Ebcms\FormBuilder\Builder;
use Ebcms\FormBuilder\Col;
use Ebcms\FormBuilder\Field\Input;
use Ebcms\FormBuilder\Field\Textarea;
use Ebcms\FormBuilder\Row;
use Ebcms\Request;

class Score extends Common
{
    public function get(
        Request $request
    ) {

        $form = new Builder('金币操作');
        $form->addRow(
            (new Row())->addCol(
                (new Col('col-md-3'))->addItem(
                    (new Input('用户ID', 'user_id', $request->get('user_id', 0))),
                    (new Input('金币数量', 'num', 0, 'number')),
                    (new Textarea('原因', 'tips'))
                ),
                (new Col('col-md-9'))->addItem()
            )
        );
        return $form;
    }

    public function post(
        Request $request,
        Log $logModel,
        User $userModel
    ) {
        $score = $request->post('num', 0);
        if ($score == 0) {
            return $this->failure('参数错误~');
        }

        $user = $userModel->get('*', [
            'id' => $request->post('user_id', 0),
        ]);

        if ($score + $user['score'] < 0) {
            return $this->failure('数量不足！');
        }


        if ($score > 0) {
            $userModel->update([
                'score[+]' => $score,
            ], [
                'id' => $user['id'],
            ]);
        } elseif ($score < 0) {
            $userModel->update([
                'score[-]' => abs($score),
            ], [
                'id' => $user['id'],
            ]);
        }
        $logModel->record($user['id'], 'score', [
            'score' => $score,
            'tips' => $request->post('tips'),
        ]);

        return $this->success('操作成功！', 'javascript:history.go(-2)');
    }
}
