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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/postal/{state}/{town}', 'PostalCodeController@index')
    ->where('state', '[0-9]+')
    ->where('town', '[0-9]+');

Route::get('/postal/state', 'PostalCodeController@indexStates');
Route::get('/postal/state/{state}', 'PostalCodeController@indexTowns')
    ->where('state', '[0-9]+');

Route::get('gobmx/gasstation/{state}/{town}', 'GobmxGasStationController@indexByPostalCode');