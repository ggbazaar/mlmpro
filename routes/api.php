<?php

use Illuminate\Http\Request;
use App\Http\Controllers\UsermlmController;
use App\Http\Controllers\GetAdvisorList;
use App\Http\Controllers\CommissionController;

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
    // Route::post('/pairlevel', [UsermlmController::class, 'pairlevel']);
    Route::post('/findbyfield', [UsermlmController::class, 'findbyfield']);

    Route::post('/advisorList', [UsermlmController::class, 'advisorList']);
    Route::post('/uplineListUntilRoot', [UsermlmController::class, 'uplineListUntilRoot']);
    Route::post('/uplineListBreakFirstZero', [UsermlmController::class, 'uplineListBreakFirstZero']);
    Route::post('/admin', [UsermlmController::class, 'adminSignin']);

    Route::post('/getadvisorlist', [GetAdvisorList::class, 'find']);
    Route::post('/downline', [GetAdvisorList::class, 'downline']);
    Route::post('/downline_type', [GetAdvisorList::class, 'downline_type']);
    Route::post('/payment', [GetAdvisorList::class, 'payment']);
    Route::post('/payment_approved', [GetAdvisorList::class, 'payment_approved']);
    Route::get('/getkitamount', [GetAdvisorList::class, 'getkitamount']);
    Route::post('/pairlevel', [GetAdvisorList::class, 'pairlevel']);

    //Route::post('/generate_commission', [CommissionController::class, 'generate_commission']);
    Route::post('/updateLevel', [CommissionController::class, 'updateLevel']);
    Route::post('/genLevel', [CommissionController::class, 'genLevel']);
    Route::post('/generateLevel', [CommissionController::class, 'generateLevel']);

    Route::put('/updateUserDetails/{user_id}', [UserMlmController::class, 'updateUserDetails']);
    Route::post('/commissionlist', [CommissionController::class, 'commissionlist']);

    Route::post('/dashboard', [UsermlmController::class, 'dashboard']);




    
// });

Route::post('/signin', [UsermlmController::class, 'signin']);
Route::post('/login', [UsermlmController::class, 'login']);





