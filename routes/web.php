<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GetController;
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

//Route::get('/', function () {return view('welcome');});

Route::post('/api/v1/notebook/', [PostController::class, 'AddNewUser']);
Route::post('/api/v1/notebook/{id}', [PostController::class, 'UpdateUser']);
Route::get('/api/v1/notebook/', [GetController::class, 'LoadAll']);
Route::get('/api/v1/notebook/{id}', [GetController::class, 'LoadID']);
