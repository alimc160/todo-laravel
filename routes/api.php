<?php

use App\Http\Controllers\Api\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('register', [AuthController::class, 'register']);
Route::post('verify-user',[AuthController::class,'verifyUser']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:api')->group(function (){
    Route::post('logout',[AuthController::class,'logout']);
    Route::prefix('todo')->group(function (){
        Route::get('list',[TodoController::class,'getTodoListing']);
        Route::post('add-item',[TodoController::class,'addTodo']);
        Route::get('/{id}',[TodoController::class,'getTodo']);
        Route::post('update/{id}',[TodoController::class,'updateTodo']);
        Route::post('delete/{id}',[TodoController::class,'deleteTodo']);
    });
});
