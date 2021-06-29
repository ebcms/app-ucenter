<?php

declare(strict_types=1);

namespace App\Ebcms\Ucenter\Http\Admin\Log;

use App\Ebcms\Admin\Http\Common;
use App\Ebcms\Ucenter\Model\Log;
use Ebcms\Request;
use Ebcms\Template;

class Detail extends Common
{
    public function get(
        Log $logModel,
        Request $request,
        Template $template
    ) {
        if (!$log = $logModel->get('*', [
            'id' => $request->get('id'),
        ])) {
            return $this->failure('不存在！');
        }

        return $template->renderFromFile('admin/log/detail@ebcms/ucenter', [
            'log' => $log,
        ]);
    }
}
