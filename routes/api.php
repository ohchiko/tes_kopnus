<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::name("api.")->group(function () {
    Route::post("/login", [AuthController::class, "login"])->name("login");

    Route::get("/user", [AuthController::class, "user"])->middleware(["auth:sanctum"])->name("user");
});
