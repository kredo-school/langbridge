<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::group(["prefix"=>"profile","as"=>"profile."],function(){
        Route::get('show/{user_id}',[ProfileController::class,'show'])->name('show');
        Route::get('/edit',[ProfileController::class,'edit'])->name('edit');
        Route::patch('/update',[ProfileController::class,'update'])->name('update');
        
    });

});