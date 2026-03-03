<?php
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BlogController::class,'index']);
Route::resource('blogs', BlogController::class);
Route::get('blog-status/{blog}', [BlogController::class,'toggleStatus'])->name('blog.status');
