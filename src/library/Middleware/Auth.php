<?php

declare(strict_types=1);

namespace App\Ebcms\Ucenter\Middleware;

use App\Ebcms\Admin\Traits\ResponseTrait;
use App\Ebcms\Ucenter\Model\User;
use Ebcms\App;
use Ebcms\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Auth implements MiddlewareInterface
{
    use ResponseTrait;

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        return App::getInstance()->execute(function (
            User $userModel,
            Router $router
        ) use ($request, $handler): ResponseInterface {
            if (!$userModel->getLoginId()) {
                return $this->failure('请登陆！', $router->buildUrl('/ebcms/ucenter/auth/login', [
                    'redirect_uri' => $this->getRedirectUri()
                ]));
            }
            return $handler->handle($request);
        });
    }

    private function getRedirectUri(): string
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            return $_SERVER['REQUEST_URI'];
        } else {
            return $_SERVER['HTTP_REFERER'] ?? '';
        }
    }
}
