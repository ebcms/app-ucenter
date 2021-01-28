<?php

declare(strict_types=1);

namespace App\Ebcms\Ucenter\Http\Console;

use App\Ebcms\Admin\Traits\ResponseTrait;
use App\Ebcms\Admin\Traits\RestfulTrait;
use App\Ebcms\Ucenter\Middleware\Auth;
use Ebcms\App;
use Ebcms\RequestHandler;

abstract class Common
{
    use RestfulTrait;
    use ResponseTrait;

    public function __construct()
    {
        App::getInstance()->execute(function (
            RequestHandler $requestHandler
        ) {
            $requestHandler->lazyMiddleware(Auth::class);
        });
    }
}
