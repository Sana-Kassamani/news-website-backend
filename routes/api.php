<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\User\PostedNewsController;
// use App\Http\Controllers\User\CourseController;



Route::prefix("/admin")->group(function() {
  Route::get("/", [NewsController::class, "getNews"]);
  Route::post("/", [NewsController::class, "createNews"]);
  Route::put("/{id}", [NewsController::class, "editNews"]);
  Route::delete("/{id}", [NewsController::class, "deleteNews"]);
});


Route::prefix("/user")->group(function() {
    Route::get("/{id}", [PostedNewsController::class, "getUsersNews"]);
    Route::post("/{id}", [PostedNewsController::class, "post_articles"]);
    // Route::post("/", [NewsController::class, "createNews"]);
    // Route::put("/{id}", [NewsController::class, "editNews"]);
    // Route::delete("/{id}", [NewsController::class, "deleteNews"]);
  });