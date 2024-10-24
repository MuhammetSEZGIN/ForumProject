<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RegisterController;
use App\Http\Middleware\UserLogs;
use App\Mail\AuthReset;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    Mail::to('sezginmuhammet454@gmail.com')->send(new AuthReset());
    return "Mail Sent";
});

// Register Routes
Route::post("/register", [RegisterController::class, "register"])->name("register.submit");
Route::get("/register", [RegisterController::class, "index"])->name("register");

// Login Routes
Route::get("/login", [LoginController::class, "index"])->name("login");
Route::post("/login", [LoginController::class, "login"])->name("login.submit");
Route::post("/logout", [LoginController::class, "logout"])->name("logout");

// Article Routes
Route::get('/', [ArticleController::class, 'index'])->name('mainMenu');
Route::get('/mainMenu', [ArticleController::class, 'index'])->name('mainMenu');

Route::get("/article/{id}", [ArticleController::class, "findArticle"])->name("showArticle");
Route::get("/myarticle/{id}", [ArticleController::class, "editArticleShow"])->name("article.edit.show")->middleware("auth");
Route::patch("/article/{id}", [ArticleController::class, "editArticle"])->name("editArticle")->middleware("auth");
Route::delete("/article/{id}", [ArticleController::class, "deleteArticle"])->name("deleteArticle")->middleware("auth");;

Route::post("/addArticle", [ArticleController::class, "addArticle"])->name("addArticle.submit")->middleware("auth");;
Route::get("/addArticle", [ArticleController::class, "addArticleShow"])->name("addArticle")->middleware("auth");;
Route::get("/myArticles", [ArticleController::class, "myArticles"])->name("myArticles")->middleware("auth");;
Route::get("/popularArticles", [ArticleController::class, "popularArticles"])->name("PopularArticles");
Route::get("/lastArticles", [ArticleController::class, "lastArticles"])->name("LastArticles");

// Comment Routes
Route::post("/sendComment", [CommentController::class, "sendComment"])->name("sendComment");
Route::get("/comments", [CommentController::class, "myComments"])->name("myComments")->middleware("auth");;
Route::delete("/comment/delete/{id}", [CommentController::class, "deleteComment"])->name("deleteComment")->middleware("auth");;
Route::patch("/approveComment/{id}", [CommentController::class, "approveComment"])->name("approveComment")->middleware("auth");;
