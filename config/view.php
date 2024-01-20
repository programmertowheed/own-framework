<?php

use System\libs\View;

if (!function_exists('view')) {
    function view($path = '', $data = false)
    {
        $view = new View();
        $view->show($path, $data);
    }
}