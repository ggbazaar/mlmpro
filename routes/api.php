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


// Route::group([
//     'prefix' => 'auth',
//     'middleware' => ['cors', 'json.response']
// ], function () {
//     Route::post('login', 'Api\AuthController@login');
//     Route::post('signup', 'Api\AuthController@signup');
//     Route::post('forgot-password', 'AuthController@forgotPassword');
//     Route::post('change-password', 'Api\AuthController@updatePassword');
//     Route::post('ccc', 'Api\AuthController@ccc');
// });


// Route::group([
//     'middleware' => ['cors', 'auth:api']
// ], function () {
    Route::post('/create-user', [UsermlmController::class, 'store']);
    Route::post('/pairlevel', [UsermlmController::class, 'pairlevel']);
    Route::post('/getadvisorlist', [GetAdvisorList::class, 'find']);
    Route::post('/downline', [GetAdvisorList::class, 'downline']);
    Route::post('/payment', [GetAdvisorList::class, 'payment']);
    Route::post('/payment_approved', [GetAdvisorList::class, 'payment_approved']);
    
// });

Route::post('/signin', [UsermlmController::class, 'signin']);
Route::post('/login', [UsermlmController::class, 'login']);





