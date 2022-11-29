<?php

use App\Http\Controllers\AccessController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Models\User;
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
    return view('index');
});
//Route::view('login', 'login')->name('login');
//Route::view('access.access', 'access')->name('access');

Route::get('access_form', [AccessController::class, 'accessForm']);
Route::get('login_form', [LoginController::class, 'loginForm'])->name('login');


Route::middleware(['auth', 'state'])->group(function () {
    Route::resource('user', UserController::class)->middleware('state');
    Route::put('user', [UserController::class, 'update']);
    Route::get('user_history/{id}', [UserController::class, 'history']);
    Route::get('user_pdf/{id}', [UserController::class, 'pdf']);
    Route::post('user_import', [UserController::class, 'import']);
    Route::post('filter', [UserController::class, 'filters']);
    Route::post('filter_history', [UserController::class, 'filterHistory']);
});

Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout']);
Route::post('access', [AccessController::class, 'save']);
