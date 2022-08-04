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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/question', 'API\QuestionController@index');
Route::post('/question/auth', 'API\QuestionController@auth');
Route::post('/question/submit', 'API\QuestionController@submit');
Route::post('/question/example/submit', 'API\QuestionController@submitExample');

Route::get('/question/disc-24-soal', 'API\DISC24Controller@index');