<?php

declare(strict_types=1);

namespace App\Ebcms\Ucenter\Http;

use App\Ebcms\Admin\Http\Common;
use App\Ebcms\Ucenter\Model\User;
use Ebcms\Template;

class Index extends Common
{

    public function get(
        User $userModel,
        Template $template
    ) {
        $data = [];
        $data['total'] = $userModel->count();
        return $this->html($template->renderFromFile('index@ebcms/ucenter', $data));
    }
}
