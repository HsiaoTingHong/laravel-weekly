<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// 回傳所有使⽤者
Route::get('/users', [UserController::class, 'index']);

// 新增使⽤者（驗證 name & email ）
Route::post('/users', [UserController::class, 'store']);

// 查詢特定使⽤者
Route::get('/users/{id}', [UserController::class, 'show']);

// 整筆更新使⽤者
Route::put('/users/{id}', [UserController::class, 'update']);

// 刪除使⽤者
Route::delete('/users/{id}', [UserController::class, 'destroy'])->middleware('admin');
