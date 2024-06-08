<?php

use System\route\Base as Route;
use App\Controllers\Auth\LoginController;


// Middleware group route
Route::groupMiddleware(["isLogin"], function () {
    // Login page route
    Route::get("/login", [LoginController::class, "login"]);
});




