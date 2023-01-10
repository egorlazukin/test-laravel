<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GetController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\DeleteController;
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

Route::post('/api/v1/notebook/', [PostController::class, 'AddNewUser']); //возращает список пользователей

Route::post('/api/v1/notebook/{id}', [PostController::class, 'UpdateUser']); //передать ID пользователя, вернет инфу по нему

Route::get('/api/v1/notebook/', [GetController::class, 'LoadAll']); //передать данные пользователя, если возращает 400 - не все поля возращает. 

Route::get('/api/v1/notebook/{id}', [GetController::class, 'LoadID']); //передать ID пользователя и те поля которые хотите изменить 

Route::delete('/api/v1/notebook/{id}', [DeleteController::class, 'DeleteID']);//передать ID пользователя, удалит этого пользователя

