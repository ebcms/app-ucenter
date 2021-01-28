<?php

declare(strict_types=1);

namespace App\Ebcms\Ucenter\Model;

use Ebcms\Database\Model;

class Log extends Model
{

    public function getTable(): string
    {
        return 'ebcms_user_log';
    }

    public function record(int $user_id, string $type, array $context = [])
    {
        $this->insert([
            'user_id' => $user_id,
            'type' => $type,
            'context' => serialize($context),
            'ip' => ip2long($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0'),
            'ua' => $_SERVER['HTTP_USER_AGENT'] ?? '',
            'record_time' => time(),
        ]);
    }
}
