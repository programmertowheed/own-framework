<?php

namespace App\Controllers\Backend;

use App\Models\Permission;
use System\libs\Controller;

/**
 * Role Permission  Controller
 */
class RolePermissionController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    // Permission list page
    public function permissionListPage()
    {
        return view("backend.permission.permission");
    }

    // Get permission list
    public function getPermissionList()
    {
        $permission = new Permission();
        $data = $permission->getPermissionList();

        return response()->json(["status" => true, "message" => "Success", "data" => $data]);
    }

    // add permission
    public function permissionAdd()
    {
        $permission = new Permission();
        $result = $permission->addOrUpdatePermission();

        $data = $permission->getPermissionList();

        $status = isset($result['status']) ? $result['status'] : false;
        $message = isset($result['message']) ? $result['message'] : "";

        return response()->json(["status" => $status, "message" => $message, "data" => $data]);
    }

    // Get permission by id
    public function getPermissionById()
    {
        $id = isset(request()->id) ? request()->id : "";

        if ($id == "") {
            return response()->json(['status' => false, "message" => "Permission ID missing!"]);
        }

        $sql = "SELECT * FROM permission WHERE id = '$id'";
        $query = DB()->query($sql)->get();

        if (isset($query->id)) {
            return response()->json(['status' => true, "message" => "Success", "data" => $query]);
        } else {
            return response()->json(['status' => false, "message" => "Record not found!"]);
        }
    }

    // Permission delete
    public function deletePermission()
    {
        $permission = new Permission();
        $result = $permission->permissionDelete();

        $status = isset($result['status']) ? $result['status'] : "false";
        $message = isset($result['message']) ? $result['message'] : "Record did not deleted. Try again!";

        return response()->json(["status" => $status, "message" => $message]);
    }

    // View role list page
    public function roleList()
    {
        return view("backend.role.role_list");
    }

    // Get role list
    public function getRoleList()
    {
        $permission = new Permission();
        $data = $permission->getRoleList();

        return response()->json(["status" => true, "message" => "Success", "data" => $data]);
    }

    // View create role page
    public function createRole()
    {
        $sql = "SELECT *, count(*) as groupTotal FROM permission GROUP BY group_name";
        $result = DB()->query($sql)->all();

        if ($result) {
            $permission_groups = $result;
        } else {
            $permission_groups = [];
        }

        $psql = "SELECT * FROM permission";
        $presult = DB()->query($psql)->all();

        if ($presult) {
            $permissions = $presult;
        } else {
            $permissions = [];
        }

        return view("backend.role.create_role", ["permission_groups" => $permission_groups, "permissions" => $permissions]);
    }

    // Add role
    public function addRole()
    {
        $permission = new Permission();
        $result = $permission->addRolePermission();

        $status = isset($result['status']) ? $result['status'] : false;
        $message = isset($result['message']) ? $result['message'] : "";

        return response()->json(["status" => $status, "message" => $message]);
    }

    // Update role
    public function updateRole()
    {
        $permission = new Permission();
        $result = $permission->updateRolePermission();

        $status = isset($result['status']) ? $result['status'] : false;
        $message = isset($result['message']) ? $result['message'] : "";

        return response()->json(["status" => $status, "message" => $message]);
    }

    // View role edit page
    public function editRole($request)
    {
        $id = $request['id'];
        $rsql = "SELECT * FROM role WHERE id = '$id' LIMIT 1";
        $rresult = DB()->query($rsql)->all();

        if ($rresult) {
            $role = $rresult[0];

            $psql = "SELECT * FROM role_permission WHERE role_id = '$id'";
            $presult = DB()->query($psql)->all();

            $role_permissions = [];
            if (count($presult) > 0) {
                foreach ($presult as $val) {
                    array_push($role_permissions, $val['permission_id']);
                }
            }

            $sql = "SELECT *, count(*) as groupTotal FROM permission GROUP BY group_name";
            $result = DB()->query($sql)->all();

            if ($result) {
                $permission_groups = $result;
            } else {
                $permission_groups = [];
            }

            $psql1 = "SELECT * FROM permission";
            $presult1 = DB()->query($psql1)->all();

            if ($presult1) {
                $permissions = $presult1;
            } else {
                $permissions = [];
            }

            return view("backend.role.edit_role", [
                "role" => $role,
                "role_permissions" => json_encode($role_permissions),
                "permission_groups" => $permission_groups,
                "permissions" => $permissions,
            ]);

        } else {
            return redirect()->route("/role/list", ["error" => "Invalid role ID!"]);
        }

    }

    // Role delete
    public function deleteRole()
    {
        $permission = new Permission();
        $result = $permission->roleDelete();

        $status = isset($result['status']) ? $result['status'] : "false";
        $message = isset($result['message']) ? $result['message'] : "Record did not deleted. Try again!";

        return response()->json(["status" => $status, "message" => $message]);
    }

    // View user role page
    public function addUserRole()
    {
        $allroles = [];
        $rsql = "SELECT id,name FROM role ORDER BY id ASC";
        $roleresult = DB()->query($rsql)->all();
        if (count($roleresult) > 0) {
            $allroles = $roleresult;
        }

        return view("backend.role.user_role", ["allroles" => $allroles]);
    }

    // Get user role list
    public function getUserRoleList()
    {
        $permission = new Permission();
        $data = $permission->getUserRoleList();

        return response()->json(["status" => true, "message" => "Success", "data" => $data]);
    }

    // Update user role
    public function updateUserRole()
    {
        $permission = new Permission();
        $result = $permission->updateUserRole();

        $data = $permission->getUserRoleList();

        $status = isset($result['status']) ? $result['status'] : false;
        $message = isset($result['message']) ? $result['message'] : "";

        return response()->json(["status" => $status, "message" => $message, "data" => $data]);
    }

    // View user permission page
    public function addUserPermission()
    {
        $permissions = [];
        $sql = "SELECT id,name,slug FROM permission ORDER BY id ASC";
        $result = DB()->query($sql)->all();
        if (count($result) > 0) {
            $permissions = $result;
        }

        return view("backend.permission.user_permission", ["permissions" => $permissions]);
    }

    // Get user permission list
    public function getUserPermissionList()
    {
        $permission = new Permission();
        $data = $permission->getUserPermissionList();

        return response()->json(["status" => true, "message" => "Success", "data" => $data]);
    }

    // Update user permission
    public function updateUserPermission()
    {
        $permission = new Permission();
        $result = $permission->updateUserPermission();

        $data = $permission->getUserPermissionList();

        $status = isset($result['status']) ? $result['status'] : false;
        $message = isset($result['message']) ? $result['message'] : "";

        return response()->json(["status" => $status, "message" => $message, "data" => $data]);
    }

}
