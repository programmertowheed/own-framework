<?php

namespace App\Controllers;

use App\Middleware\Auth;
use App\Models\User;
use System\libs\Controller;

/**
 * Towheed Controller
 */
class Towheed extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get()
    {
//        $user = new User();
//        $user = $user->userList();
//        $user = DB()->query("SELECT * FROM users WHERE id = :id", ["id" => 2])->get();
//        $auth = new Auth();
//        echo "<pre>";
//        print_r($auth);
//        echo "</pre>";
//        exit();
        $data = [
            "page" => "Home",
            "name" => "Programmer Towheed",
            "age" => 28
        ];

        return view("home", $data);
    }

    public function getNew($params)
    {
//        echo $params["name"];
        exit();
        echo "Call From getNew Method";
    }

    public function post()
    {
//        echo request()->ip;

        echo "Call From post Method";
    }

    public function put()
    {
        echo "Call From put Method";
    }

    public function delete()
    {
        echo "Call From delete Method";
    }


}

?>