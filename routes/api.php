<?php

use Illuminate\Http\Request;
use App\Http\Controllers\UsermlmController;
use App\Http\Controllers\GetAdvisorList;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/create-user', [UsermlmController::class, 'store']);
Route::post('/pairlevel', [UsermlmController::class, 'pairlevel']);
Route::post('/signin', [UsermlmController::class, 'signin']);
Route::post('/login', [UsermlmController::class, 'login']);



Route::post('/getadvisorlist', [GetAdvisorList::class, 'find']);


