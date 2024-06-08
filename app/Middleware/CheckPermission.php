<?php

namespace App\Middleware;

use System\middleware\LoadMiddlewire;
use System\middleware\Middleware;

class CheckPermission extends Middleware
{
    use LoadMiddlewire;

    public function handle($param)
    {
        if (canAccess($param)) {
            return true;
        }

        return redirectTo(HOME);
    }

}
