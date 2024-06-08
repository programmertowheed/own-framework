<?php

use System\redirect\Redirect;

if (!function_exists('redirect')) {
    function redirect()
    {
        return new Redirect();
    }
}

