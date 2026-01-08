<?php


/*
|--------------------------------------------------------------------------
| Location Managment Routes
|--------------------------------------------------------------------------
|
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web']], function()
{
    Route::group(['prefix' => 'location','middleware' => ['permission:location'], 'namespace' => 'App\Modules\LocationManage\Controllers'], function(){

      	Route::get('list', 'LocationManageController@listView')->name('location.list');

      	Route::post('create', 'LocationManageController@create')->name('location.create');
      
      	Route::post('update', 'LocationManageController@update')->name('location.update');

      	Route::post('delete', 'LocationManageController@delete')->name('location.delete');

      	Route::post('delete/withreleated', 'LocationManageController@deleteWithreleated')->name('location.delete');
      
        Route::get('getLocations', 'LocationManageController@getLocations')->name('location.list');

        Route::get('getLocationTypes', 'LocationManageController@getLocationTypes')->name('location.list');

        Route::get('getParentLocationsByType', 'LocationManageController@getParentLocationsByType')->name('location.list');

      	Route::get('getLocationsByType', 'LocationManageController@getLocationsByType')->name('location.list');
     
        Route::get('getLocation', 'LocationManageController@getLocation')->name('location.list');
        
        Route::get('getLocationHierarchy', 'LocationManageController@getLocationHierarchy')->name('location.list');

        Route::get('getAllSubLocationIds', 'LocationManageController@getAllSubLocationIds')->name('location.list');

        Route::get('getLocationFlatHierarchy', 'LocationManageController@getLocationFlatHierarchy')->name('location.list');

        Route::get('getLocationFlatHierarchyObject', 'LocationManageController@getLocationFlatHierarchyObject')->name('location.list');

      	Route::get('checkLoactionIsLastNode', 'LocationManageController@checkLoactionIsLastNode')->name('location.list');

        Route::get('assignEmployeeToLocationView', 'LocationManageController@assignEmployeeToLocationView')->name('location.list');

        Route::get('getEmployeesByLocationType', 'LocationManageController@getEmployeesByLocationType')->name('location.list');

        Route::get('getSalesReps', 'LocationManageController@getSalesRep')->name('location.list');

        Route::get('checkLocationAssignedDetails', 'LocationManageController@checkLocationAssignedDetails')->name('location.list');

    });

    Route::group(['prefix' => 'location/type','middleware' => ['permission:location.type'], 'namespace' => 'App\Modules\LocationManage\Controllers'], function(){

      	Route::get('list', 'LocationTypeManageController@listView')->name('location.type.list');

      	Route::post('create', 'LocationTypeManageController@create')->name('location.type.create');
      
      	Route::post('update', 'LocationTypeManageController@update')->name('location.type.update');

      	Route::post('delete', 'LocationTypeManageController@delete')->name('location.type.delete');

      	Route::post('delete/withreleated', 'LocationTypeManageController@deleteWithreleated')->name('location.type.delete');
      
      	Route::get('getParentType', 'LocationTypeManageController@getParentType')->name('location.type.list');

      	Route::get('getLocationTypes', 'LocationTypeManageController@getLocationTypes')->name('location.type.list');
     
      	Route::get('getLocationTypeById', 'LocationTypeManageController@getLocationType')->name('location.type.list');
    });

});
