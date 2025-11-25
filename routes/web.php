<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;


// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::group(["prefix" => "profile", "as" => "profile."], function () {
        Route::get('show/{user_id}', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/update', [ProfileController::class, 'update'])->name('update');
    });

    Route::group(["prefix" => "setting", "as" => "setting."], function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::patch('/', [SettingController::class, 'update'])->name('update');
    });

    Route::group(["prefix" => "user", "as" => "user."], function () {
        Route::delete('/destroy', [UserController::class, 'destroy'])->name('delete');
    });

    Route::get('/users/search', [SearchController::class, 'search'])->name('users.search');
});
