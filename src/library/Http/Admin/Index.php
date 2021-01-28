<?php

declare(strict_types=1);

namespace App\Ebcms\Ucenter\Http\Admin;

use App\Ebcms\Admin\Http\Common;
use Ebcms\Template;

class Index extends Common
{

    public function get(
        Template $template
    ) {
        return $this->html($template->renderFromFile('admin/index@ebcms/ucenter', []));
    }
}
