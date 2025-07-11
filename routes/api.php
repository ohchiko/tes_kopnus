<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\JobPostingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::name("api.")->group(function () {
    Route::post("/login", [AuthController::class, "login"])->name("login");

    Route::middleware("auth:sanctum")->group(function () {
        Route::get("/user", [AuthController::class, "user"])->middleware(["auth:sanctum"])->name("user");

        Route::name("job-postings.")->prefix("/job-postings")->group(function () {
            Route::get("/", [JobPostingController::class, "index"])->name("index");

            Route::post("/", [JobPostingController::class, "store"])->middleware("role:client")->name("store");

            Route::put("/{jobPosting}/publish", [JobPostingController::class, "publish"])->middleware("role:client")->name("publish");
        });
    });
});
