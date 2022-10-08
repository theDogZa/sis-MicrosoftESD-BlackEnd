<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(
    ['prefix' => 'frontEnd/v1', 'middleware' => 'api'],
    function () {
        Route::Post('/add-logs', 'API\LogsController@addLogs')->name('log.addLogs');
        Route::get('/add-logs', 'API\LogsController@addLogs')->name('log.addLogs');
        Route::post('/getLicense', 'API\MicrosoftController@getLicensesByOrder')->name('ms.getLicense');
        Route::fallback(function () {
            return view('errors.404');
        });
    });

Route::group(['prefix' => 'v2', 'middleware' => 'api'], function () {
    Route::Post('/chk-password', 'Auth\ChangePasswordController@checkPassword')->name('chk.pass');
    Route::Post('/chk-username', 'Auth\ProfilesController@checkUsername')->name('chk.username');
    Route::Post('/chk-email', 'Auth\ProfilesController@checkEmail')->name('chk.email');

    Route::fallback(function () {
        return view('errors.404');
    });
});
Route::group(
    ['prefix' => 'ms/v1', 'middleware' => ['api']],
    function () {
        
    });

Route::group(['prefix' => 'sap', 'middleware' => ['api', 'cors']], function () {

    //------------- app
    Route::get('/get-data', 'API\SAPController@getDataBillings')->name('sap.getData');
    Route::fallback(function () {
        return view('errors.404');
    });
});


/** 
 * SiS Microsoft ESD
 *
 * Modify/Update BY PRASONG PUTICHANCHAI
 * 
 * Latest Update : 13/12/2021 11:00
 * Version : ver.0.00.01
 *
 */
