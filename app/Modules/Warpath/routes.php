<?php


/*
|--------------------------------------------------------------------------
| Daily Plan Managment Routes
|--------------------------------------------------------------------------
|
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web']], function()
{
    Route::group(['prefix' => 'warpath','middleware' => ['permission:my.organization'], 'namespace' => 'App\Modules\Warpath\Controllers'], function(){

      Route::get('index/{id}', 'WarpathController@index')->name('warpath.manage.view');

      Route::get('index', 'WarpathController@indexPrent')->name('warpath.manage.view');

      Route::get('getChilds', 'WarpathController@getChilds')->name('warpath.manage.view');


    });

});
