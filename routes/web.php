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

Auth::routes();

Route::get('/',[PostController::class, 'index']);

Route::get('/create',[PostController::class, 'create']);
Route::post('/create',[PostController::class, 'store']);

Route::get('/post/{post:id}/edit',[PostController::class, 'edit']);
Route::post('/post/{post:id}/edit',[PostController::class, 'update']);
Route::delete('/post/{post:id}/edit',[PostController::class, 'destroy']);