<?php

use System\route\Base as Route;
use App\Controllers\Towheed;


//Route::get("/", function () {
//    return response()->json(["hello" => "message"]);
//});

//Route::groupMiddleware("/", function () {
//    return response()->json(["hello" => "message"]);
//});


Route::get("/", [Towheed::class, "get"]);
Route::get("/profile/{id}/{name?}", [Towheed::class, "getNew"]);

Route::post("/", [Towheed::class, "post"]);
Route::put("/", [Towheed::class, "put"]);
Route::delete("/", [Towheed::class, "delete"]);






