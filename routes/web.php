<?php

use App\Http\Controllers\AuthenController;
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

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['web'])->group(function () {
    Route::get('auth/google', [AuthenController::class, 'redirectToGoogle']);
    Route::get('auth/google/callback', [AuthenController::class, 'handleGoogleCallback']);
});
