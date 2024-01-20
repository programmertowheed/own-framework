<?php

use System\request\Request;

if (!function_exists('request')) {
    function request()
    {
        $request = new Request();
        return $request->serverRequest();
    }
}