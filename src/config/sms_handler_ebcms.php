<?php

use Ebcms\App;
use Ebcms\Config;

return function ($phone, $code): bool {
    try {
        $secret = App::getInstance()->execute(function (
            Config $config
        ): string {
            return (string)$config->get('sms.ebcms_secret@ebcms.ucenter', '');
        });
        $url = 'https://www.ebcms.com/plugin/smsapi/client/send';
        $requestBody = http_build_query([
            'phone' => $phone,
            'code' => $code,
            'secret' => $secret,
        ]);
        $res = (array)json_decode(file_get_contents($url, false, stream_context_create([
            'http' => [
                'method' => 'POST',
                'timeout' => 5,
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n" . "Content-Length: " . mb_strlen($requestBody),
                'content' => $requestBody,
            ],
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ]
        ])), true);
        if ($res['status']) {
            return true;
        }
    } catch (Throwable $th) {
        return false;
    }
    return false;
};
