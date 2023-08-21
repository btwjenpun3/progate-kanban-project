<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

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

Route::get('/', function () {
    return view('home');
})->name('home');


// Route::get('/', [HomeController::class, 'welcome']);

// Route::prefix('tasks')
//     ->name('tasks.')
//     ->controller(TaskController::class)
//     ->group(function () {
//         Route::get('/', 'index')->name('index');
//         Route::get('{id}/edit', 'edit')->name('edit');
//         Route::get('create', 'create')->name('create');
//     });

Route::prefix('tasks')
    ->name('tasks.')
    ->controller(TaskController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create/{status?}', 'create')->name('create');
        Route::post('/', 'store')->name('store');  // Ditambahkan
        Route::get('{id}/edit', 'edit')->name('edit');
        Route::put('{id}/edit', 'update')->name('update');
        Route::get('{id}/delete', 'delete')->name('delete');
        Route::delete('{id}/destroy', 'destroy')->name('destroy');
        Route::get('progress', 'progress')->name('progress');
        Route::patch('{id}/move', 'move')->name('move');
        Route::get('{id}/cardcomplete', 'cardComplete')->name('cardComplete');
        Route::get('{id}/listcomplete', 'listComplete')->name('listComplete');
    });

Route::name('auth.')
    ->controller(AuthController::class)
    ->group(function () {
        Route::get('signup', 'signupForm')->name('signupForm');
        Route::post('signup', 'signup')->name('signup');
        Route::get('login', 'loginForm')->name('loginForm');
        Route::post('login', 'login')->name('login');
        Route::post('logout', 'logout')->name('logout');
    });

Route::get('/halo', function () {
    return '<h1>Halo, Ninja!</h1>';
});

Route::resource('users', UserController::class);