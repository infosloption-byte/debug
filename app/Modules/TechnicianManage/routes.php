<?php


/*
|--------------------------------------------------------------------------
| Technician Managment Routes
|--------------------------------------------------------------------------
|
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web']], function()
{
    Route::group(['prefix' => 'technician','middleware' => ['permission:technician'], 'namespace' => 'App\Modules\TechnicianManage\Controllers'], function(){

      	Route::get('index', 'TechnicianManageController@index')->name('technician.manage.index');

      	Route::get('get-technician-data', 'TechnicianManageController@getTechnicianData')->name('technician.manage.index');

      	Route::get('get-technician-by-id', 'TechnicianManageController@getTechnicianById')->name('technician.manage.index');

      	Route::get('getAllTechnicians', 'TechnicianManageController@getAllTechnicians')->name('technician.manage.index');

      	Route::get('getAllServiceCenters', 'TechnicianManageController@getAllServiceCenters')->name('technician.manage.index');
		
		Route::post('upload', 'TechnicianManageController@upload')->name('technician.manage.upload');

		Route::post('edit', 'TechnicianManageController@edit')->name('technician.manage.index');

    });

});
