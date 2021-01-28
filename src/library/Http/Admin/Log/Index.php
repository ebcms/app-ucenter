<?php

declare(strict_types=1);

namespace App\Ebcms\Ucenter\Http\Admin\Log;

use App\Ebcms\Admin\Http\Common;
use App\Ebcms\Ucenter\Model\Log;
use Ebcms\Pagination;
use Ebcms\RequestFilter;
use Ebcms\Template;

class Index extends Common
{
    public function get(
        Log $logModel,
        RequestFilter $input,
        Template $template,
        Pagination $pagination
    ) {
        $where = [];
        if ($input->get('user_id')) {
            $where['user_id'] = $input->get('user_id');
        }
        if ($input->get('type')) {
            $where['type'] = $input->get('type');
        }
        $total = $logModel->count($where);

        $page = $input->get('page') ?: 1;
        $pagenum = $input->get('pagenum') ?: 20;
        $where['LIMIT'] = [($page - 1) * $pagenum, $pagenum];
        $where['ORDER'] = [
            'id' => 'DESC',
        ];

        return $template->renderFromFile('admin/log/index@ebcms/ucenter', [
            'logs' => $logModel->select('*', $where),
            'total' => $total,
            'pages' => $pagination->render($page, $total, $pagenum),
        ]);
    }
}
