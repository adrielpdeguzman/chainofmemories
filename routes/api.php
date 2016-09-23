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

Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'journals', 'as' => 'journals.'], function () {
    Route::get('random', 'JournalController@random')
        ->name('random');
    Route::get('dates_without_entry', 'JournalController@getDatesWithoutEntry')
        ->name('dates_without_entry');
});

Route::singularResourceParameters();
Route::resource('journals', 'JournalController', ['only' => [
    'index', 'store', 'show', 'update',
]]);
