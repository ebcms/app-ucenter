<?php

declare(strict_types=1);

namespace App\Ebcms\Ucenter\Http\Admin\User;

use App\Ebcms\Admin\Http\Common;
use App\Ebcms\Ucenter\Model\User;
use Ebcms\Pagination;
use Ebcms\RequestFilter;
use Ebcms\Template;

class Index extends Common
{

    public function get(
        User $userModel,
        RequestFilter $input,
        Template $template,
        Pagination $pagination
    ) {
        $where = [];
        if ($input->get('state')) {
            $where['state'] = $input->get('state');
        }
        if ($input->get('user_id')) {
            $where['id'] = $input->get('user_id');
        }
        if ($input->get('q')) {
            $where['OR'] = [
                'id' => $input->get('q'),
                'phone[~]' => $input->get('q'),
                'email[~]' => $input->get('q'),
                'nickname[~]' => $input->get('q'),
                'introduction[~]' => $input->get('q'),
            ];
        }
        $total = $userModel->count($where);

        $page = $input->get('page') ?: 1;
        $pagenum = $input->get('pagenum') ?: 20;
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
