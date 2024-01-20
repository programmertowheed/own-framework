<?php

// Looing for .env at the root directory
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

function env($key, $value = null)
{
    if (!array_key_exists($key, $_ENV)) {
        return $value;
    }
    return $_ENV[$key] ? $_ENV["$key"] : $value;
}

function config($key)
{
    if (array_key_exists($key, $_ENV)) {
        return $_ENV[$key];
    }
    return null;
}
