<?php


/*
|--------------------------------------------------------------------------
| Work Request Routes
|--------------------------------------------------------------------------
|
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web']], function()
{
    Route::group(['prefix' => 'workrequest','middleware' => ['permission:workrequest'], 'namespace' => 'App\Modules\WorkRequestManage\Controllers'], function(){

      	Route::get('index', 'WorkRequestController@index')->name('workrequest.manage.index');

      	Route::get('get-work-data', 'WorkRequestController@getWorkData')->name('workrequest.manage.index');

      	Route::get('create', 'WorkRequestController@createView')->name('workrequest.manage.index');

      	Route::post('create', 'WorkRequestController@createWork')->name('workrequest.manage.index');

      	Route::post('approve', 'WorkRequestController@approveWork')->name('workrequest.manage.index');

      	Route::post('reject', 'WorkRequestController@rejectWork')->name('workrequest.manage.index');

      	Route::post('create-job', 'WorkRequestController@createJob')->name('workrequest.manage.index');

    });

});
