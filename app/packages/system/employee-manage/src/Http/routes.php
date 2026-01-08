<?php
/**
 * All Hail Dev Master
 *
 * @version 1.0.0
 * @author Dev Master Dev++ <devmaster@gmail.com>
 * @copyright 2019 Dev Master Dev++
 */


Route::group(['middleware' => ['web']], function()
{
    Route::group(['prefix' => 'employee','middleware' => ['permission:employee'], 'namespace' => 'System\Employee\Http\Controllers'], function(){

        Route::get('list', 'EmployeeController@listView')->name('employee.list');

        Route::post('create', 'EmployeeController@create')->name('employee.create');
      
        Route::post('update', 'EmployeeController@update')->name('employee.update');

        Route::post('upload', 'EmployeeController@upload')->name('employee.create');

        Route::post('delete', 'EmployeeController@delete')->name('employee.delete');
      
        Route::post('deleteWithRelations', 'EmployeeController@deleteWithRelations')->name('employee.delete');
        //AJAX
        Route::get('getroles', 'EmployeeController@getroles')->name('employee.list');
      
        Route::get('getemployee', 'EmployeeController@getemployee')->name('employee.list');

        Route::get('getDepartments', 'EmployeeController@getDepartments')->name('employee.list');
        
        Route::get('getEmployeeHierarchy', 'EmployeeController@getEmployeeHierarchy')->name('employee.list');
        
        Route::get('getSupervisors', 'EmployeeController@getSupervisors')->name('employee.list');

    });
});