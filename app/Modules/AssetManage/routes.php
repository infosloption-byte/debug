<?php


/*
|--------------------------------------------------------------------------
| Asset Managment Routes
|--------------------------------------------------------------------------
|
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web']], function()
{
    Route::group(['prefix' => 'asset','middleware' => ['permission:asset'], 'namespace' => 'App\Modules\AssetManage\Controllers'], function(){

      	Route::get('index', 'AssetManageController@index')->name('asset.manage.index');

      	Route::get('get-asset-data', 'AssetManageController@getAssetData')->name('asset.manage.index');
        Route::get('get-asset-data-to-activate', 'AssetManageController@getAssetDataToActivate')->name('asset.manage.index');

      	Route::get('view/{id}', 'AssetManageController@viewAssetDetails')->name('asset.manage.index');
      	
      	Route::get('getAssetsByCategoryId', 'AssetManageController@getAssetsByCategoryId')->name('asset.manage.index');

      	Route::get('assign', 'AssetManageController@assignView')->name('asset.manage.assign');

      	Route::get('transfer', 'AssetManageController@transferView')->name('asset.manage.transfer');

      	Route::post('upload', 'AssetManageController@uploadAssets')->name('asset.manage.index');

    });

});
