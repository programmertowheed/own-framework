<?php

namespace App\Models;

use System\libs\Model;


class User extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // User login
    public function Login($email, $pass)
    {
        $sql = "SELECT * FROM users WHERE email ='" . $email . "' AND status ='1'";
        $result = DB()->query($sql)->get();

        if (isset($result->id)) {
            $matchPassword = $this->cheeckPasswordMatch($result, $pass);
            if ($matchPassword) {
                $data = array(
                    'name' => $result->name,
                    'user_id' => $result->id,
                    'role' => $result->role,
                    'validate' => true
                );

                return response()->json(["status" => true, "message" => "<strong>Well done! </strong> You Login Successfully!", "data" => $data]);
            } else {
                return response()->json(["status" => false, "message" => "Incorrect email or password!."]);
            }
        } else {
            return response()->json(["status" => false, "message" => "Incorrect email or password!."]);
        }
    }

    // Check user password match
    public function cheeckPasswordMatch($query, $password)
    {
        $user_password = $query->password; // database hash password

        $user_hash = md5($password); // user form hash password
        if ($user_password === $user_hash) {
            return true;
        } else {
            return false;
        }
    }

    // Get all user list
    public function getAllUserList()
    {
        $from = isset(request()->from) ? request()->from : "";
        $to = isset(request()->to) ? request()->to : "";

        // per page data
        $perPage = 50;

        if ($from == "") {
            $from = 0;
        }
        if ($to == "") {
            $to = $perPage;
        }


        $sql = "SELECT * FROM user ";
//        $sql .= " WHERE Username != 'admin'";
        $totalCountSQL = $sql;
        $sql .= " ORDER BY userid ASC LIMIT $from,$to";

        $result = DB()->query($sql)->all();

        // Get total count result
        $totalResult = DB()->query($totalCountSQL)->all();
        $totalrecord = count($totalResult);

        $Pagination = "";
        if ($totalrecord > 0) {
            $Pagination = (new Order())->getPagination($totalrecord, $perPage);
        }

        $htmlContent = '<table class="table table-zebra mt-5 border border-base-300">
                            <thead class="bg-base-200 text-base">
                            <tr>
                                <th>Name</th>
                                <th>User Name</th>
                                <th>User Type</th>
                                <th class="text-center">Option</th>
                            </tr>
                            </thead>
                            <tbody>';

        if (count($result) > 0) {
            foreach ($result as $row) {
                if ($row['u_type_id'] == 101) {
                    $UserType = "Super Admin";
                } elseif ($row['u_type_id'] == 102) {
                    $UserType = "Admin";
                } elseif ($row['u_type_id'] == 103) {
                    $UserType = "Sales";
                } elseif ($row['u_type_id'] == 104) {
                    $UserType = "Accounce";
                } elseif ($row['u_type_id'] == 105) {
                    $UserType = "Store";
                } elseif ($row['u_type_id'] == 106) {
                    $UserType = "Procurement";
                } elseif ($row['u_type_id'] == 107) {
                    $UserType = "HR";
                } elseif ($row['u_type_id'] == 108) {
                    $UserType = "Physical Verification";
                } elseif ($row['u_type_id'] == 109) {
                    $UserType = "All Report";
                } else {
                    $UserType = "";
                }

                $htmlContent .= '<tr>
				<td>' . $row["fullname"] . '</td>
				<td>' . $row["userid"] . '</td>
				<td>' . $UserType . '</td>
				<td>
				    <div class="flex gap-1 items-center justify-center">
                        <button
                                class="btn bg-base-100 text-sm text-base-content border border-base-300"
                              
                                title="Edit"
                                id="editSalesBtn"
                                onclick=editUser("' . $row["userid"] . '")
                        >
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </div>
                </td>
			</tr>';
            }
        } else {
            $htmlContent .= '<tr><td colspan="4" class="text-center">No record found</td></tr>';
        }

        $htmlContent .= '</tbody>';
        $htmlContent .= '</table>';

        return ["html" => $htmlContent, "pagination" => $Pagination];

    }

    // Get all user type list
    public function getAllUserTypeList()
    {
        $SQL = "SELECT * FROM usertype";

        $result = DB()->query($SQL)->all();
        return $result;
    }

    // Check user name
    public function checkUsernameIsAvailable($username = "", $user_id = "")
    {
        $userid = isset(request()->user_name) ? request()->user_name : "";
        $u_id = isset(request()->u_id) ? request()->u_id : "";

        if ($username != "") {
            $userid = $username;
        }
        if ($user_id != "") {
            $u_id = $user_id;
        }

        if ($userid == "") {
            return ["status" => false, "message" => "User name missing!"];
        }

        $SQL = "SELECT * FROM user WHERE userid = '$userid'";

        $result = DB()->query($SQL)->get();
        if (isset($result->userid)) {
            if ($u_id != "" && $u_id == $result->userid) {
                return ["status" => true, "message" => "User not found!"];
            } else {
                return ["status" => true, "message" => "User already exists!", "data" => $result];
            }
        } else {
            return ["status" => true, "message" => "User not found!"];
        }

    }

    // Get user info
    public function getSingleUser()
    {
        $userid = isset(request()->userid) ? request()->userid : "";

        if ($userid == "") {
            return ["status" => false, "message" => "ID missing"];
        }

        $SQL = "SELECT u.*,d.delivery_point_name  FROM user AS u LEFT JOIN deliverypoint AS d ON u.store_id = d.delivery_pid WHERE userid = '$userid'";

        $result = DB()->query($SQL)->get();
        if (isset($result->userid)) {
            return ["status" => true, "message" => "Success", "data" => $result];
        } else {
            return ["status" => false, "message" => "User not found"];
        }

    }

    // Add or update user
    public function addOrUpdateUser()
    {
        $project_id = isset(request()->project_id) ? request()->project_id : "";
        $created_by = isset(request()->created_by) ? request()->created_by : "";
        $full_name = isset(request()->full_name) ? request()->full_name : "";
        $branch_id = isset(request()->branch_id) ? request()->branch_id : "";
        $store_id = isset(request()->store_id) ? request()->store_id : "";
        $user_name = isset(request()->user_name) ? request()->user_name : "";
        $user_password = isset(request()->user_password) ? request()->user_password : "";
        $user_type = isset(request()->user_type) ? request()->user_type : "";
        $user_status = isset(request()->user_status) ? request()->user_status : "";
        $u_id = isset(request()->u_id) ? request()->u_id : "";

        if ($full_name == "" || $branch_id == "" || $store_id == "" || $user_name == "" || $user_password == "" || $user_type == "" || $user_status == "") {
            return ["status" => false, "message" => "Please fill up input field!"];
        }

        $checkName = $this->checkUsernameIsAvailable($user_name, $u_id);
        if ($checkName['status'] == true && isset($checkName['data'])) {
            return ["status" => false, "message" => "User name not available!"];
        }

        $my_key = $user_password;
        $password = md5($user_password);

        date_default_timezone_set("Asia/Dhaka");
        $currentDateTime = date("Y-m-d H:i:s a");

        if ($u_id == "") {
            $SQL = "INSERT INTO user (project_id,branch_id,store_id,userid,password,my_key,fullname,u_type_id,status,created_by,created_time) ";
            $SQL .= " VALUES(
            '$project_id',
            '$branch_id',
            '$store_id',
            '$user_name',
            '$password',
            '$my_key',
            '$full_name',
            '$user_type',
            '$user_status',
            '$created_by',
            '$currentDateTime'
            )";

        } else {
            $SQL = "UPDATE user
                    SET project_id ='$project_id', 
                    branch_id = '$branch_id', 
                    store_id = '$store_id', 
                    userid = '$user_name', 
                    password = '$password', 
                    my_key = '$my_key', 
                    fullname = '$full_name', 
                    u_type_id = '$user_type', 
                    status = '$user_status'
                WHERE userid = '$u_id'";
        }

        $result = DB()->query($SQL)->save();

        if ($result) {
            return ["status" => true, "message" => "User has been saved successfully!"];
        } else {
            return ["status" => false, "message" => "User did not saved successfully!"];
        }

    }

    // Change user password
    public function changeUserPassword()
    {
        $current_password = isset(request()->current_password) ? request()->current_password : "";
        $new_password = isset(request()->new_password) ? request()->new_password : "";
        $confirm_password = isset(request()->confirm_password) ? request()->confirm_password : "";
        $user_id = isset(request()->user_id) ? request()->user_id : "";

        if ($user_id == "") {
            return ["status" => false, "message" => "User Id missing!"];
        }

        if ($current_password == "" || $new_password == "" || $confirm_password == "") {
            return ["status" => false, "message" => "Please fill up input field!"];
        }

        if ($new_password != $confirm_password) {
            return ["status" => false, "message" => "Confirm password doesn't match!"];
        }

        $oldPassword = md5($current_password);

        $userSQL = "SELECT * FROM users WHERE id = '$user_id'";
        $userData = DB()->query($userSQL)->get();
        $user_password = $userData->password;

        if ($user_password === $oldPassword) {
            if ($user_password === md5($confirm_password)) {
                return ["status" => false, "message" => "You can't set same password again!!"];
            }
            $password = md5($confirm_password);

            $SQL = "UPDATE users SET password = '$password' WHERE id = '$user_id'";
            $result = DB()->query($SQL)->save();

            if ($result) {
                return ["status" => true, "message" => "Password has been changed successfully!"];
            } else {
                return ["status" => false, "message" => "Password did not changed!"];
            }
        } else {
            return ["status" => false, "message" => "Current password doesn't match!"];
        }

    }

}