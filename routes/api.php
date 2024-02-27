<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::get('refresh-token', [\App\Http\Controllers\AuthController::class, 'refreshToken'])->middleware([
    'auth:sanctum',
    'ability:refresh',
]);


Route::get('{username}/{token}', [\App\Http\Controllers\LinkController::class, 'goLink']);

Route::group(['middleware' => ['auth:sanctum', 'ability:access']], function ()
{
    Route::get('logout', [\App\Http\Controllers\AuthController::class, 'logout']);

    Route::post('create-link', [\App\Http\Controllers\LinkController::class, 'createLink']);

    Route::get('my-links', [\App\Http\Controllers\LinkController::class, 'userLinks']);
});




