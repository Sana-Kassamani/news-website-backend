<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\NewsController;
// use App\Http\Controllers\User\CourseController;



Route::prefix("/news")->group(function() {
  Route::get("/", [NewsController::class, "getNews"]);
  Route::post("/", [NewsController::class, "createNews"]);
  Route::put("/{id}", [NewsController::class, "editNews"]);
  Route::delete("/{id}", [NewsController::class, "deleteNews"]);
//   Route::get("/{id}", [CourseController::class, "get_course"]);
//   Route::put("/{id}", [CourseController::class, "update_course"]);
//   Route::delete("/{id}", [CourseController::class, "delete_course"]);
});