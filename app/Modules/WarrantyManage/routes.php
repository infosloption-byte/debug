<?php


/*
|--------------------------------------------------------------------------
| Warranty Managment Routes
|--------------------------------------------------------------------------
|
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web']], function()
{
    Route::group(['prefix' => 'warranty','middleware' => ['permission:warranty'], 'namespace' => 'App\Modules\WarrantyManage\Controllers'], function(){

      	Route::get('index', 'WarrantyManageController@index')->name('warranty.manage.index');

      	Route::post('activate', 'WarrantyManageController@activateWarranty')->name('warranty.manage.index');

    });

});
