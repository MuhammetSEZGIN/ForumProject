<?php

use App\Http\Controllers\ArticalController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

;

Route::view("/","welcome");

Route::get("/register", [RegisterController::class , "create"]);
// Route::resource("register", RegisterController::class);
//?? Route::resource("/login", RegisterController::class,"login");

Route::get("/login", [RegisterController::class , "login"]);

Route::resource("articles", ArticalController::class);
