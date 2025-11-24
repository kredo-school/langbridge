<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use App\Models\Profile;
use App\Models\Interest;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;


// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/users/search', [SearchController::class, 'search'])->name('users.search');


//test用なので後で削除
Route::get('/profiles/create', [ProfileController::class, 'create'])->name('profiles.create');
Route::post('/profiles', [ProfileController::class, 'store'])->name('profiles.store');




Route::get('/test-setup', function () {
    // 興味カテゴリを作成（なければ）
    $interests = ['Sports', 'Music', 'Technology', 'Entertainment', 'Travel', 'Food', 'Art', 'Science', 'Literature', 'Gaming', 'Fitness'];
    $interestIds = [];

    // Create interests if they don't exist
    foreach ($interests as $index => $interest) {
        $interest = Interest::firstOrCreate(['name' => $interest]);
        $interestIds[$index] = $interest->id;
    }



    return 'テストユーザーと興味を作成しました！';
});
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

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
});
