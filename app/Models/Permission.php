<?php

namespace App\Models;

use App\Controllers\PaginationController;
use System\libs\Model;


class Permission extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // get user access permission list
    public static function getUserAccessPermission()
    {
        $uaer_data = getCookie(USER_COOKIE_NAME);

        $userid = "";
        if (isset($uaer_data) && isset($uaer_data->user_id)) {
            $userid = $uaer_data->user_id;
        }

        if ($userid != "") {
            $SQL = "SELECT p.id, p.slug as slug FROM users u";
            $SQL .= " JOIN user_role ur ON u.id = ur.user_id";
            $SQL .= " JOIN role_permission rp ON ur.role_id = rp.role_id";
            $SQL .= " JOIN permission p ON rp.permission_id = p.id";
            $SQL .= " WHERE u.id = '$userid' ORDER BY p.id ASC";
            $rolePermission = DB()->query($SQL)->all();

            $psql = "SELECT p.id, p.slug as slug FROM users u";
            $psql .= " JOIN user_permission up ON u.id = up.user_id";
            $psql .= " JOIN permission p ON up.permission_id = p.id";
            $psql .= " WHERE u.id = '$userid' ORDER BY p.id ASC";
            $userPermission = DB()->query($psql)->all();

            // Merge the two arrays and remove duplicates based on 'id'
            $mergedArray = array_merge($rolePermission, $userPermission);

            // Reindex the merged array
            $mergedArray = array_values(array_column($mergedArray, null, 'id'));

            $permissionArr = array();

            foreach ($mergedArray as $value) {
                $permissionArr[$value['slug']] = $value['id'];
            }

            return $permissionArr;
        }
        return [];
    }

    // Get permission list
    public function getPermissionList()
    {
        $from = isset(request()->from) ? request()->from : "";
        $to = isset(request()->to) ? request()->to : "";
        $search = isset(request()->search) ? request()->search : "";

        // per page data
        $perPage = 10;

        if ($from == "") {
            $from = 0;
        }
        if ($to == "") {
            $to = $perPage;
        }


        $sql = "SELECT * FROM permission";
        if ($search != "") {
            $sql .= " WHERE name LIKE '%$search%' OR slug LIKE '%$search%' OR group_name LIKE '%$search%'";
        }
        $totalCountSQL = $sql;
        $sql .= " ORDER BY id ASC LIMIT $from,$to";

        $result = $this->query($sql)->all();

        // Get total count result
        $totalResult = $this->query($totalCountSQL)->all();
        $totalrecord = count($totalResult);

        $Pagination = "";
        if ($totalrecord > 0) {
            $Pagination = (new PaginationController())->ellipsisPagination($totalrecord, $perPage);
        }

        $htmlContent = '<table class="table table-zebra mt-5 border border-base-300">
                            <thead class="bg-base-200 text-base">
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Group</th>
                                <th class="text-center">Options</th>
                            </tr>
                            </thead>
                            <tbody>';

        if (count($result) > 0) {
            $i = 1;
            foreach ($result as $row) {
                $htmlContent .= '<tr>
				<td>' . $i++ . '</td>
				<td>' . $row["name"] . '</td>
				<td>' . $row["slug"] . '</td>
				<td>' . $row["group_name"] . '</td>
				<td>
				    <div class="flex gap-1 items-center justify-center">
                        <button
                                class="btn bg-base-100 text-sm text-base-content border border-base-300"
                              
                                title="Edit"
                                id="editPermission"
                                onclick=editPermission("' . $row["id"] . '")
                        >
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button
                                class="btn bg-base-100 text-sm text-base-content border border-base-300"
                                onclick=deletePermission("' . $row["id"] . '")
                                title="Delete"
                                id="deletePermission"
                        >
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </td>
			</tr>';
            }
        } else {
            $htmlContent .= '<tr><td colspan="5" class="text-center">No record found</td></tr>';
        }

        $htmlContent .= '</tbody>';
        $htmlContent .= '</table>';

        return ["html" => $htmlContent, "pagination" => $Pagination];
    }

    // Add or update permission
    public function addOrUpdatePermission()
    {
        $name = isset(request()->name) ? strtolower(request()->name) : "";
        $slug = isset(request()->slug) ? strtolower(request()->slug) : "";
        $group = isset(request()->group) ? strtolower(request()->group) : "";
        $editId = isset(request()->edit_id) ? request()->edit_id : "";

        if ($name == "" || $slug == "") {
            return ["status" => false, "message" => "Please fill up input field!"];
        }

        $SLUGSQL = "SELECT * FROM permission WHERE name = '$name' OR slug = '$slug'";
        $result = DB()->query($SLUGSQL)->get();
        if (isset($result->id)) {
            if ($editId == "") {
                return ["status" => false, "message" => "Name or slug already exists!"];
            }
            if ($editId != "" && $editId != $result->id) {
                return ["status" => false, "message" => "Name or slug already exists!"];
            }
        }

        if ($editId == "") {
            $SQL = "INSERT INTO permission (name,slug,group_name) VALUES('$name','$slug','$group')";
        } else {
            $SQL = "UPDATE permission
                    SET name ='$name', 
                    slug = '$slug', 
                    group_name = '$group'
                WHERE id = '$editId'";
        }

        $this->db->beginTransaction();

        try {
            DB()->query($SQL)->save();
            $this->db->commit();

            return ["status" => true, "message" => "Permission has been saved successfully!"];
        } catch (\Exception $exception) {
            $this->db->rollBack();
            return ["status" => false, "message" => "Permission did not saved successfully! Something wrong"];
        }

    }

    // Permission delete
    public function permissionDelete()
    {
        $id = isset(request()->deleted_id) ? request()->deleted_id : "";

        if ($id !== "") {
            $this->db->beginTransaction();
            try {
                $sql = "DELETE FROM permission WHERE id = '$id'";
                $this->query($sql)->delete();

                $this->db->commit();
                return ["status" => true, "message" => "Record deleted successfully!!!"];
            } catch (\Exception $e) {
                $this->db->rollBack();
                return ["status" => false, "message" => "Record did not deleted. Try again!"];
            }
        } else {
            return ["status" => false, "message" => "Record id required"];
        }

    }

    // Add Role with permission
    public function addRolePermission()
    {
        $name = isset(request()->name) ? strtolower(request()->name) : "";
        $permissions = isset(request()->permissions) ? request()->permissions : "";

        if ($name == "") {
            return ["status" => false, "message" => "Please fill up Role Name!"];
        }
        if (empty($permissions)) {
            return ["status" => false, "message" => "Please select at least one permission!"];
        }


        $RSQL = "SELECT * FROM role WHERE name = '$name'";
        $result = DB()->query($RSQL)->get();
        if (isset($result->id)) {
            return ["status" => false, "message" => "Role name already exists!"];
        }

        $this->db->beginTransaction();
        try {
            $SQL = "INSERT INTO role (name) VALUES('$name')";
            DB()->query($SQL)->save();

            $RSQL1 = "SELECT * FROM role ORDER BY id DESC";
            $result1 = DB()->query($RSQL1)->get();

            if ($result1->id) {
                $role_id = $result1->id;

                foreach ($permissions as $permission) {
                    $SQL = "INSERT INTO role_permission (role_id,permission_id) VALUES('$role_id','$permission')";
                    DB()->query($SQL)->save();
                }

                $this->db->commit();
                return ["status" => true, "message" => "Role has been saved successfully!"];
            } else {
                $this->db->rollBack();
                return ["status" => false, "message" => "Role did not saved successfully! Something wrong"];
            }
        } catch (\Exception $exception) {
            $this->db->rollBack();
            return ["status" => false, "message" => "Role did not saved successfully! Something wrong"];
        }
    }

    // Update Role with permission
    public function updateRolePermission()
    {
        $role_id = isset(request()->role_id) ? strtolower(request()->role_id) : "";
        $name = isset(request()->name) ? strtolower(request()->name) : "";
        $permissions = isset(request()->permissions) ? request()->permissions : "";

        if ($name == "") {
            return ["status" => false, "message" => "Please fill up Role Name!"];
        }
        if (empty($permissions)) {
            return ["status" => false, "message" => "Please select at least one permission!"];
        }

        $ERSQL = "SELECT * FROM role WHERE id = '$role_id'";
        $exrole = DB()->query($ERSQL)->get();

        if ($exrole->id) {
            if ($name != $exrole->name) {
                $RSQL = "SELECT * FROM role WHERE name = '$name'";
                $result = DB()->query($RSQL)->get();
                if (isset($result->id)) {
                    return ["status" => false, "message" => "Role name already exists!"];
                }
            }

            $this->db->beginTransaction();
            try {
                $SQL = "UPDATE role SET name = '$name' WHERE id = '$role_id'";
                DB()->query($SQL)->save();

                $DSQL = "DELETE FROM role_permission WHERE role_id = '$role_id'";
                DB()->query($DSQL)->save();


                foreach ($permissions as $permission) {
                    $PSQL = "INSERT INTO role_permission (role_id,permission_id) VALUES('$role_id','$permission')";
                    DB()->query($PSQL)->save();
                }

                $this->db->commit();
                return ["status" => true, "message" => "Role has been saved successfully!"];
            } catch (\Exception $exception) {
                $this->db->rollBack();
                return ["status" => false, "message" => "Role did not saved successfully! Something wrong"];
            }
        } else {
            return ["status" => false, "message" => "Invalid role ID!"];
        }
    }

    // Get role list
    public function getRoleList()
    {
        $from = isset(request()->from) ? request()->from : "";
        $to = isset(request()->to) ? request()->to : "";
        $search = isset(request()->search) ? request()->search : "";

        // per page data
        $perPage = 10;

        if ($from == "") {
            $from = 0;
        }
        if ($to == "") {
            $to = $perPage;
        }

        $sql = "SELECT r.*, CONCAT('[', GROUP_CONCAT(JSON_OBJECT('permission_id', p.id, 'permission_name', p.name)), ']') AS permissions FROM role r";
        $sql .= " JOIN role_permission rp ON rp.role_id = r.id JOIN permission p ON rp.permission_id = p.id";
        if ($search != "") {
            $sql .= " WHERE r.name LIKE '%$search%'";
        }
        $sql .= " GROUP BY r.id";

        $totalCountSQL = $sql;
        $sql .= " ORDER BY r.id ASC LIMIT $from,$to";

        $result = $this->query($sql)->all();

        // Get total count result
        $totalResult = $this->query($totalCountSQL)->all();
        $totalrecord = count($totalResult);

        $Pagination = "";
        if ($totalrecord > 0) {
            $Pagination = (new PaginationController())->ellipsisPagination($totalrecord, $perPage);
        }

        $htmlContent = '<table class="table table-zebra mt-5 border border-base-300">
                            <thead class="bg-base-200 text-base">
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Permissions</th>
                                <th class="text-center">Options</th>
                            </tr>
                            </thead>
                            <tbody>';

        if (count($result) > 0) {
            $i = 1;
            foreach ($result as $row) {
                $permissions = "";
                $permissionsArray = json_decode($row["permissions"], true);
                foreach ($permissionsArray as $permission) {
                    $permissions .= '<span style="margin: 5px 3px !important;background: #082227; color: #fff; border-radius: 10px; padding: 0px 7px 3px 7px; margin-right: 5px;">' . $permission["permission_name"] . '</span>';
                }

                $permissions = '<div class="w-full flex flex-wrap">' . $permissions . '</div>';


                $htmlContent .= '<tr>
				<td>' . $i++ . '</td>
				<td class="min-w-[150px]">' . $row["name"] . '</td>
				<td>' . $permissions . '</td>
				<td>
				    <div class="flex gap-1 items-center justify-center">
                        <a
                                class="btn bg-base-100 text-sm text-base-content border border-base-300"
                              
                                title="Edit"
                                id="editPermission"
                                href="' . route('/role/edit/' . $row["id"]) . '"
                        >
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <button
                                class="btn bg-base-100 text-sm text-base-content border border-base-300"
                                onclick=deletePermission("' . $row["id"] . '")
                                title="Delete"
                                id="deletePermission"
                        >
                            <i class="fa-solid fa-trash"></i>
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

    // Role delete
    public function roleDelete()
    {
        $id = isset(request()->deleted_id) ? request()->deleted_id : "";

        if ($id !== "") {
            $this->db->beginTransaction();
            try {
                $sql = "DELETE FROM role_permission WHERE role_id = '$id'";
                $this->query($sql)->delete();

                $sql1 = "DELETE FROM role WHERE id = '$id'";
                $this->query($sql1)->delete();

                $this->db->commit();
                return ["status" => true, "message" => "Record deleted successfully!!!"];
            } catch (\Exception $e) {
                $this->db->rollBack();
                return ["status" => false, "message" => "Record did not deleted. Try again!"];
            }
        } else {
            return ["status" => false, "message" => "Record id required"];
        }

    }

    // Get user role list
    public function getUserRoleList()
    {
        $from = isset(request()->from) ? request()->from : "";
        $to = isset(request()->to) ? request()->to : "";
        $search = isset(request()->search) ? request()->search : "";

        // per page data
        $perPage = 10;

        if ($from == "") {
            $from = 0;
        }
        if ($to == "") {
            $to = $perPage;
        }

        $sql = "SELECT u.id,u.name, CONCAT('[', GROUP_CONCAT(JSON_OBJECT('role_id', r.id, 'role_name', r.name)), ']') AS roles FROM users u";
        $sql .= " JOIN user_role ur ON ur.user_id = u.id JOIN role r ON ur.role_id = r.id";

        if ($search != "") {
            $sql .= " WHERE u.id LIKE '%$search%'";
        }
        $sql .= " GROUP BY u.id";

        $totalCountSQL = $sql;
        $sql .= " ORDER BY u.id ASC LIMIT $from,$to";

        $result = $this->query($sql)->all();

        // Get total count result
        $totalResult = $this->query($totalCountSQL)->all();
        $totalrecord = count($totalResult);

        $Pagination = "";
        $users = [];
        if ($totalrecord > 0) {
            $Pagination = (new PaginationController())->ellipsisPagination($totalrecord, $perPage);
        }

        $htmlContent = '<table class="table table-zebra mt-5 border border-base-300">
                            <thead class="bg-base-200 text-base">
                            <tr>
                                <th>SL</th>
                                <th>User</th>
                                <th>Role</th>
                                <th class="text-center">Options</th>
                            </tr>
                            </thead>
                            <tbody>';

        if (count($result) > 0) {
            $i = 1;
            foreach ($result as $row) {
                $roles = "";

                $rolesArray = json_decode($row["roles"], true);

                $users[] = [
                    'id' => $row["id"],
                    'name' => $row["name"],
                    'roles' => $rolesArray,
                ];

                foreach ($rolesArray as $role) {
                    $roles .= '<span style="background: #082227; color: #fff; border-radius: 10px; padding: 0px 7px 3px 7px; margin-right: 5px;">' . $role["role_name"] . '</span>';
                }

                $htmlContent .= '<tr>
				<td>' . $i++ . '</td>
				<td>' . $row["name"] . '</td>
				<td>' . $roles . '</td>
				<td>
				    <div class="flex gap-1 items-center justify-center">
                        <button
                                class="btn bg-base-100 text-sm text-base-content border border-base-300"
                                type="button"
                                title="Edit"
                                onclick=handleEdit("' . $row["id"] . '")
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

        return ["users" => $users, "html" => $htmlContent, "pagination" => $Pagination];
    }

    // Update user role
    public function updateUserRole()
    {
        $userid = isset(request()->userid) ? request()->userid : "";
        $roles = isset(request()->roles) ? request()->roles : [];

        if ($userid == "") {
            return ["status" => false, "message" => "User cant not empty. Please select a user!"];
        }

        if (empty($roles)) {
            return ["status" => false, "message" => "Please select at least a role!"];
        }

        $this->db->beginTransaction();
        try {
            $USQL = "DELETE FROM user_role WHERE user_id = '$userid'";
            DB()->query($USQL)->save();

            foreach ($roles as $role_id) {
                $PSQL = "INSERT INTO user_role (user_id,role_id) VALUES('$userid','$role_id')";
                DB()->query($PSQL)->save();
            }

            $this->db->commit();
            return ["status" => true, "message" => "Role has been saved successfully!"];
        } catch (\Exception $exception) {
            $this->db->rollBack();
            return ["status" => false, "message" => "Role did not saved successfully! Something wrong"];
        }

    }

    // Get user permission list
    public function getUserPermissionList()
    {
        $from = isset(request()->from) ? request()->from : "";
        $to = isset(request()->to) ? request()->to : "";
        $search = isset(request()->search) ? request()->search : "";

        // per page data
        $perPage = 10;

        if ($from == "") {
            $from = 0;
        }
        if ($to == "") {
            $to = $perPage;
        }

        $sql = "SELECT u.id, u.name, CONCAT('[', GROUP_CONCAT(JSON_OBJECT('permission_id', p.id, 'permission_name', p.name)), ']') AS permissions FROM users u";
        $sql .= " JOIN user_permission up ON up.user_id = u.id JOIN permission p ON up.permission_id = p.id";

        if ($search != "") {
            $sql .= " WHERE u.id LIKE '%$search%'";
        }
        $sql .= " GROUP BY u.id";

        $totalCountSQL = $sql;
        $sql .= " ORDER BY u.id ASC LIMIT $from,$to";

        $result = $this->query($sql)->all();

        // Get total count result
        $totalResult = $this->query($totalCountSQL)->all();
        $totalrecord = count($totalResult);

        $Pagination = "";
        $users = [];
        if ($totalrecord > 0) {
            $Pagination = (new PaginationController())->ellipsisPagination($totalrecord, $perPage);
        }

        $htmlContent = '<table class="table table-zebra mt-5 border border-base-300">
                            <thead class="bg-base-200 text-base">
                            <tr>
                                <th>SL</th>
                                <th>User</th>
                                <th>Permission</th>
                                <th class="text-center">Options</th>
                            </tr>
                            </thead>
                            <tbody>';

        if (count($result) > 0) {
            $i = 1;
            foreach ($result as $row) {
                $permissions = "";

                $permissionsArray = json_decode($row["permissions"], true);

                $users[] = [
                    'id' => $row["id"],
                    'name' => $row["name"],
                    'permissions' => $permissionsArray,
                ];

                foreach ($permissionsArray as $permission) {
                    $permissions .= '<span style="background: #082227; color: #fff; border-radius: 10px; padding: 0px 7px 3px 7px; margin-right: 5px;">' . $permission["permission_name"] . '</span>';
                }

                $htmlContent .= '<tr>
				<td>' . $i++ . '</td>
				<td>' . $row["name"] . '</td>
				<td>' . $permissions . '</td>
				<td>
				    <div class="flex gap-1 items-center justify-center">
                        <button
                                class="btn bg-base-100 text-sm text-base-content border border-base-300"
                                type="button"
                                title="Edit"
                                onclick=handleEdit("' . $row["id"] . '")
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

        return ["users" => $users, "html" => $htmlContent, "pagination" => $Pagination];
    }

    // Update user permission
    public function updateUserPermission()
    {
        $userid = isset(request()->userid) ? request()->userid : "";
        $permissions = isset(request()->permissions) ? request()->permissions : [];

        if ($userid == "") {
            return ["status" => false, "message" => "User cant not empty. Please select a user!"];
        }

        if (empty($permissions)) {
            return ["status" => false, "message" => "Please select at least a permission!"];
        }

        $this->db->beginTransaction();
        try {
            $USQL = "DELETE FROM user_permission WHERE user_id = '$userid'";
            DB()->query($USQL)->save();

            foreach ($permissions as $permission_id) {
                $PSQL = "INSERT INTO user_permission (user_id,permission_id) VALUES('$userid','$permission_id')";
                DB()->query($PSQL)->save();
            }

            $this->db->commit();
            return ["status" => true, "message" => "Permission has been saved successfully!"];
        } catch (\Exception $exception) {
            $this->db->rollBack();
            return ["status" => false, "message" => "Permission did not saved successfully! Something wrong"];
        }

    }


}