<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [PageController::class, 'index'])->name('index');
    Route::get('/pinned', [PageController::class, 'pinned'])->name('pinned');
//    Route::get('/users', [ProfileController::class, 'index'])->name('users.index');
    Route::get('/profile/{slug}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/pages/{slug}', [PageController::class, 'show'])->name('pages.show');
    Route::resource('/posts', PostController::class);
});

Route::group(['prefix' => 'auth', 'as' => 'auth.', 'middleware' => 'guest'], function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginAction']);
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerAction']);
    Route::get('/lost-password', [AuthController::class, 'lostPassword'])->name('lost-password');
    Route::post('/lost-password', [AuthController::class, 'lostPasswordAction']);
    Route::post('/reset-password', [AuthController::class, 'resetPasswordAction'])->name('reset-password');
});

Route::get('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');

Route::any('/auth/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('auth.logout');
