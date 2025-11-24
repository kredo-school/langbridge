<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use App\Models\Profile;
use App\Models\Interest;


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
