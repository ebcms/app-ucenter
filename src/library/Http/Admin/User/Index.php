<?php

declare(strict_types=1);

namespace App\Ebcms\Ucenter\Http\Admin\User;

use App\Ebcms\Admin\Http\Common;
use App\Ebcms\Ucenter\Model\User;
use Ebcms\Pagination;
use Ebcms\Request;
use Ebcms\Template;

class Index extends Common
{

    public function get(
        User $userModel,
        Request $request,
        Template $template,
        Pagination $pagination
    ) {
        $where = [];
        if ($request->get('state')) {
            $where['state'] = $request->get('state');
        }
        if ($request->get('user_id')) {
            $where['id'] = $request->get('user_id');
        }
        if ($request->get('q')) {
            $where['OR'] = [
                'id' => $request->get('q'),
                'phone[~]' => $request->get('q'),
                'nickname[~]' => $request->get('q'),
                'introduction[~]' => $request->get('q'),
            ];
        }
        $total = $userModel->count($where);

        $page = $request->get('page') ?: 1;
        $pagenum = $request->get('pagenum') ?: 20;
        $where['LIMIT'] = [($page - 1) * $pagenum, $pagenum];
        $where['ORDER'] = [
            'id' => 'DESC',
        ];

        return $this->html($template->renderFromFile('admin/user/index@ebcms/ucenter', [
            'users' => $userModel->select('*', $where),
            'total' => $total,
            'pages' => $pagination->render($page, $total, $pagenum),
        ]));
    }
}
