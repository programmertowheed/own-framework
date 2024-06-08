<?php
define("BASE_PATH", __DIR__ . "/../");
define("APP_URL", env("APP_URL", "http://localhost/elephant"));
define("API_URL", env("API_URL", "http://localhost/elephant/api"));
define("BASE_URL", env("APP_URL", APP_URL));
define("DEBUG", env("APP_DEBUG", "false"));

// Database
define("DB_HOST", env("DB_HOST", "localhost"));
define("DB_PORT", env("DB_PORT", "3306"));
define("DB_CHARSET", env("DB_CHARSET", "utf8mb4"));
define("DB_NAME", env("DB_NAME", "dbname"));
define("DB_USER", env("DB_USER", "root"));
define("DB_PASSWORD", env("DB_PASSWORD", ""));


define("USER_COOKIE_NAME", env("USER_COOKIE_NAME", "userData")); // cookie name for store user info
define("USER_COOKIE_TIME", env("USER_COOKIE_TIME", "1")); // Cookie Time in day default 1 day
define("HOME", env("HOME", "/"));
define("DASHBOARD", env("DASHBOARD", "/dashboard"));


//cors origin
const CORS_ORIGIN_ARRAY = ['http://localhost', 'http://127.0.0.1'];

// Request method
const METHOD_ARRAY = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'];


?>