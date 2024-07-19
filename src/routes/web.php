<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkController;

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

Route::post('/work_start', [WorkController::class, 'workStart']);
Route::post('/work_end', [WorkController::class, 'workEnd']);
Route::post('/breaking_start', [WorkController::class, 'breakingStart']);
Route::post('/breaking_end', [WorkController::class, 'breakingEnd']);

Route::middleware('auth')->group(function () {
    Route::get('/', [WorkController::class, 'index']);
    Route::get('/attendance', [WorkController::class, 'search']);
});