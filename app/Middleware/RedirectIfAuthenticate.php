<?php

namespace App\Middleware;

use System\middleware\LoadMiddlewire;
use System\middleware\Middleware;

class RedirectIfAuthenticate extends Middleware
{
    use LoadMiddlewire;

    public function handle()
    {
        $uaer_data = getCookie(USER_COOKIE_NAME);
        if (isset($uaer_data) && isset($uaer_data->user_id)) {
            return redirectTo(DASHBOARD);
        }
        return true;
    }

}
