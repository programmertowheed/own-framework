<?php

use System\response\Response;

if (!function_exists('response')) {
    function response()
    {
        return new Response();
    }
}

