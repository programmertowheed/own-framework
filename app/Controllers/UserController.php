<?php

namespace App\Controllers;

use App\Models\User;
use System\libs\Controller;

/**
 * Order Controller
 */
class UserController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    // User login
    public function login()
    {
        $email = isset(request()->email) ? request()->email : "";
        $pass = isset(request()->pass) ? request()->pass : "";

        if ($email != "" || $pass != "") {
            $user = new User();

            $user->Login($email, $pass);
        } else {
            return response()->json(["status" => false, "message" => "Email and password are required!."]);
        }
    }

    // Get user list
    public function getUserList()
    {
        $UserModel = new User();
        $data = $UserModel->getAllUserList();
        return response()->json(['status' => true, "message" => "Successful", "data" => $data]);
    }

    // Get user type list
    public function getUserTypeList()
    {
        $user = new User();
        $result = $user->getAllUserTypeList();

        $list = '<option disabled selected value="">Pick User Type</option>';
        if (count($result) > 0) {
            foreach ($result as $item) {
                $list .= '<option value="' . $item['u_type_id'] . '" >' . $item['u_type_name'] . '</option>';
            }

            return response()->json(["status" => true, "message" => "Successful", "data" => $list]);
        } else {
            return response()->json(["status" => false, "message" => "Record not found!", "data" => $list]);
        }
    }

    // Check user name
    public function checkUsername()
    {
        $user = new User();
        $result = $user->checkUsernameIsAvailable();

        $status = isset($result['status']) ? $result['status'] : false;
        $message = isset($result['message']) ? $result['message'] : "";

        $data = isset($result['data']) ? $result['data'] : "";

        return response()->json(["status" => $status, "message" => $message, "data" => $data]);
    }

    // get user info
    public function getUserInfo()
    {
        $user = new User();
        $result = $user->getSingleUser();

        $status = isset($result['status']) ? $result['status'] : false;
        $message = isset($result['message']) ? $result['message'] : "";
        $data = isset($result['data']) ? $result['data'] : [];

        return response()->json(["status" => $status, "message" => $message, "data" => $data]);
    }

    // add user
    public function userAdd()
    {
        $UserModel = new User();
        $result = $UserModel->addOrUpdateUser();

        $data = $UserModel->getAllUserList();

        $status = isset($result['status']) ? $result['status'] : false;
        $message = isset($result['message']) ? $result['message'] : "";

        return response()->json(["status" => $status, "message" => $message, "data" => $data]);

    }

    // Change password page
    public function changePasswordPage()
    {
        return view("backend.user.changepassword");
    }

    // Chnage user password
    public function changePassword()
    {
        $UserModel = new User();
        $result = $UserModel->changeUserPassword();

        $status = isset($result['status']) ? $result['status'] : false;
        $message = isset($result['message']) ? $result['message'] : "";

        return response()->json(["status" => $status, "message" => $message]);

    }


}
