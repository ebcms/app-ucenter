<?php

declare(strict_types=1);

namespace App\Ebcms\Ucenter\Http\Admin;

use App\Ebcms\Admin\Http\Common;
use App\Ebcms\Admin\Model\Config as ModelConfig;
use Ebcms\Config as EbcmsConfig;
use Ebcms\FormBuilder\Builder;
use Ebcms\FormBuilder\Col;
use Ebcms\FormBuilder\Field\Input;
use Ebcms\FormBuilder\Field\Radio;
use Ebcms\FormBuilder\Field\Switchs;
use Ebcms\FormBuilder\Tab;
use Ebcms\FormBuilder\Row;
use Ebcms\Request;

class Config extends Common
{
    public function get(
        EbcmsConfig $config
    ) {
        $form = new Builder();
        $form->addRow(
            (new Row())->addCol(
                (new Col('col-md-9'))->addItem(
                    (new Tab())->addTab('基本设置', implode('', [
                        (new Radio('是否允许登陆', 'ebcms[ucenter][auth][allow_login]', $config->get('auth.allow_login@ebcms.ucenter'), [
                            '1' => '允许登陆',
                            '2' => '暂停登陆',
                        ])),
                        (new Input('自动登陆有效期', 'ebcms[ucenter][auth][expire_time]', $config->get('auth.expire_time@ebcms.ucenter', 0), 'number'))->set('help', '单位秒，在该时间内会自动登陆，推荐15天(1296000秒)'),
                    ]))->addTab('验证码设置', implode('', [
                        (new Switchs('短信通道', 'ebcms[ucenter][sms][handler]', $config->get('sms.handler@ebcms.ucenter', 'ebcms')))
                            ->addSwitch('官方通道', 'ebcms', implode('', [
                                (new Input('通信密钥', 'ebcms[ucenter][sms][ebcms_secret]', $config->get('sms.ebcms_secret@ebcms.ucenter')))->set('help', '请到<a href="https://www.ebcms.com" target="_blank">官网注册</a>后在会员中心获取')
                            ]))
                    ]))
                ),
                (new Col('col-md-3'))->addItem()
            )
        );
        return $form->__toString();
    }

    public function post(
        Request $request,
        ModelConfig $configModel
    ) {
        $configModel->save($request->post());
        return $this->success('更新成功！');
    }
}
