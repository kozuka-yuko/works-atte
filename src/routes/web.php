<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkController;
use GuzzleHttp\Middleware;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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
Route::get('/person-work', [WorkController::class, 'personWork']);
Route::get('/all-member', [WorkController::class, 'searchName']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [WorkController::class, 'index']);
    Route::get('/attendance', [WorkController::class, 'searchWorkDate']);
    Route::get('/all-member/search', [WorkController::class, 'searchName']);
});

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request){
    $request->fulfill();

    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request){
  $request->user()->sendEmailVerificationNotification();
  
  return back()->with('message', '確認リンクが送信されました。');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');