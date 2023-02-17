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
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'UserControl\AuthController@login');
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', 'UserControl\AuthController@logout');
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'helpdesk','middleware' => 'auth:api'], function () {
    Route::get('all', 'Helpdesk\HelpdeskController@AllHelpdesk');
    Route::get('activity', 'Helpdesk\HelpdeskController@HelpdeskActivity')->middleware('role:Admin|User Staff');
});

Route::group(['prefix' => 'okm'], function () {
    Route::get('material/{division?}', 'Elearning\MaterialController@AllMaterial');
    Route::get('all', 'Elearning\QuestionController@exam_list');
    Route::get('schedule/all', 'Elearning\ScheduleController@schedule_list');
    Route::get('raport/all', 'Elearning\RaportController@raport_list');
});
