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

Route::group(['middleware' => ['cors']], function () {
    //Add you routes here, for example:

    Route::resource('/saleman', 'TbSalesmanController', []);
    Route::resource('/user', 'UserController', []);
    Route::resource('/checkDuplicationData', 'CheckDuplicationDataController', []);
});
