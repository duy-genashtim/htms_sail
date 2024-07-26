<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\GraphMailerController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::redirect('/', 'login');
// Route::get('/admin/dashboard', function () { return view('dashboard'); });
Route::group(['middleware' => ['web']], function(){
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::get('connect', [AuthController::class, 'connect'])->name('connect');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('profile', [AuthController::class, 'getCurrentUser'])->name('profile');
    Route::get('/get-avatar/{email}', [AuthController::class, 'getAvatar'])->name('getAvatar');
    Route::get('run', [AuthController::class, 'runCommand'])->name('runCommand');
    Route::get('test', [AuthController::class, 'test'])->name('test');
});

Route::group(['middleware' => ['web', 'MsGraphAuthenticated'], 'prefix' => 'admin'], function(){
    Route::get('{view}',ApplicationController::class)->where('view','.*');
});
// Route::view('/{any}','admin.layouts')->where('any','.*');

