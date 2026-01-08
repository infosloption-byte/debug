<?php


/*
|--------------------------------------------------------------------------
| Service Managment Routes
|--------------------------------------------------------------------------
|
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web']], function()
{
    Route::group(['prefix' => 'service','middleware' => ['permission:service'], 'namespace' => 'App\Modules\ServiceManage\Controllers'], function(){

      	Route::get('index', 'ServiceManageController@index')->name('service.manage.index');

      	Route::get('get-service-data', 'ServiceManageController@getServiceData')->name('service.manage.index');

      	Route::get('get-service-types', 'ServiceManageController@getServiceTypes')->name('service.manage.index');

      	Route::get('get-service-providers', 'ServiceManageController@getServiceProviders')->name('service.manage.index');

      	Route::post('complete-service', 'ServiceManageController@completeService')->name('service.manage.index');

    });

});
