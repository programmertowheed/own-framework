<?php

namespace App\Middleware;

use System\middleware\LoadMiddlewire;
use System\middleware\Middleware;

class Auth extends Middleware
{
    use LoadMiddlewire;

    public function handle()
    {
//        echo "<pre>";
//        print_r($this->request);
//        echo "</pre>";
//        exit();
//        echo "hello";
        return true;
    }

}
