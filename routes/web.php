<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\JsonResponse;

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

/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', function () {
    // redirect関数にパスを指定する方法
    return redirect('/tweet');
});

require __DIR__.'/auth.php';

//Route::get('/sample', [\App\Http\Controllers\Sample\IndexController::class, 'show']);

//Route::get('/sample/{id}', [\App\Http\Controllers\Sample\IndexController::class, 'showId']);

Route::get('/tweet', \App\Http\Controllers\Tweet\IndexController::class)->name('tweet.index');
Route::middleware('auth')->group(function () {
    Route::post('/tweet/create', \App\Http\Controllers\Tweet\CreateController::class)
        ->name('tweet.create'); //->middleware('auth')は削除
    Route::get('/tweet/update/{tweetId}', \App\Http\Controllers\Tweet\Update\IndexController::class)->name('tweet.update.index');
    Route::put('/tweet/update/{tweetId}', \App\Http\Controllers\Tweet\Update\PutController::class)->name('tweet.update.put');
    Route::delete('/tweet/delete/{tweetId}', \App\Http\Controllers\Tweet\DeleteController::class)->name('tweet.delete');
});

Route::get('/health', function (): JsonResponse {
    return response()->json(['status' => 'ok'], 200);
});