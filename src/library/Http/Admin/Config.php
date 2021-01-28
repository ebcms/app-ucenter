<?php

declare(strict_types=1);

namespace App\Ebcms\Ucenter\Http\Admin;

use App\Ebcms\Admin\Http\Common;
use App\Ebcms\Admin\Model\Config as ModelConfig;
use Ebcms\Config as EbcmsConfig;
use Ebcms\FormBuilder\Builder;
use Ebcms\FormBuilder\Col;
use Ebcms\FormBuilder\Field\Radio;
use Ebcms\FormBuilder\Row;
use Ebcms\RequestFilter;

class Config extends Common
{
    public function get(
        EbcmsConfig $config
    ) {
        $form = new Builder();
        $form->addRow(
            (new Row())->addCol(
                (new Col('col-md-9'))->addItem(
                    (new Radio('是否允许登陆', 'ebcms[ucenter][auth][allow_login]', $config->get('auth.allow_login@ebcms.ucenter'), [[
                        'label' => '允许登陆',
                        'value' => 1,
                    ], [
                        'label' => '暂停登陆',
                        'value' => 2,
                    ]]))->set('help', '...')
                ),
                (new Col('col-md-3'))->addItem()
            )
        );
        return $form->__toString();
    }

    public function post(
        RequestFilter $input,
        ModelConfig $configModel
    ) {
        $configModel->save($input->post());
        return $this->success('更新成功！');
    }
}
