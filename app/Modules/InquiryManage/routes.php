<?php


/*
|--------------------------------------------------------------------------
| Inquiry Managment Routes
|--------------------------------------------------------------------------
|
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web']], function()
{
    Route::group(['prefix' => 'inquiry','middleware' => ['permission:inquiry'], 'namespace' => 'App\Modules\InquiryManage\Controllers'], function(){

      	Route::get('index', 'InquiryManageController@index')->name('inquiry.manage.index');

      	Route::get('get-inquiry-data', 'InquiryManageController@getInquiryData')->name('inquiry.manage.index');

      	Route::get('create', 'InquiryManageController@createView')->name('inquiry.manage.index');

      	Route::post('create', 'InquiryManageController@createInquiry')->name('inquiry.manage.index');

      	Route::post('approve', 'InquiryManageController@approveInquiry')->name('inquiry.manage.index');

      	Route::post('reject', 'InquiryManageController@rejectInquiry')->name('inquiry.manage.index');

      	Route::post('create-job', 'InquiryManageController@createJob')->name('inquiry.manage.index');

    });

});
