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


Route::middleware('auth:api')->group(function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('tasks', 'Api\TaskController');
    Route::get('/tasks/list/{action}', 'Api\TaskController@index');
    Route::patch('/tasks/{task}/start', 'Api\TaskController@start');
    Route::patch('/tasks/{task}/end', 'Api\TaskController@end');
});
