<?php

Route::group(['middleware' => ['web']], function()
{
    Route::group(['prefix' => 'crud', 'namespace' => 'System\CrudGenerator\Http\Controllers'], function(){

      	Route::get('index', 'CrudController@index')->name('crud.index');

      	Route::post('index', 'CrudController@genrate')->name('crud.index');

    });

});

