<?php
define("BASE_PATH", __DIR__ . "/../");
define("APP_URL", env("APP_URL", "http://localhost"));
define("BASE_URL", env("APP_URL", "http://localhost"));
define("ADMIN_URL", env("ADMIN_URL", "http://localhost/admin"));

// Database
define("DB_HOST", env("DB_HOST", "localhost"));
define("DB_PORT", env("DB_PORT", "3306"));
define("DB_CHARSET", env("DB_CHARSET", "utf8mb4"));
define("DB_NAME", env("DB_NAME", "dbname"));
define("DB_USER", env("DB_USER", "root"));
define("DB_PASSWORD", env("DB_PASSWORD", ""));


define("METHOD_ARRAY", [
    'GET', 'POST', 'PUT', "PATCH", "DELETE"
]);


?>