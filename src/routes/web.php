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

Route::post('/', [WorkController::class, 'store']);

Route::middleware('auth')->group(function () {
    Route::get('/', [WorkController::class, 'index']);
});

/*middleware */
Route::get('/search', [WorkController::class, 'search']);
