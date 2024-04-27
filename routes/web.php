<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LineController;
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

Route::get('/suc',function (){
    return response()->json(['login success']);
});
//Route::get('/auth/line', 'Auth\LoginController@redirectToLine');


Route::get('/auth/line', [LoginController::class,'redirectToLine'])->name('line.login');
Route::get('/auth/line/callback', [LoginController::class,'handleLineCallback']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
