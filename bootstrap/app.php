<?php

$load_config = [
    "env",
    "config",
    "request",
    "response",
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