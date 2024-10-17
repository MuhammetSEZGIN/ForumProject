<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

;

Route::get('/mainMenu', [ArticleController::class, 'index'])->name('mainMenu');
Route::post("/register", [RegisterController::class , "register"])->name("register");
Route::get("/register", [RegisterController::class , "index"])->name("register.submit");
// Route::resource("register", RegisterController::class);
//?? Route::resource("/login", RegisterController::class,"login");

Route::get("/login", [LoginController::class , "index"])->name("login");
Route::post("/login", [LoginController::class , "login"])->name("login.submit");
Route::post("/logout", [LoginController::class , "logout"])->name("logout");

Route::get("/popularArticles", [ArticleController::class , "popularArticles"])->name("PopularArticles");
Route::get("/lastArticles", [ArticleController::class , "lastArticles"])->name("LastArticles");
Route::get("/article/{id}", [ArticleController::class , "findArticle"])->name("article");
// Route::get("/article/{id}/comments", [ArticleController::class , "comments"])->name("comments");
// Route::get("/index", ArticleController::class, "index")->name("index");

Route::post("/sendComment", [CommentController::class, "sendComment"])->name("sendComment");
