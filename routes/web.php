<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RegisterController;
use App\Http\Middleware\UserLogs;
use App\Mail\AuthReset;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/test', function () {
    Mail::to('sezginmuhammet454@gmail.com')->send(new AuthReset());
    return "Mail Sent";
});
Route::get('/info', function () {
   return
       phpinfo();

});

//Admin Routes
Route::get("/index", [AdminController::class, "index"])->name("adminIndex");
Route::get("/userLogs", [AdminController::class, "userLogs"])->name("userLogs");
Route::delete("/userLogs/delete/{id}", [AdminController::class, "userLogsDelete"])->name("userLogsDelete");
Route::delete("/userLogs/deleteAll", [AdminController::class, "userLogsDeleteAll"])->name("userLogsDeleteAll");
Route::delete("/user/delete/{id}", [AdminController::class, "userDelete"])->name("userDelete");
Route::get("/allUsers", [AdminController::class, "allUsers"])->name("allUsers");

Route::get("/reportedComments", [AdminController::class, "reportedComments"])->name("reportedComments");
Route::get("reportedArticles ", [AdminController::class, "reportedArticles"])->name("reportedArticles");
Route::delete("/comment/delete/{id}", [AdminController::class, "commentDelete"])->name("commentsDelete");
Route::delete("/article/delete/{id}", [AdminController::class, "articleDelete"])->name("articleDelete");

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

Route::group([ 'middleware' => ['auth'] ],
    function()
    {
        Route::get("/myarticle/{id}", [ArticleController::class, "editArticleShow"])->name("article.edit.show");
        Route::patch("/article/{id}", [ArticleController::class, "editArticle"])->name("editArticle");
        Route::delete("/article/{id}", [ArticleController::class, "deleteArticle"])->name("deleteArticle");

        Route::post("/addArticle", [ArticleController::class, "addArticle"])->name("addArticle.submit");
        Route::get("/addArticle", [ArticleController::class, "addArticleShow"])->name("addArticle");
        Route::get("/myArticles", [ArticleController::class, "myArticles"])->name("myArticles");

        Route::delete("/comment/delete/{id}", [CommentController::class, "deleteComment"])->name("deleteComment");
        Route::patch("/approveComment/{id}", [CommentController::class, "approveComment"])->name("approveComment");
    });

Route::get("/article/{id}", [ArticleController::class, "findArticle"])->name("showArticle");

Route::get("/popularArticles", [ArticleController::class, "popularArticles"])->name("PopularArticles");
Route::get("/lastArticles", [ArticleController::class, "lastArticles"])->name("LastArticles");

// Comment Routes
Route::post("/sendComment", [CommentController::class, "sendComment"])->name("sendComment");
Route::get("/comments", [CommentController::class, "myComments"])->name("myComments")->middleware("auth");
Route::post("/reportComment/{id}", [CommentController::class, "reportComment"])->name("reportComment");
Route::post("/reportArticle/{id}", [ArticleController::class, "reportArticle"])->name("reportArticle");


Route::get("/test",[FileController::class, "test"])->name("test");
Route::get("/userLogExportExcel",[AdminController::class, "userLogExportExcel"])->name("userLogExportExcel");
Route::post("/exportArticleToExcel/{id}",[ArticleController::class, "exportArticleToExcel"])->name("exportArticleToExcel");
Route::post("/importArticleToExcel",[ArticleController::class, "importArticleToExcel"])->name("importArticleToExcel");

Route::get("takeArticlesFromFiles",[FileController::class, "takeArticlesFromFiles"])->name("takeArticlesFromFiles");
Route::get("createAndSendRaporFiles",[FileController::class, "createAndSendRaporFiles"])->name("createAndSendRaporFiles");
