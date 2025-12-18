<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\TranslateController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Middleware\IsAdmin;


Auth::routes();


Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);


Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::group(["prefix" => "profile", "as" => "profile."], function () {
        Route::get('show/{user_id}', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/update', [ProfileController::class, 'update'])->name('update');
    });

    Route::group(["prefix" => "setting", "as" => "setting."], function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::put('/', [SettingController::class, 'update'])->name('update');
    });


    Route::group(["prefix" => "user", "as" => "user."], function () {
        Route::delete('/destroy', [UserController::class, 'destroy'])->name('delete');
    });

    Route::get('/users/search', [SearchController::class, 'search'])->name('users.search');

    Route::group(['prefix' => 'chat', 'as' => 'chat.'], function () {
        Route::get('/', [ChatController::class, 'index'])->name('chat');
        Route::post('/send', [ChatController::class, 'send'])->name('send');
        Route::get('/fetch', [ChatController::class, 'fetch'])->name('fetch');
        Route::delete('/delete/{id}', [ChatController::class, 'destroy'])->name('destroy');
        Route::post('/report/{id}', [ChatController::class, 'report'])->name('report');
    });

    Route::post('/translate', [TranslateController::class, 'translate'])->name('translate');
});

Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
        Route::get('/reports/users', [AdminReportController::class, 'users'])->name('admin.reports.users');
        Route::get('/reports/messages', [AdminReportController::class, 'messages'])->name('admin.reports.messages');
        Route::post('/reports/{id}/action', [AdminReportController::class, 'action'])->name('admin.reports.action');

    });
});

