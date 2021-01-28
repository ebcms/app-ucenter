<?php

declare(strict_types=1);

namespace App\Ebcms\Ucenter\Http\Auth;

use Ebcms\Captcha as EbcmsCaptcha;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Ebcms\Session;

class Captcha extends Common
{
    public function get(
        Session $session,
        ResponseFactoryInterface $responseFactory,
        EbcmsCaptcha $captcha
    ): ResponseInterface {
        $num = mt_rand(1000, 9999);
        $session->set('ucenter_auth_captcha', $num);
        $response = $responseFactory->createResponse(200);
        $response->getBody()->write($captcha->create((string)$num));
        return $response->withHeader('Content-Type', 'image/png');
    }
}
