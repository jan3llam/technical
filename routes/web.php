<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\SubscriberController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login',[AuthController::class, 'login'])->name('login');
Route::get('/logout',[AuthController::class, 'logout'])->name('logout');

Route::group(['prefix' => 'subscribers', 'as' => 'subscribers.'], function () {

    Route::get('/', [SubscriberController::class, 'index'])->name('index');
    Route::post('/', [SubscriberController::class, 'store'])->name('store');
    Route::get('/create', [SubscriberController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [SubscriberController::class, 'edit'])->name('edit');
    Route::post('/edit/{id}', [SubscriberController::class, 'update'])->name('update');
    Route::delete('/{id}', [SubscriberController::class, 'destroy'])->name('destroy');
});

Route::group(['prefix' => 'blogs', 'as' => 'blogs.','middleware' => ['auth']], function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/blog/{id}', [BlogController::class, 'show'])->name('show');
    Route::get('/create', [BlogController::class, 'create'])->name('create');
    Route::post('/', [BlogController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [BlogController::class, 'edit'])->name('edit');
    Route::post('/edit/{id}', [BlogController::class, 'update'])->name('update');
    Route::delete('/{id}', [BlogController::class, 'destroy'])->name('destroy');
});
