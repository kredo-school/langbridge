<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegisterController;

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

    Route::group(["prefix"=>"register","as"=>"register."],function(){
        Route::get('/register/1',[RegisterController::class,'show1'])->name('show1');
        Route::get('/register/2',[RegisterController::class,'show2'])->name('show2');
        Route::post('/register/1',[RegisterController::class,'store1'])->name('store1');
        Route::post('/register/2',[RegisterController::class,'store2'])->name('store2');    
    });

    Route::group(["prefix" => "user", "as" => "user."], function () {
        Route::delete('/destroy', [UserController::class, 'destroy'])->name('delete');
    });

    Route::get('/users/search', [SearchController::class, 'search'])->name('users.search');
});
