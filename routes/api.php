<?php

use App\Http\Controllers\API\ApplicationController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\JobPostingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::name("api.")->group(function () {
    Route::post("/login", [AuthController::class, "login"])->name("login");

    Route::middleware("auth:sanctum")->group(function () {
        Route::name("job-postings.")->prefix("/job-postings")->group(function () {
            Route::get("/", [JobPostingController::class, "index"])->name("index");

            Route::post("/", [JobPostingController::class, "store"])->middleware("role:client")->name("store");

            Route::put("/{jobPosting}/publish", [JobPostingController::class, "publish"])->middleware("role:client")->name("publish");

            Route::get("/{jobPosting}/applications", [JobPostingController::class, "applications"])->middleware("role:client")->name("applications");
        });

        Route::name("applications.")->prefix("/applications")->group(function () {
            Route::post("/", [ApplicationController::class, "store"])->middleware("role:freelancer")->name("store");
        });
    });
});
