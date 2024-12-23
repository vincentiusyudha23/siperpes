<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::controller(UserController::class)->group(function(){
    Route::get('/', 'index')->name('home');
    Route::get('/get-info-perumahan/{id}', 'getPerumahan')->name('getInfoPerumahan');

    Route::middleware('guest')->group(function(){
        Route::get('/login', 'login')->name('login');
        Route::post('/login-req', 'requestLogin')->name('login.req');
    });

    Route::middleware('auth')->prefix('/admin')->name('user.')->group(function(){
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/perumahan', 'perumahan')->name('perumahan');
        Route::get('/add-perum', 'add_perum')->name('perumahan.add');
        Route::post('/create-perum', 'create_perum')->name('perumahan.store');
        Route::post('/getlatlng', 'req_get_lnglat')->name('getlatlng-req');
    });
});
