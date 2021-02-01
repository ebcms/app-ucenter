<?php

declare(strict_types=1);

namespace App\Ebcms\Ucenter\Http\Admin;

use App\Ebcms\Admin\Http\Common;
use App\Ebcms\Ucenter\Model\Log;
use Ebcms\RequestFilter;

class Stats extends Common
{

    public function get(
        Log $logModel,
        RequestFilter $input
    ) {
        $month = date('Y-m', strtotime($input->get('month', date('Y-m'))));

        $reg = [];
        $login = [];

        $days = $this->getMonthDays($month);

        for ($i = 0; $i < $days; $i++) {
            $date = $month . '-' . str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT);
            $reg[$date] = $logModel->count([
                'type' => 'reg',
                'record_date' => $date,
            ]);
            $login[$date] = $logModel->count([
                'type' => 'login',
                'record_date' => $date,
            ]);
        }

        $x = [
            'title' => [
                // 'text' => '趋势统计',
            ],
            'backgroundColor' => '#f5f5f5',
            'legend' => [
                'top' => 20,
                'data' => ['活跃用户', '新注册用户']
            ],
            'grid' => [
                'containLabel' => true
            ],
            'tooltip' => [
                'trigger' => 'axis'
            ],
            'yAxis' => [
                'type' => 'value',
            ],
            'xAxis' => [
                'type' => 'category',
                'boundaryGap' => false,
                'data' => array_keys($login)
            ],
            'series' => [[
                'name' => '新注册用户',
                'type' => 'line',
                'smooth' => true,
                'data' => array_values($reg),
            ], [
                'name' => '活跃用户',
                'type' => 'line',
                'smooth' => true,
                'data' => array_values($login),
            ]]
        ];

        return $this->json(json_encode($x));
    }

    private function getMonthDays(string $month): int
    {
        return (int)date('d', strtotime(date('Y-m-01 00:00:01', strtotime($month) + 86400 * 32)) - 100);
    }
}
