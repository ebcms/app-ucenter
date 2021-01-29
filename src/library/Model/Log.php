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
            'ip' => $this->getIp(),
            'http_raw' => $this->getHttpRaw(),
            'record_time' => time(),
            'record_date' => date('Y-m-d'),
        ]);
    }

    private function getIp(): string
    {
        if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } else if (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } else if (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
            $ip = getenv('REMOTE_ADDR');
        } else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return preg_match('/[\d\.]{7,15}/', $ip, $matches) ? $matches[0] : '';
    }

    private function getHttpRaw(): string
    {
        $raw = '';
        $raw .= $_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI'] . ' ' . $_SERVER['SERVER_PROTOCOL'] . "\r\n";
        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) === 'HTTP_') {
                $key = substr($key, 5);
                $key = str_replace('_', '-', $key);

                $raw .= $key . ': ' . $value . "\r\n";
            }
        }
        $raw .= "\r\n";
        $raw .= file_get_contents('php://input');
        return $raw;
    }
}
