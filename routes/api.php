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


Route::group(['middleware' => ['api']], function(){

	Route::get('auth', 'Api\ApiController@auth')->name('auth');

	Route::post('auth1', 'Api\ApiController@auth1')->name('auth');

	Route::any('json/get-asset-data', 'Api\ApiController@getAssetData')->name('auth');

	Route::any('json/get-asset-data-test/{id}', 'Api\ApiController@getAssetDataTest')->name('auth');

	Route::post('json/create-complain', 'Api\ApiController@createComplain')->name('auth');

	Route::get('json/complain-list', 'Api\ApiController@getComplainList')->name('auth');

	Route::group(['prefix' => 'stock_taker'], function(){

      	Route::get('verifyCode', 'Api\ApiStockTakerController@verifyCode')->name('verify');

		Route::get('verifyProductCode', 'Api\ApiStockTakerController@verifyProductCode')->name('verify_product_code');

		Route::get('sendTake', 'Api\ApiStockTakerController@sendTake')->name('send_take');

		Route::get('getTakes', 'Api\ApiStockTakerController@getTakes')->name('get_takes');

		Route::get('getTakesDetails', 'Api\ApiStockTakerController@getTakesDetails')->name('get_takes_details');

		Route::get('createTake', 'Api\ApiStockTakerController@createTake')->name('create_take');
    });

});


	