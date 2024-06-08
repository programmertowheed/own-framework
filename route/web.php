<?php

use System\route\Base as Route;
use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\Backend\DashboardController;
use App\Controllers\Backend\RolePermissionController;

// Home page route
Route::get("/", [HomeController::class, "home"]);

// Auth middleware group route
Route::groupMiddleware(["auth"], function () {
    // Dashboard route
    Route::get("/dashboard", [DashboardController::class, "dashboard"])->middleware(["can:view.dashboard"]);

    // Change password router
    Route::get("/change/password", [UserController::class, "changePasswordPage"])->middleware(["can:change.password"]);

    /* Permission route start */
    Route::get("/permission/list", [RolePermissionController::class, "permissionListPage"]);
    Route::get("/role/list", [RolePermissionController::class, "roleList"]);
    Route::get("/role/create", [RolePermissionController::class, "createRole"]);
    Route::get("/role/edit/{id}", [RolePermissionController::class, "editRole"]);
    Route::get("/add/user/role", [RolePermissionController::class, "addUserRole"]);
    Route::get("/add/user/permission", [RolePermissionController::class, "addUserPermission"]);
    /* Permission route end */


});
