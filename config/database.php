<?php

use System\libs\Model;

if (!function_exists('DB')) {
    function DB()
    {
        return new Model();
    }
}