<?php


/*
|--------------------------------------------------------------------------
| Customer Managment Routes
|--------------------------------------------------------------------------
|
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web']], function()
{
    Route::group(['prefix' => 'customer','middleware' => ['permission:customer'], 'namespace' => 'App\Modules\CustomerManage\Controllers'], function(){

      	Route::get('index', 'CustomerManageController@index')->name('customer.manage.index');

      	Route::get('get-customer-data', 'CustomerManageController@getCustomerData')->name('customer.manage.index');

      	Route::get('get-customer-by-id', 'CustomerManageController@getCustomerById')->name('customer.manage.index');

      	Route::get('getAllDistrict', 'CustomerManageController@getAllDistrict')->name('customer.manage.index');

        Route::get('getAllCustomers', 'CustomerManageController@getAllCustomers')->name('customer.manage.index');

        Route::get('get-customer-by-city', 'CustomerManageController@getCustomerByCity')->name('customer.manage.index');

      	Route::get('getAllCitiesByDistrict', 'CustomerManageController@getAllCitiesByDistrict')->name('customer.manage.index');
		
		Route::post('upload', 'CustomerManageController@upload')->name('customer.manage.upload');

		Route::post('edit', 'CustomerManageController@edit')->name('customer.manage.index');

    });

});
