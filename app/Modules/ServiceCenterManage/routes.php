<?php


/*
|--------------------------------------------------------------------------
| Service Center Managment Routes
|--------------------------------------------------------------------------
|
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web']], function()
{
    Route::group(['prefix' => 'service-center','middleware' => ['permission:service-center'], 'namespace' => 'App\Modules\ServiceCenterManage\Controllers'], function(){

      	Route::get('index', 'ServiceCenterManageController@index')->name('service-center.manage.index');

      	Route::get('get-service-center-data', 'ServiceCenterManageController@getServiceCenterData')->name('service-center.manage.index');

      	Route::get('get-service-center-by-id', 'ServiceCenterManageController@getServiceCenterById')->name('service-center.manage.index');

      	Route::get('getAllDistrict', 'ServiceCenterManageController@getAllDistrict')->name('service-center.manage.index');

      	Route::get('getAllCitiesByDistrict', 'ServiceCenterManageController@getAllCitiesByDistrict')->name('service-center.manage.index');
		
		Route::post('upload', 'ServiceCenterManageController@upload')->name('service-center.manage.upload');

		Route::post('edit', 'ServiceCenterManageController@edit')->name('service-center.manage.index');

    });

});
