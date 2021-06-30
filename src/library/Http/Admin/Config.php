<?php

declare(strict_types=1);

namespace App\Ebcms\Ucenter\Http\Admin;

use App\Ebcms\Admin\Http\Common;
use App\Ebcms\Admin\Model\Config as ModelConfig;
use Ebcms\Config as EbcmsConfig;
use Ebcms\FormBuilder\Builder;
use Ebcms\FormBuilder\Col;
use Ebcms\FormBuilder\Field\Number;
use Ebcms\FormBuilder\Field\Radio;
use Ebcms\FormBuilder\Field\Text;
use Ebcms\FormBuilder\Other\Switchs;
use Ebcms\FormBuilder\Other\Tab;
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
                    (new Tab())->addTab('基本设置', ...(function () use ($config): array {
                        $res = [];
                        $res[] = (new Radio('是否允许登陆', 'ebcms[ucenter][auth][allow_login]', $config->get('auth.allow_login@ebcms.ucenter'), [[
                            'label' => '允许登陆',
                            'value' => 1,
                        ], [
                            'label' => '暂停登陆',
                            'value' => 2,
                        ]]))->set('help', '...');
                        $res[] = (new Number('自动登陆有效期', 'ebcms[ucenter][auth][expire_time]', $config->get('auth.expire_time@ebcms.ucenter', 0)))->set('help', '单位秒，在该时间内会自动登陆，推荐15天(1296000秒)');
                        return $res;
                    })())->addTab('验证码设置', ...(function () use ($config): array {
                        $res = [];
                        $res[] = (new Switchs('短信通道', 'ebcms[ucenter][sms][handler]', $config->get('sms.handler@ebcms.ucenter', 'ebcms')))
                            ->addSwitch('官方通道', 'ebcms', ...(function () use ($config): array {
                                $res = [];
                                $res[] = (new Text('通信密钥', 'ebcms[ucenter][sms][ebcms_secret]', $config->get('sms.ebcms_secret@ebcms.ucenter')))->set('help', '请到<a href="https://www.ebcms.com" target="_blank">官网注册</a>后在会员中心获取');
                                return $res;
                            })());
                        return $res;
                    })())
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
