<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostController;

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

Route::get('/',[PagesController::class, 'index']);
Route::post('/',[PagesController::class, 'authenticate']);

Route::get('/main',[PostController::class, 'index']);

Route::get('/main/create',[PostController::class, 'create']);
Route::post('/main/create',[PostController::class, 'store']);