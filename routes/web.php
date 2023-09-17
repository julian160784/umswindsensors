<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. The se
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('user', 'UserController')->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::resource('sensorSetting', 'SensorSettingController')->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::get("sensorLog/exportToExcel", "SensorLogController@exportToExcel");
    Route::get("sensorLog", "SensorLogController@index");
    Route::get("sensorLog/getLastData", "SensorLogController@getLastData");
    Route::get("sensorLog/getTekanan", "SensorLogController@getTekanan");
    Route::get("sensorLog/getLogAngin", "SensorLogController@getLogAngin");
    Route::get('getTerbitTerbenam', 'SensorLogController@getTerbitTerbenam');
    Route::get('me', 'UserController@me');
    Route::get('getLastUpdate', 'SensorLogController@getLastUpdate');
});

Route::get('/{any}', 'HomeController@index')->where('any', '.*');
