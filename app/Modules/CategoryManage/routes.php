<?php


/*
|--------------------------------------------------------------------------
| Category Managment Routes
|--------------------------------------------------------------------------
|
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web']], function()
{
    Route::group(['prefix' => 'category','middleware' => ['permission:category'], 'namespace' => 'App\Modules\CategoryManage\Controllers'], function(){

      	Route::get('index', 'CategoryManageController@index')->name('category.manage.index');

      	Route::get('preventive-service', 'CategoryManageController@viewPreventiveService')->name('category.manage.index');

      	Route::get('get-category-data', 'CategoryManageController@getCategoryData')->name('category.load.category');
      	
      	Route::get('getCategoriesByMainId', 'CategoryManageController@getCategoriesByMainId')->name('category.load.category');
        
        Route::get('getAllMainCategories', 'CategoryManageController@getAllMainCategories')->name('category.load.category');
      	
      	Route::get('getAllCategories', 'CategoryManageController@getAllCategories')->name('category.load.category');
        

      	Route::post('upload', 'CategoryManageController@upload')->name('category.manage.upload');

    });

});
