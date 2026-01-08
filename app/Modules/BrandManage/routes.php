<?php


/*
|--------------------------------------------------------------------------
| Brand Managment Routes
|--------------------------------------------------------------------------
|
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web']], function()
{
    Route::group(['prefix' => 'brand','middleware' => ['permission:brand'], 'namespace' => 'App\Modules\BrandManage\Controllers'], function(){

      	Route::get('index', 'BrandManageController@index')->name('brand.manage.index');

      	Route::get('get-brand-data', 'BrandManageController@getBrandData')->name('brand.manage.index');

      	Route::get('get-brand-by-id', 'BrandManageController@getBrandById')->name('brand.manage.index');
		
		Route::post('upload', 'BrandManageController@upload')->name('brand.manage.index');

		Route::post('edit', 'BrandManageController@edit')->name('brand.manage.index');

    });

});
