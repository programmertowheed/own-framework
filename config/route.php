<?php

use System\route\Base as Route;

$route_file = [
    "api"
];


foreach ($route_file as $file) {
    require_once __DIR__ . "/../route/" . $file . ".php";
}

Route::route();