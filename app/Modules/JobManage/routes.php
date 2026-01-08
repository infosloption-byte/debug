<?php


/*
|--------------------------------------------------------------------------
| Job Managment Routes
|--------------------------------------------------------------------------
|
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web']], function()
{
    Route::group(['prefix' => 'job','middleware' => ['permission:job'], 'namespace' => 'App\Modules\JobManage\Controllers'], function(){

      	Route::get('index', 'JobManageController@index')->name('job.manage.index');

      	Route::get('get-job-data', 'JobManageController@getJobData')->name('job.manage.index');

      	Route::post('finish-job', 'JobManageController@finishJob')->name('job.manage.index');

      	Route::post('create-service', 'JobManageController@createService')->name('job.manage.index');

      	Route::post('save-material-request', 'JobManageController@saveMaterialRequest')->name('job.manage.index');

      	Route::post('start-clock/{id}', 'JobManageController@startJobClock')->name('job.manage.index');

      	Route::post('stop-clock/{id}', 'JobManageController@stopJobClock')->name('job.manage.index');

    });

});
