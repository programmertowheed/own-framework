<?php

// Load env file
require_once __DIR__ . "/../config/env.php";

// Load config file
require_once __DIR__ . "/../config/config.php";

// App error debugging
if (DEBUG && DEBUG == "true") {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
//    error_reporting(E_ALL);
    require_once __DIR__ . "/../config/error.php";
}

// Load config file
$load_config = [
//    "env",
//    "config",
    "app",
    "request",
    "response",
    "redirect",
    "helper",
    "database",
    "middleware",
    "view",
];


foreach ($load_config as $file) {
    require_once __DIR__ . "/../config/" . $file . ".php";
}

// Call middleware for web which is call every request
middleware();


// App route
require_once __DIR__ . "/../config/route.php";