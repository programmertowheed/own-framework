<?php

namespace App\Controllers;

use System\libs\Controller;

/**
 * Home Controller
 */
class HomeController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    // home page
    public function home()
    {
        return view("home");
    }

}

?>