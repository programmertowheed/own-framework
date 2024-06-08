<?php

namespace App\Controllers\Auth;

use System\libs\Controller;

/**
 * Login Controller
 */
class LoginController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    // home page
    public function login()
    {
        return view("auth.login");
    }

}

?>