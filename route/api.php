<?php

use System\route\Base as Route;
use App\Controllers\UserController;
use App\Controllers\Backend\RolePermissionController;


Route::groupMiddleware(["cors"], function () {

    Route::get("/api", function () {
        return response()->json(["message" => "Unauthorized access"]);
    });

    Route::get("/api/health", function () {
        return response()->json(["message" => "Api is working"]);
    });

    // Login route
    Route::post("/api/login", [UserController::class, "login"]);


    Route::groupMiddleware(["authAPI"], function () {

        /*************** User route start *******************************/
        // Get user list
        Route::post("/api/get/user/list", [UserController::class, "getUserList"]);
        Route::post("/api/get/user/type/list", [UserController::class, "getUserTypeList"]);
        Route::post("/api/check/user/username", [UserController::class, "checkUsername"]);
        Route::post("/api/add/user", [UserController::class, "userAdd"]);
        Route::post("/api/get/user/info", [UserController::class, "getUserInfo"]);
        Route::post("/api/change/user/password", [UserController::class, "changePassword"]);

        // ============= user role permission start ==============
        Route::post("/api/get/permission/list", [RolePermissionController::class, "getPermissionList"]);
        Route::post("/api/store/permission", [RolePermissionController::class, "permissionAdd"]);
        Route::post("/api/get/permission-by-id", [RolePermissionController::class, "getPermissionById"]);
        Route::post("/api/delete/permission-record", [RolePermissionController::class, "deletePermission"]);
        Route::post("/api/get/role/list", [RolePermissionController::class, "getRoleList"]);
        Route::post("/api/store/role-permission", [RolePermissionController::class, "addRole"]);
        Route::post("/api/delete/role-record", [RolePermissionController::class, "deleteRole"]);
        Route::post("/api/update/role-permission", [RolePermissionController::class, "updateRole"]);
        Route::post("/api/get/user-role/list", [RolePermissionController::class, "getUserRoleList"]);
        Route::post("/api/update-user-role", [RolePermissionController::class, "updateUserRole"]);
        Route::post("/api/get/user-permission/list", [RolePermissionController::class, "getUserPermissionList"]);
        Route::post("/api/update-user-permission", [RolePermissionController::class, "updateUserPermission"]);

        // ============= user role permission end ==============

        /*************** User route end *******************************/

    });


});





