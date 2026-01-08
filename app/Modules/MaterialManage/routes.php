<?php


/*
|--------------------------------------------------------------------------
| Material Managment Routes
|--------------------------------------------------------------------------
|
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web']], function()
{
    Route::group(['prefix' => 'material','middleware' => ['permission:material'], 'namespace' => 'App\Modules\MaterialManage\Controllers'], function(){

      	Route::get('index', 'MaterialManageController@index')->name('material.manage.index');

      	Route::get('list', 'MaterialManageController@list')->name('material.manage.index');

      	Route::get('material-data', 'MaterialManageController@getMaterialData')->name('material.manage.index');

      	Route::get('get-request-data', 'MaterialManageController@getMaterialRequestData')->name('material.manage.index');

      	Route::post('approve/{id}', 'MaterialManageController@approveMaterialRequest')->name('material.manage.index');

      	Route::post('reject/{id}', 'MaterialManageController@rejectMaterialRequest')->name('material.manage.index');

      	Route::post('upload', 'MaterialManageController@uploadMaterial')->name('material.manage.index');

    });

});
