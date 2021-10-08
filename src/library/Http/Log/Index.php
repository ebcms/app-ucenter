<?php

declare(strict_types=1);

namespace App\Ebcms\Ucenter\Http\Log;

use App\Ebcms\Admin\Http\Common;
use App\Ebcms\Ucenter\Model\Log;
use Ebcms\Pagination;
use Ebcms\Request;
use Ebcms\Template;

class Index extends Common
{
    public function get(
        Log $logModel,
        Request $request,
        Template $template,
        Pagination $pagination
    ) {
        $where = [];
        if ($request->get('user_id')) {
            $where['user_id'] = $request->get('user_id');
        }
        if ($request->get('type')) {
            $where['type'] = $request->get('type');
        }
        $total = $logModel->count($where);

        $page = $request->get('page') ?: 1;
        $pagenum = $request->get('pagenum') ?: 20;
        $where['LIMIT'] = [($page - 1) * $pagenum, $pagenum];
        $where['ORDER'] = [
            'id' => 'DESC',
        ];

        return $template->renderFromFile('log/index@ebcms/ucenter', [
            'logs' => $logModel->select('*', $where),
            'total' => $total,
            'pages' => $pagination->render($page, $total, $pagenum),
        ]);
    }
}
