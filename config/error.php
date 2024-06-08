<?php

if (!function_exists('customErrorHandler')) {
    // Define custom error handler
    function customErrorHandler($errno, $errstr, $errfile, $errline)
    {
        // Log error details to a file or database
        error_log("Error [$errno]: $errstr in $errfile on line $errline", 3, '/path/to/your/error.log');

        // Redirect to custom error page
        include BASE_PATH . "system/view/error/500.php";
        exit();
    }
}

if (!function_exists('customExceptionHandler')) {
    // Define custom exception handler
    function customExceptionHandler($exception)
    {
        // Log exception details to a file or database
        error_log("Exception: " . $exception->getMessage(), 3, '/path/to/your/exception.log');

        // Redirect to custom error page
        include BASE_PATH . "system/view/error/500.php";
        exit();
    }
}

// Set custom error and exception handlers
set_error_handler('customErrorHandler');
set_exception_handler('customExceptionHandler');
