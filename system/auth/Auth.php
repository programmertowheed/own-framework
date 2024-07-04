<?php

namespace System\auth;

class Auth
{
    public function __construct()
    {
    }

    // Check authentication
    public static function check()
    {
        $uaer_data = getCookie(USER_COOKIE_NAME);

        if (isset($uaer_data) && isset($uaer_data->user_id)) {
            $email = isset($uaer_data->user_id) ? $uaer_data->user_id : "";

            if ($email != "") {
                $sql = "SELECT * FROM user WHERE userid ='$email' AND status ='Active'";
                $result = DB()->query($sql)->get();

                if (isset($result->userid)) {
                    $cookieValue = array(
                        'project_id' => isset($result->project_id) ? $result->project_id : "",
                        'full_name' => isset($result->fullname) ? $result->fullname : "",
                        'user_id' => isset($result->userid) ? $result->userid : "",
                        'created_by' => isset($result->userid) ? $result->userid : "",
                        'branch_id' => isset($result->branch_id) ? $result->branch_id : "",
                        'store_id' => isset($result->store_id) ? $result->store_id : "",
                        'user_role' => isset($result->u_type_id) ? $result->u_type_id : "",
                        'app_special' => isset($result->app_special) ? $result->app_special : "",
                        // 'division' => isset($result->division) ? $result->division : "",
                        // 'district' => isset($result->district) ? $result->district : "",
                        // 'area' => isset($result->area) ? $result->area : "",
                        'validate' => true
                    );

                    $time = time() + 3600;
                    if (USER_COOKIE_TIME) {
                        $time = (time() + (USER_COOKIE_TIME * 24 * 60 * 60 * 1000));
                    }

                    $path = "/";
                    $cookieValue = "'" . json_encode($cookieValue) . "'";

//                    print_r($cookieValue);
//                    exit();

                    setcookie(USER_COOKIE_NAME, $cookieValue, $time, $path);

                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    // Login
    public static function login($data = [])
    {
        $status = false;

        if (count($data) > 0) {
            if ((isset($data['username']) || isset($data['email'])) && isset($data['password'])) {
                $email = isset($data['email']) ? $data['email'] : "";
                $username = isset($data['username']) ? $data['username'] : "";
                $password = isset($data['password']) ? $data['password'] : "";

                $sql = "SELECT * FROM user WHERE ";

                if ($email != "") {
                    $sql .= "userid ='$email' ";
                } elseif ($username != "") {
                    $sql .= "userid ='$username' ";
                }

                $sql .= "AND status ='Active'";
                $result = DB()->query($sql)->get();

                if (isset($result->userid)) {
                    $matchPassword = self::cheeckPassword($result, $password);
                    if ($matchPassword) {
                        $data = array(
                            'project_id' => isset($result->project_id) ? $result->project_id : "",
                            'full_name' => isset($result->fullname) ? $result->fullname : "",
                            'user_id' => isset($result->userid) ? $result->userid : "",
                            'created_by' => isset($result->userid) ? $result->userid : "",
                            'branch_id' => isset($result->branch_id) ? $result->branch_id : "",
                            'store_id' => isset($result->store_id) ? $result->store_id : "",
                            'user_role' => isset($result->u_type_id) ? $result->u_type_id : "",
                            'app_special' => isset($result->app_special) ? $result->app_special : "",
                            // 'division' => isset($result->division) ? $result->division : "",
                            // 'district' => isset($result->district) ? $result->district : "",
                            // 'area' => isset($result->area) ? $result->area : "",
                            'validate' => true
                        );

                        $time = time() + 3600;
                        if (USER_COOKIE_TIME) {
                            $time = (time() + (USER_COOKIE_TIME * 24 * 60 * 60 * 1000));
                        }

                        $path = "/";
                        $cookieValue = json_encode($data);

                        setcookie(USER_COOKIE_NAME, $cookieValue, $time, $path);

                        $status = true;
                    } else {
                        $status = false;
                    }
                } else {
                    $status = false;
                }
            } else {
                $status = false;
            }
        } else {
            $status = false;
        }
        return $status;
    }

    // Check user password match
    public static function cheeckPassword($query, $password)
    {
        $user_password = $query->password; // database hash password
        $User_my_key = $query->my_key; // database key

        $user_hash = md5($password); // user form hash password
        if ($user_password === $user_hash && $User_my_key === $password) {
            return true;
        } else {
            return false;
        }
    }

    // Logout
    public static function logout()
    {
        deleteCookie(USER_COOKIE_NAME);
        return redirectTo(HOME);
    }

}


