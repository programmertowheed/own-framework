<?php

use App\Middleware\Register;

if (!function_exists("middleware")) {
    function middleware()
    {
        (new Register())->middlewareForWeb();
    }

}