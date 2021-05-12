<?php

use Illuminate\Http\Request;

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

// if (0) { // I don't need this...
//     Route::middleware('auth:api')->get('/user', function (Request $request) {
//         return $request->user();
//     });
// }
Route::post('login', 'AuthenticationController@login')->name('login.api');
Route::post('register', 'AuthenticationController@register')->name('register.api');
Route::post('logout', 'AuthenticationController@logout')->name('logout.api');

Route::middleware('auth:api')->group(function () {
    // Route::resource('products', 'ProductController');

    //About Users
    Route::post('get_auth_user', 'AuthenticationController@user_details');
    Route::post('users', 'UserController@list');

    //About Surveys
    Route::post('create_survey', 'SurveyController@store');
    Route::post('read_allSurveys_byOwner', 'SurveyController@getAllByOwner');
    Route::post('update_survey', 'SurveyController@update');
    Route::post('delete_survey', 'SurveyController@destroy');

    //About Branchs
    Route::post('create_branch', 'BranchController@store');
    Route::post('read_allBranchs_byOwner', 'BranchController@getAllByOwner');
    Route::post('update_branch', 'BranchController@update');
    Route::post('delete_branch', 'BranchController@destroy');
});