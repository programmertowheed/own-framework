<?php

if (!function_exists('call_maintenance')) {
    // Define custom exception handler
    function call_maintenance()
    {
        // Redirect to custom error page
        include BASE_PATH . "system/view/error/maintenance.php";
        exit();
    }

}

if (defined('MAINTENANCE_MODE') && MAINTENANCE_MODE == "true") {
    call_maintenance();
}


