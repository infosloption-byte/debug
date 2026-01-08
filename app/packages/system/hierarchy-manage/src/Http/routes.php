<?php
/**
 * EMPLOYEE HIERARCHY MANAGEMENT ROUTES
 *
 * @version 1.0.0
 * @author 
 * @copyright 
 *
 * EMPLOYEE HIERARCHY MIDDLEWARE
 */
Route::group(['middleware' => ['web']], function()
{
    Route::group(['prefix' => 'hierarchy', 'namespace' => 'System\Hierarchy\Http\Controllers'], function(){

      	Route::get('list', 'HierarchyController@listView')->name('hierarchy.list');

      	Route::get('getHierarchy', 'HierarchyController@getHierarchy')->name('hierarchy.list');

      	Route::get('getAllHierarchyByDepartment', 'HierarchyController@getAllHierarchyByDepartment')->name('hierarchy.list');

      	Route::get('getDistributionHierarchy', 'HierarchyController@getDistributionHierarchy')->name('hierarchy.list');

      	Route::get('getDriverEmployees', 'HierarchyController@getDriverEmployees')->name('hierarchy.list');

      	Route::post('create', 'HierarchyController@create')->name('hierarchy.list');
      
      	Route::post('update', 'HierarchyController@update')->name('hierarchy.list');

      	Route::post('delete', 'HierarchyController@delete')->name('hierarchy.list');

    });
});