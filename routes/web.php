<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\VocabularyController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\TranslateController;



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

    Route::group(["prefix" => "vocabulary", "as" => "vocabulary."], function () {
        Route::get('/index', [VocabularyController::class, 'index'])->name('index');
        Route::delete('/destroy/{vocabulary_id}',[VocabularyController::class, 'destroy'])->name('delete');
    });

    Route::group(["prefix" => "quiz", "as" => "quiz."], function () {
        Route::get('/settings', [QuizController::class, 'settings'])->name('settings');
        Route::post('/settings/step1', [QuizController::class, 'step1'])->name('settings.step1');
        Route::post('/start', [QuizController::class, 'start'])->name('start');
        Route::get('/run', [QuizController::class, 'run'])->name('run');
        Route::post('/record', [QuizController::class, 'record'])->name('record');
        Route::get('/result', [QuizController::class, 'result'])->name('result');
        Route::get('/card', [QuizController::class, 'card'])->name('card');
    });

    Route::group(['prefix' => 'chat', 'as' => 'chat.'], function () {
        Route::get('/', [ChatController::class, 'index'])->name('chat');
        Route::post('/send', [ChatController::class, 'send'])->name('send');
        Route::get('/fetch', [ChatController::class, 'fetch'])->name('fetch');
        Route::delete('/delete/{id}', [ChatController::class, 'destroy'])->name('destroy');
        Route::post('/report/{id}', [ChatController::class, 'report'])->name('report');
    });

    Route::post('/translate', [TranslateController::class, 'translate'])->name('translate');
});
