<?php


/*
|--------------------------------------------------------------------------
| Dealer Managment Routes
|--------------------------------------------------------------------------
|
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web']], function()
{
    Route::group(['prefix' => 'dealer','middleware' => ['permission:dealer'], 'namespace' => 'App\Modules\DealerManage\Controllers'], function(){

      	Route::get('index', 'DealerManageController@index')->name('dealer.manage.index');

      	Route::get('get-dealer-data', 'DealerManageController@getDealerData')->name('dealer.manage.index');

      	Route::get('get-dealer-by-id', 'DealerManageController@getDealerById')->name('dealer.manage.index');

      	Route::get('getAllDistrict', 'DealerManageController@getAllDistrict')->name('dealer.manage.index');

        Route::get('getAllDealers', 'DealerManageController@getAllDealers')->name('dealer.manage.index');

      	Route::get('getAllCitiesByDistrict', 'DealerManageController@getAllCitiesByDistrict')->name('dealer.manage.index');
		
		Route::post('upload', 'DealerManageController@upload')->name('dealer.manage.upload');

		Route::post('edit', 'DealerManageController@edit')->name('dealer.manage.index');

    });

});
