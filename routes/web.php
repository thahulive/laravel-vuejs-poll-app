<?php

use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::group(['middleware' => ['auth']], function () {
    
    // Return auth user data
    Route::get('/me', function (Request $request) {
        return \Response::json([
            'data' => \Auth::user()
        ], 200);
    });

    Route::get('/polls', 'PollController@index');
    Route::get('/polls/{poll}', 'PollController@show');
    Route::post('/polls/{poll}/vote', 'PollController@vote');
    Route::post('/polls/create', 'PollController@store');
    Route::put('/polls/{poll}', 'PollController@saveOptions');
    Route::put('/polls/{poll}/suggestion', 'OptionRequestController@store');

    Route::get('/{any}', function () {
        return view('poll-app');
    })->where('any', '.*');
});

