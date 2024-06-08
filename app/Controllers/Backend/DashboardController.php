<?php

namespace App\Controllers\Backend;

use System\libs\Controller;

/**
 * Dashboard Controller
 */
class DashboardController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    // home page
    public function dashboard()
    {
        return view("backend.dashboard");
    }

}

?>